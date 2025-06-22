<?php

namespace  App\Http\Controllers;

use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TMS\Traits\ApiResponseTrait;
use TMS\Enums\ResponseMessage;
use TMS\Resources\TranslationResource;
use TMS\Repositories\Translation\TranslationRepositoryInterface;
use TMS\ValidationRequests\CreateTranslationRequest;
use TMS\ValidationRequests\UpdateTranslationRequest;
use Symfony\Component\HttpFoundation\Response;

class TranslationController extends Controller
{
    protected $translationRepository;
    use ApiResponseTrait;

    public function __construct(TranslationRepositoryInterface $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }


    /**
     * Get Translations List.
     *
     * @OA\Get(
     *     path="/api/locales/{locale}/translations",
     *     summary="Get Translations List",
     *     description="Returns list of translations for a locale",
     *     tags={"Translation"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="locale",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search translations",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="List of translations")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *     )
     * )
     */
    public function index(Locale $locale, Request $request)
    {
        $clients = $this->translationRepository->getTranslations($locale, $request);
        return $this->successResponse(TranslationResource::collection($clients), ResponseMessage::OK, Response::HTTP_OK);
    }

    /**
     * Save New Translation
     *
     * @OA\Post(
     *     path="/api/locales/{locale}/translations",
     *     summary="Add Translation",
     *     tags={"Translation"},
     *     description="Add a new translation",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="locale",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"key", "content"},
     *                 @OA\Property(property="key", type="string", description="Translation key"),
     *                 @OA\Property(property="content", type="string", description="Translation content"),
     *                 @OA\Property(property="tag", type="string", description="Translation tag")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Error")
     * )
     */
    public function store(CreateTranslationRequest $request, Locale $locale)
    {
        $data = $request->prepareRequest();
        $client = $this->translationRepository->create($locale, $data);
        return $this->successResponse(new TranslationResource($client), ResponseMessage::OK, Response::HTTP_OK);
    }

    /**
     * Update Translation
     *
     * @OA\Put(
     *     path="/api/locales/{locale}/translations/{translation}",
     *     summary="Update Translation",
     *     tags={"Translation"},
     *     description="Update an existing translation",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="locale",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="translation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="key", type="string", description="Translation key"),
     *                 @OA\Property(property="content", type="string", description="Translation content"),
     *                 @OA\Property(property="tag", type="string", description="Translation tag")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Error")
     * )
     */
    public function update(UpdateTranslationRequest $request, Locale $locale, Translation $translation)
    {
        $data = $request->prepareRequest();
        $client = $this->translationRepository->update($locale, $translation, $data);
        return $this->successResponse(new TranslationResource($client), ResponseMessage::OK, Response::HTTP_OK);
    }

    /**
     * Delete Translation
     *
     * @OA\Delete(
     *     path="/api/locales/{locale}/translations/{translation}",
     *     summary="Delete Translation",
     *     description="Deletes a specific translation",
     *     tags={"Translation"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="locale",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="translation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation Deleted!",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Translation Deleted!")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy(Locale $locale, Translation $translation)
    {
        $this->translationRepository->deleteTranslation($locale, $translation);
        return $this->successResponse('', ResponseMessage::OK, Response::HTTP_OK);
    }


    public function export(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'locale' => 'required|string|max:10',
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $locale = $request->get('locale');
        $tags = $request->get('tags', []);

        $exportData = $this->translationRepository->getTranslationsForExport($locale, $tags);

        return response()->json($exportData);
    }
}
