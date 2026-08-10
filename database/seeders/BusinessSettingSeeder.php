<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use Illuminate\Database\Seeder;

class BusinessSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'business_name' => 'Mi Negocio',
            'business_address' => 'Santa Ana, El Salvador',
            'business_phone' => '0000-0000',
            'business_email' => 'info@minegocio.com',
            'business_logo' => null,
            'receipt_footer' => '¡Gracias por su compra!',
            'tax_rate' => '0',
            'tax_name' => 'IVA',
            'currency_symbol' => '$',
            'currency_code' => 'USD',
            'receipt_paper_size' => '80',
        ];

        foreach ($settings as $key => $value) {
            BusinessSetting::create(['key' => $key, 'value' => $value]);
        }
    }
}
