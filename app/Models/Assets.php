<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Assets extends Model
{
    protected $table = 'assets';

    protected $fillable = [
        'created_by',
        'vendor_id',
        'asset_id',
        'asset_tag',
        'asset_name',
        'asset_category',
        'asset_type',
        'operational_status',
        'assigned_to',
        'department',
        'location',
        'purchase_date',
        'purchase_cost',
        'useful_life_years',
        'salvage_value',
        'compliance_status',
        'warranty_start',
        'warranty_end',
        'next_maintenance',
        'last_maintenance',
        'status',
        'delete_title',
        'delete_reason'
    ];

    protected $casts = [
        'purchase_date'     => 'date',
        'warranty_start'    => 'date',
        'warranty_end'      => 'date',
        'next_maintenance'  => 'date',
        'last_maintenance'  => 'date',
        'purchase_cost'     => 'decimal:2',
        'salvage_value'     => 'decimal:2',
    ];

    public function technicalSpecifications()
    {
        return $this->hasMany(TechnicalSpecification::class, 'asset_id');
    }

    public function logs()
    {
        return $this->hasMany(AssetLogs::class, 'asset_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'asset_tag', 'asset_tag');
    }

    public function documents()
    {
        return $this->hasMany(DocumentsAsset::class, 'asset_id', 'id');
    }

    public static function updateComplianceStatus()
    {
        $assets = self::all();

        foreach ($assets as $asset) {
            $isNonCompliant = false;
            if ($asset->asset_type === 'Physical Asset' && $asset->warranty_end) {
                if (Carbon::now()->gt(Carbon::parse($asset->warranty_end))) {
                    $isNonCompliant = true;
                }
            }

            if ($asset->asset_type === 'Digital Asset') {
                if ($asset->warranty_end && Carbon::now()->gt(Carbon::parse($asset->warranty_end))) {
                    $isNonCompliant = true;
                }
            }

            $asset->compliance_status = $isNonCompliant ? 'Non-Compliant' : 'Compliant';
            $asset->save();
        }
    }
}
