<?php

namespace App\Virtual\Responses\Errors;

/**
 * @OA\Schema(
 *     title="Bad Request response",
 *     description="Bad Request response",
 *     @OA\Xml(
 *         name="BadRequestResponse"
 *     )
 * )
 */
class BadRequestResponse
{
    /**
     * @OA\Property(
     *     title="Message",
     *     description="Error message",
     *     format="string",
     *     example="Bad Request"
     * )
     *
     * @var string
     */
    public $message;
}
