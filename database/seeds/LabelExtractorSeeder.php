<?php

use Illuminate\Database\Seeder;

use App\LabelExtractor;

class LabelExtractorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('label_extractors')->truncate();
        $label1 = new LabelExtractor();
        $label1->enabled = true;
        $label1->priority = 1;
        $label1->property = "skos:prefLabel";
        $label1->save();

        $label2 = new LabelExtractor();
        $label2->enabled = true;
        $label2->priority =2;
        $label2->property = "rdfs:label";
        $label2->save();
    }
}
