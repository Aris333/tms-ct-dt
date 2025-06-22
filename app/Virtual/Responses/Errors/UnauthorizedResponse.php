<?php

namespace App\Virtual\Responses\Errors;

/**
 * @OA\Schema(
 *     title="Unauthorized response",
 *     description="Unauthorized response.",
 *     @OA\Xml(
 *         name="UnauthorizedResponse"
 *     )
 * )
 */
class UnauthorizedResponse
{
    /**
     * @OA\Property(
     *     title="Message",
     *     description="Error message",
     *     format="string",
     *     example="Unauthorized"
     * )
     *
     * @var string
     */
    public $message;
}
