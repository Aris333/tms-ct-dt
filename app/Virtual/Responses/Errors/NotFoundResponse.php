<?php

namespace App\Virtual\Responses\Errors;

/**
 * @OA\Schema(
 *     title="Not Found response",
 *     description="Model not found response.",
 *     @OA\Xml(
 *         name="NotFoundResponse"
 *     )
 * )
 */
class NotFoundResponse
{
    /**
     * @OA\Property(
     *     title="Message",
     *     description="Error message",
     *     format="string",
     *     example="Not Found"
     * )
     *
     * @var string
     */
    public $message;
}
