<?php

namespace App\Virtual\Responses;

/**
 * @OA\Schema(
 *     title="Locale Items",
 *     description="Paginated Locale items response",
 *     @OA\Xml(
 *         name="LocaleResponse"
 *     )
 * )
 */
class LocaleResponse
{
    /**
     * @OA\Property(
     *     title="Locale items",
     *     description="Array of Locale item",
     * )
     *
     * @var \App\Virtual\Models\Locale[]
     */
    public $items;

    /**
     * @OA\Property(
     *      title="Total count",
     *      description="Total number of Locale items",
     *      example="125",
     *      type="int"
     * )
     */
    public $total_count;

    /**
     * @OA\Property(
     *      title="Per page",
     *      description="Number of items per page",
     *      example="25",
     *      type="int"
     * )
     */
    public $per_page;
}
