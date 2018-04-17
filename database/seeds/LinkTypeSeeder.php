<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LinkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('link_types')->truncate();
        DB::table('link_types')->insert(
        [
            //SKOS
        [
            'user_id' => 0,
            'group' => 'SKOS',
            'inner' => 'Exact Match',
            'value' => 'http://www.w3.org/2004/02/skos/core#exactMatch',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'SKOS',
            'inner' => 'Narrow Match',
            'value' => 'http://www.w3.org/2004/02/skos/core#narrowMatch',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'SKOS',
            'inner' => 'Broad Match',
            'value' => 'http://www.w3.org/2004/02/skos/core#broadMatch',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'SKOS',
            'inner' => 'Related Match',
            'value' => 'http://www.w3.org/2004/02/skos/core#relatedMatch',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'SKOS',
            'inner' => 'Close Match',
            'value' => 'http://www.w3.org/2004/02/skos/core#closeMatch',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],

            //OWL
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Same As',
            'value' => 'http://www.w3.org/2002/07/owl#sameAs',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Disjoint With',
            'value' => 'http://www.w3.org/2002/07/owl#disjointWith',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Equivalent Class',
            'value' => 'http://www.w3.org/2002/07/owl#equivalentClass',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Complement Of',
            'value' => 'http://www.w3.org/2002/07/owl#complementOf',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Different From',
            'value' => 'http://www.w3.org/2002/07/owl#differentFrom',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Equivalent Property',
            'value' => 'http://www.w3.org/2002/07/owl#equivalentProperty',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'OWL',
            'inner' => 'Inverse Of',
            'value' => 'http://www.w3.org/2002/07/owl#inverseOf',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],

            //RDFS
        [
            'user_id' => 0,
            'group' => 'RDFS',
            'inner' => 'See Also',
            'value' => 'http://www.w3.org/2000/01/rdf-schema#seeAlso',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'RDFS',
            'inner' => 'Sub-class Of',
            'value' => 'http://www.w3.org/2000/01/rdf-schema#subClassOf',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'user_id' => 0,
            'group' => 'RDFS',
            'inner' => 'Sub Property Of',
            'value' => 'http://www.w3.org/2000/01/rdf-schema#subPropertyOf',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],

            ]);
    }
}
