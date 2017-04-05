<?php

use Illuminate\Database\Seeder;
use ComradesServiceProxy\Seeders\SettingsSeeder;

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
        $this->call(ComradesServiceProxy\Seeders\SettingsSeeder::class);
        Model::reguard();
    }
}
