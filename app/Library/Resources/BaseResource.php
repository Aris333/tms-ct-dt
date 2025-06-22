<?php

namespace TMS\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public static function collection($resource)
    {
        return [
            'total' => $resource->total(),
            'total_pages' => $resource->lastPage(),
            'current_page' => $resource->currentPage(),
            'has_pages' => $resource->hasPages(),
            'has_more_pages' => $resource->hasMorePages(),
            'items' => parent::collection($resource),
        ];
    }
}
