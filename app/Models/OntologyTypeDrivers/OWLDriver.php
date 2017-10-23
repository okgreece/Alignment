<?php

namespace App\Models\OntologyTypeDrivers;

class OWLDriver
{

    protected $name = "OWL Driver";

    protected $description = "" ;

    protected $root = "owl:Ontology";

    protected $firstLevel = [
        [
            "class" => "owl:Class",
            "restriction" => "rdfs:subClassOf",
            "firstLevelPath" => "rdfs:subClassOf"
        ],
        [
            "class" => "owl:ObjectProperty",
            "restriction" => "rdfs:subPropertyOf",
            "firstLevelPath" => "rdfs:subPropertyOf"
        ]
    ];



    protected $firstLevelPath = null;

    protected $inverseFirstLevelPath = null;

    protected $secondLevelPath = null;

    protected $inverseSecondLevelPath = null;
}
