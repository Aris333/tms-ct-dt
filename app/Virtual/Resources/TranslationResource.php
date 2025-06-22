<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="TranslationResource",
 *     description="TranslationResource resource",
 *     @OA\Xml(
 *         name="TranslationResource"
 *     )
 * )
 */
class TranslationResource
{
    /**
     * @OA\Property(
     *     title="VendorTradeListingWantHistoryItem",
     *     description="List of VendorTradeListingWantHistoryItem"
     * )
     *
     * @var \App\Virtual\Models\Translation[]
     */
    private $data;
}
