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
                "PC",
                "Laptop",
                "Router",
                "Firewall",
                "Switch",
                "Modem",
                "Communication Cabinet",
                "Server Cabinet",
            ],
            "Digital Asset" => [
                "License"
            ],
        ];

        foreach ($assetTypes as $type => $items) {
            foreach ($items as $name) {
                AssetCategory::updateOrInsert(
                    [
                        'type' => $type,
                        'name' => $name,
                    ],
                    [
                        'requested_by' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
