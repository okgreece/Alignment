<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'DEFAULT',
            'user_id' => 1,
            'public' => 1,
            'valid' => 1
        ]);
    }
}
