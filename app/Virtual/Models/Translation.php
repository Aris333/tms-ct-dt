<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Translation",
 *     description="Translation model",
 *     @OA\Xml(
 *         name="Translation"
 *     )
 * )
 */
class Translation
{
    /**
     * @OA\Property(
     *     title="Tag",
     *     description="Translation tag",
     *     format="string",
     *     example="desktop"
     * )
     *
     * @var string
     */
    public $tag;

    /**
     * @OA\Property(
     *      title="key",
     *      description="Translation key",
     *      example="buying",
     *      type="string",
     *
     * )
     */
    public $key;

    /**
     * @OA\Property(
     *      title="Translation",
     *      description="Context of translation",
     *      example="User List",
     *      type="string",
     *
     * )
     */
    public $context;

    /**
     * @OA\Property(
     *     title="Langauge id",
     *     description="Locale id which translation list belongs to",
     *     example="1",
     *     type="int"
     * )
     */
    public $locale_id;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Date when payout method is created",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Last date when payout method is updated",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Date when payout method is deleted",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     */
    private $deleted_at;
}
