<?php

namespace App\Models\OntologyTypeDrivers;

use App\Models\OntologyTypeDriver;

class OWLDriver extends OntologyTypeDriver
{
    const id = 'OWL';

    const name = 'OWL Driver';

    const description = '';

    const root = 'owl:Ontology';

    const firstLevelPath = 'rdfs:subClassOf';

    const inverseFirstLevelPath = '^rdfs:subClassOf';

    const secondLevelPath = 'rdfs:subClassOf';

    const inverseSecondLevelPath = '^rdfs:subClassOf';

//    protected $firstLevel = [
//        [
//            "class" => "owl:Class",
//            "restriction" => "rdfs:subClassOf",
//            "firstLevelPath" => "rdfs:subClassOf"
//        ],
//        [
//            "class" => "owl:ObjectProperty",
//            "restriction" => "rdfs:subPropertyOf",
//            "firstLevelPath" => "rdfs:subPropertyOf"
//        ]
//    ];
//
//
//
//    protected $firstLevelPath = null;
//
//    protected $inverseFirstLevelPath = null;
//
//    protected $secondLevelPath = null;
//
//    protected $inverseSecondLevelPath = null;
}
