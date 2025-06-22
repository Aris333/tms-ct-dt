<?php

namespace App\Virtual\Responses\Errors;

/**
 * @OA\Schema(
 *     title="Internal Server Error response",
 *     description="Internal Server Error response",
 *     @OA\Xml(
 *         name="InternalServerError"
 *     )
 * )
 */
class InternalServerErrorResponse
{
    /**
     * @OA\Property(
     *     title="Message",
     *     description="Error message",
     *     format="string",
     *     example="Internal Server Error"
     * )
     *
     * @var string
     */
    public $message;
}
