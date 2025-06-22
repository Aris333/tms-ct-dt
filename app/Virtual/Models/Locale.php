<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Locale",
 *     description="Locale model",
 *     @OA\Xml(
 *         name="Locale"
 *     )
 * )
 */
class Locale
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Locale name",
     *     format="string",
     *     example="Shoes I want"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Code",
     *     description="Locale code",
     *     format="string",
     *     example="us"
     * )
     *
     * @var string
     */
    public $code;

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
