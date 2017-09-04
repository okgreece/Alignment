<?php

use Illuminate\Database\Seeder;
use App\Models\SuggestionProvider;
class SuggestionProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $silk = new SuggestionProvider();
        $silk->name = "Silk";
        $silk->description = "The Silk Link Discovery Framework";
        $silk->configuration = "\App\Models\SuggestionConfigurations\SilkConfiguration";
        $silk->job = "\App\Jobs\RunSilk";
        $silk->save();
    }
}
