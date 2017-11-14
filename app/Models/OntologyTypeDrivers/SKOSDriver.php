<?php

namespace App\Models\OntologyTypeDrivers;

use App\Models\OntologyTypeDriver;

class SKOSDriver extends OntologyTypeDriver
{
    const id = "SKOS";

    const name = "SKOS Driver";

    const description = "" ;

    const root = "skos:ConceptScheme";

    const firstLevelPath = "^skos:topConceptOf";

    const inverseFirstLevelPath = "skos:hasTopConcept";

    const secondLevelPath = "skos:narrower";

    const inverseSecondLevelPath = "^skos:broader";
}
