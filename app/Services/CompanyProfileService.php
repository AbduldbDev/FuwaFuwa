<?php

namespace App\Services;

use App\Models\CompanyProfile;

class CompanyProfileService
{
    public function updateOrCreate(array $data)
    {
        return CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => $data['company_name'],
                'brand_name' => $data['brand_name'],
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'],
            ]
        );
    }
}
