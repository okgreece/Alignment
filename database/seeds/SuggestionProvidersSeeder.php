<?php

use App\Models\SuggestionProvider;
use Illuminate\Database\Seeder;

class SuggestionProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suggestion_providers')->truncate();
        $silk = new SuggestionProvider();
        $silk->name = 'Silk';
        $silk->description = 'The Silk Link Discovery Framework';
        $silk->configuration = "\App\Models\SuggestionConfigurations\SilkConfiguration";
        $silk->job = "\App\Jobs\RunSilk";
        $silk->save();
    }
}
