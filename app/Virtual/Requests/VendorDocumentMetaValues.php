<?php

namespace App\Virtual\Requests;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Vendor Document Meta Values",
 *     @OA\Xml(
 *         name="VendorDocumentMetaValues"
 *     )
 * )
 */
class VendorDocumentMetaValues
{
    /**
     * @OA\Property(
     *     property="expiration_date",
     *     title="Expiration Date",
     *     type="string",
     *     example="2022-12-31"
     * )
     * @var string
     */
    public string $expiration_date;

    /**
     * @OA\Property(
     *     property="seller_permit_no",
     *     title="Seller Permit Number",
     *     type="string"
     * )
     * @var string
     */
    public string $seller_permit_no;
}
