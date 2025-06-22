<?php

namespace App\Virtual\Responses\Errors;

/**
 * @OA\Schema(
 *     title="Uprocessable entity response",
 *     description="Validation errors response.",
 *     @OA\Xml(
 *         name="CardCheckoutResponse"
 *     )
 * )
 */
class UnprocessableEntityResponse
{
    /**
     * @OA\Property(
     *     title="Message",
     *     description="Error message",
     *     format="string",
     *     example="The given data was invalid."
     * )
     *
     * @var string
     */
    public $message;

    /**
     * @OA\Property(
     *      title="Validation Errors",
     *      description="Validation errors for each field.",
     *      type="object",
     *      @OA\Property(
     *          property="field_name",
     *          description="Field name that has a validation error.",
     *          type="array",
     *          @OA\Items(type="string"),
     *          example={"The 'field_name' field is required.", "The 'field_name' must be at least 3 characters."},
     *      ),
     * )
     */
    public $errors;
}
