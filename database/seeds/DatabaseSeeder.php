<?php

use Illuminate\Database\Seeder;
use ComradesYodieProxy\Seeders\SettingsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();
        $this->call(ComradesYodieProxy\Seeders\SettingsSeeder::class);
        Model::reguard();
    }
}
