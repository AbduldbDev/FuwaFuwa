<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'asset_tag'            => $this->asset_tag,
            'asset_name'           => $this->asset_name,
            'asset_category'       => $this->asset_category,
            'asset_type'           => $this->asset_type,
            'operational_status'   => $this->operational_status,
            'assigned_to'          => $this->assigned_to,
            'department'           => $this->department,
            'location'             => $this->location,
            'vendor'               => $this->vendor,

            'purchase_date'        => $this->purchase_date,
            'purchase_cost'        => $this->purchase_cost,
            'useful_life_years'    => $this->useful_life_years,
            'salvage_value'        => $this->salvage_value,

            'compliance_status'    => $this->compliance_status,
            'warranty_start'       => $this->warranty_start,
            'warranty_end'         => $this->warranty_end,
            'next_maintenance'     => $this->next_maintenance,

            'technical_specs'      => TechnicalSpecificationResource::collection(
                $this->whenLoaded('technicalSpecifications')
            ),

            'created_at'           => $this->created_at?->toDateTimeString(),
            'updated_at'           => $this->updated_at?->toDateTimeString(),
        ];
    }
}
