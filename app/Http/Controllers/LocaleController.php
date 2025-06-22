<?php

namespace  App\Http\Controllers;

use App\Models\Locale;
use TMS\Traits\ApiResponseTrait;
use TMS\Enums\ResponseMessage;
use TMS\Resources\LocaleResource;
use TMS\Repositories\Locale\LocaleRepositoryInterface;
use TMS\ValidationRequests\CreateLocaleRequest;
use TMS\ValidationRequests\UpdateLocaleRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Exception;

class LocaleController extends Controller
{
    protected $accountRepository;
    use ApiResponseTrait;

    public function __construct(LocaleRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Get Locales List.
     *
     * @OA\Get(
     *     path="/api/locales",
     *     summary="Get Locales List",
     *     description="Returns list of all locales",
     *     tags={"Locale"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="search",
     *         description="Search locale by name",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="List of locales")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *     )
     * )
     */
    public function index()
    {
        $clients = $this->accountRepository->fetch_all();
        return $this->successResponse(LocaleResource::collection($clients), ResponseMessage::OK, Response::HTTP_OK);
    }

    /**
     * Save New Locale
     *
     * @OA\Post(
     *     path="/api/locales",
     *     summary="Add Locale",
     *     tags={"Locale"},
     *     description="Add a new locale",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"name", "code"},
     *                 @OA\Property(property="name", type="string", description="Locale name"),
     *                 @OA\Property(property="code", type="string", description="Locale code like 'us', 'uae'")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Error")
     * )
     */
    public function store(CreateLocaleRequest $request)
    {
        $data = $request->prepareRequest();
        $client = $this->accountRepository->create($data);
        return $this->successResponse(new LocaleResource($client), ResponseMessage::OK, Response::HTTP_OK);
    }

    /**
     * Update Locale
     *
     * @OA\Put(
     *     path="/api/locales/{id}",
     *     summary="Update Locale",
     *     tags={"Locale"},
     *     description="Update an existing locale",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", description="Updated locale name"),
     *                 @OA\Property(property="code", type="string", description="Updated locale code")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Error")
     * )
     */
    public function update(UpdateLocaleRequest $request, $id)
    {
        $data = $request->prepareRequest();
        $client = $this->accountRepository->update($id, $data);
        return $this->successResponse(new LocaleResource($client), ResponseMessage::OK, Response::HTTP_OK);
    }

    /**
     * Delete Locale
     *
     * @OA\Delete(
     *     path="/api/locales/{id}",
     *     summary="Delete Locale",
     *     description="Delete a locale by ID",
     *     tags={"Locale"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Locale Deleted!",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Locale Deleted!")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy(Locale $locale)
    {
        $this->accountRepository->deleteLocale($locale);
        return $this->successResponse('', ResponseMessage::OK, Response::HTTP_OK);
    }
}
