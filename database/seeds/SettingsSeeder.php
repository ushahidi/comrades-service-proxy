<?php
namespace ComradesYodieProxy\Seeders;
use Illuminate\Database\Seeder;
use ComradesYodieProxy\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run() {
        Setting::firstOrCreate([
            'key' => 'platform_api_key',
            'value' => $this->container->config->get('platform_api_key')
        ]);

        Setting::firstOrCreate([
            'key' => 'platform_api_url',
            'value' => $this->container->config->get('platform_api_url')
        ]);
    }
}
