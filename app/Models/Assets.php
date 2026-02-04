<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Assets extends Model
{
    protected $table = 'assets';

    protected $fillable = [
        'created_by',
        'vendor',
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
        'status',
        'documents',
    ];

    protected $casts = [
        'purchase_date'     => 'date',
        'warranty_start'    => 'date',
        'warranty_end'      => 'date',
        'next_maintenance'  => 'date',
        'purchase_cost'     => 'decimal:2',
        'salvage_value'     => 'decimal:2',
    ];

    public function technicalSpecifications()
    {
        return $this->hasMany(TechnicalSpecification::class, 'asset_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor');
    }
}
