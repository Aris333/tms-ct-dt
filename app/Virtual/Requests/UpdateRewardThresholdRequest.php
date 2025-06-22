<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="Update Reward Threshold request",
 *     description="Update Reward Threshold request",
 *     @OA\Xml(
 *         name="UpdateRewardThresholdRequest"
 *     )
 * )
 */
class UpdateRewardThresholdRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Reward Threshold Name",
     *     format="string",
     *     maximum="32",
     *     example="Deadstock Hat"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Reward type",
     *     description="Reward Threshold Type",
     *     format="string",
     *     maximum="32",
     *     example="Additional Entries"
     * )
     *
     * @var string
     */
    public $reward_type;

    /**
     * @OA\Property(
     *     title="SKU",
     *     description="Reward Threshold SKU (Only if reward type is set to 'Free Sneakers')",
     *     format="string",
     *     maximum="32",
     *     example="CT8529-003"
     * )
     *
     * @var string
     */
    public $sku;

    /**
     * @OA\Property(
     *     title="Size",
     *     description="Reward Threshold Size (Only if reward type is set to 'Free Sneakers')",
     *     format="string",
     *     maximum="4",
     *     example="2"
     * )
     *
     * @var string
     */
    public $size;

    /**
     * @OA\Property(
     *     title="Redemption Points",
     *     description="Reward Threshold Redemption Points",
     *     format="int",
     *     example=1500
     * )
     *
     * @var int
     */
    public $redemption_points;

    /**
     * @OA\Property(
     *     title="Usage",
     *     description="Reward Threshold Usage",
     *     format="int",
     *     example=2
     * )
     *
     * @var int
     */
    public $usage;
}
