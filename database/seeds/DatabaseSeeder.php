<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\ProjectFilePivotTableSeeder::class);
        $this->call(\SettingsSeeder::class);
        $this->call(\LinkTypeSeeder::class);
        $this->call(\LabelExtractorSeeder::class);
        $this->call(\SuggestionProvidersSeeder::class);
    }
}
