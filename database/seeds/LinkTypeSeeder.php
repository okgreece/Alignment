<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LinkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('link_types')->insert(
        [
            //SKOS
        [
            'user_id' => 0,
            'group' => "SKOS",
            'inner' => "Exact Match",
            'value' => "http://www.w3.org/2004/02/skos/core#exactMatch",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => "SKOS",
            'inner' => "Narrow Match",
            'value' => "http://www.w3.org/2004/02/skos/core#narrowMatch",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => "SKOS",
            'inner' => "Broad Match",
            'value' => "http://www.w3.org/2004/02/skos/core#broadMatch",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => "SKOS",
            'inner' => "Related Match",
            'value' => "http://www.w3.org/2004/02/skos/core#relatedMatch",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => "SKOS",
            'inner' => "Close Match",
            'value' => "http://www.w3.org/2004/02/skos/core#closeMatch",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
            
            //OWL
        [
            'user_id' => 0,
            'group' => "OWL",
            'inner' => "Same as",
            'value' => "http://www.w3.org/2002/07/owl#sameAs",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => "OWL",
            'inner' => "See also",
            'value' => "http://www.w3.org/2002/07/owl#seeAlso",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => "OWL",
            'inner' => "Exact Match",
            'value' => "http://www.w3.org/2002/07/owl#equivalentClass",
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
            //RDFS
        
            ]);
    
    }
}