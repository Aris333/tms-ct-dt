<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="Update Point Configuration request",
 *     description="Update Point Configuration request",
 *     @OA\Xml(
 *         name="UpdatePointConfigurationRequest"
 *     )
 * )
 */
class UpdatePointConfigurationRequest
{
    /**
     * @OA\Property(
     *     title="Description",
     *     description="Point Configuration Description",
     *     format="string",
     *     maximum="128",
     *     example="Sell a pair and win"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="Given At",
     *     description="Point Configuration Given At",
     *     format="string",
     *     maximum="32",
     *     example="Buy"
     * )
     *
     * @var string
     */
    public $given_at;

    /**
     * @OA\Property(
     *     title="Points Awarded ",
     *     description="Point Configuration Points Awarded",
     *     format="int",
     *     example=1000
     * )
     *
     * @var int
     */
    public $points_awarded;
}
