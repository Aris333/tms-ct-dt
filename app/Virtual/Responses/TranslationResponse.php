<?php

namespace App\Virtual\Responses;

/**
 * @OA\Schema(
 *     title="Translation Items",
 *     description="Paginated Translation items response",
 *     @OA\Xml(
 *         name="LanguageResponse"
 *     )
 * )
 */
class TranslationResponse
{
    /**
     * @OA\Property(
     *     title="Translation items",
     *     description="Array of Translation item",
     * )
     *
     * @var \App\Virtual\Models\Translation[]
     */
    public $items;

    /**
     * @OA\Property(
     *      title="Total count",
     *      description="Total number of Translation items",
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
