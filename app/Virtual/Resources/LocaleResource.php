<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="LocaleResource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="LocaleResource"
 *     )
 * )
 */
class LocaleResource
{
    /**
     * @OA\Property(
     *     title="UserList",
     *     description="List of Users"
     * )
     *
     * @var \App\Virtual\Models\Locale[]
     */
    public $results;
}
