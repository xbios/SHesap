<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'SHesap ERP',
                'group' => 'general',
                'type' => 'string',
                'label' => 'Uygulama Adı',
                'description' => 'Sistem genelinde görünen uygulama adı.'
            ],
            [
                'key' => 'company_name',
                'value' => 'SHesap Teknoloji A.Ş.',
                'group' => 'general',
                'type' => 'string',
                'label' => 'Firma Adı',
                'description' => 'Resmi firma ünvanı.'
            ],
            [
                'key' => 'logo_url',
                'value' => null,
                'group' => 'general',
                'type' => 'string',
                'label' => 'Logo URL',
                'description' => 'Uygulama logosunun yolu.'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'group' => 'system',
                'type' => 'boolean',
                'label' => 'Bakım Modu',
                'description' => 'Sistemi bakım moduna alır.'
            ],
            [
                'key' => 'items_per_page',
                'value' => '15',
                'group' => 'system',
                'type' => 'integer',
                'label' => 'Sayfa Başına Öğe',
                'description' => 'Listelerde sayfa başına gösterilecek öge sayısı.'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
