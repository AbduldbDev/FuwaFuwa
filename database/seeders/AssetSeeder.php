<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assets;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    public function run()
    {
        $assets = [
            [
                'created_by' => 1,
                'asset_id' => 'IT001',
                'asset_tag' => 'LP-001',
                'asset_name' => 'Laptop 1',
                'asset_category' => 'Laptop',
                'asset_type' => 'Electronics',
                'operational_status' => 'Operational',
                'assigned_to' => null,
                'department' => 'IT',
                'location' => 'Office 1',
                'vendor' => 'Dell',
                'purchase_date' => Carbon::now()->subMonths(12),
                'purchase_cost' => 100000,
                'useful_life_years' => 50,
                'salvage_value' => 20000,
                'compliance_status' => 'Compliant',
                'warranty_start' => Carbon::now()->subMonths(12),
                'warranty_end' => Carbon::now()->addMonths(24),
                'next_maintenance' => Carbon::now()->addMonths(6),
                'status' => 'active',
            ],
            [
                'created_by' => 1,
                'asset_id' => 'IT002',
                'asset_tag' => 'PC-001',
                'asset_name' => 'PC 1',
                'asset_category' => 'PC',
                'asset_type' => 'Electronics',
                'operational_status' => 'Operational',
                'assigned_to' => null,
                'department' => 'IT',
                'location' => 'Office 2',
                'vendor' => 'HP',
                'purchase_date' => Carbon::now()->subMonths(18),
                'purchase_cost' => 50000,
                'useful_life_years' => 50,
                'salvage_value' => 5000,
                'compliance_status' => 'Compliant',
                'warranty_start' => Carbon::now()->subMonths(18),
                'warranty_end' => Carbon::now()->addMonths(12),
                'next_maintenance' => Carbon::now()->addMonths(3),
                'status' => 'active',
            ],
            [
                'created_by' => 1,
                'asset_id' => 'IT003',
                'asset_tag' => 'MD-001',
                'asset_name' => 'Modem 1',
                'asset_category' => 'Modem',
                'asset_type' => 'Networking',
                'operational_status' => 'Operational',
                'assigned_to' => null,
                'department' => 'IT',
                'location' => 'Server Room',
                'vendor' => 'TP-Link',
                'purchase_date' => Carbon::now()->subMonths(6),
                'purchase_cost' => 8000,
                'useful_life_years' => 10,
                'salvage_value' => 800,
                'compliance_status' => 'Compliant',
                'warranty_start' => Carbon::now()->subMonths(6),
                'warranty_end' => Carbon::now()->addMonths(18),
                'next_maintenance' => Carbon::now()->addMonths(2),
                'status' => 'active',
            ],
            [
                'created_by' => 1,
                'asset_id' => 'IT004',
                'asset_tag' => 'MN-001',
                'asset_name' => 'Monitor 1',
                'asset_category' => 'Monitor',
                'asset_type' => 'Electronics',
                'operational_status' => 'Operational',
                'assigned_to' => null,
                'department' => 'IT',
                'location' => 'Office 1',
                'vendor' => 'Samsung',
                'purchase_date' => Carbon::now()->subMonths(10),
                'purchase_cost' => 20000,
                'useful_life_years' => 20,
                'salvage_value' => 2000,
                'compliance_status' => 'Compliant',
                'warranty_start' => Carbon::now()->subMonths(10),
                'warranty_end' => Carbon::now()->addMonths(14),
                'next_maintenance' => Carbon::now()->addMonths(4),
                'status' => 'active',
            ],
            [
                'created_by' => 1,
                'asset_id' => 'IT005',
                'asset_tag' => 'SRV-001',
                'asset_name' => 'Server 1',
                'asset_category' => 'Server',
                'asset_type' => 'Networking',
                'operational_status' => 'Operational',
                'assigned_to' => null,
                'department' => 'IT',
                'location' => 'Server Room',
                'vendor' => 'Dell',
                'purchase_date' => Carbon::now()->subMonths(24),
                'purchase_cost' => 300000,
                'useful_life_years' => 100,
                'salvage_value' => 50000,
                'compliance_status' => 'Compliant',
                'warranty_start' => Carbon::now()->subMonths(24),
                'warranty_end' => Carbon::now()->addMonths(36),
                'next_maintenance' => Carbon::now()->addMonths(6),
                'status' => 'active',
            ],
        ];

        foreach ($assets as $asset) {
            Assets::create($asset);
        }
    }
}
