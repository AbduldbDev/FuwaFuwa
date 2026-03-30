<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $assetTypes = [
            "Physical Asset" => [
                ["name" => "PC", "icon" => "fa-desktop"],
                ["name" => "Laptop", "icon" => "fa-laptop"],
                ["name" => "Router", "icon" => "fa-wifi"],
                ["name" => "Firewall", "icon" => "fa-shield-halved"],
                ["name" => "Switch", "icon" => "fa-network-wired"],
                ["name" => "Modem", "icon" => "fa-plug"],
                ["name" => "Communication Cabinet", "icon" => "fa-box"],
                ["name" => "Server Cabinet", "icon" => "fa-server"],
            ],
            "Digital Asset" => [
                ["name" => "License", "icon" => "fa-key"],
            ],
        ];

        foreach ($assetTypes as $type => $items) {
            foreach ($items as $item) {
                AssetCategory::updateOrInsert(
                    [
                        'type' => $type,
                        'name' => $item['name'],
                    ],
                    [
                        'requested_by' => 1,
                        'icon' => $item['icon'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
