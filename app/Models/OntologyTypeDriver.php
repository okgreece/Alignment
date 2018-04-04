<?php

namespace App\Models;
use App\Models\OntologyTypeDrivers\SKOSDriver;
use App\Models\OntologyTypeDrivers\OWLDriver;
class OntologyTypeDriver
{
    public static function Factory($type){
        switch ($type){
            case "SKOS":
                return new SKOSDriver();
                break;
            case "OWL":
                return new OWLDriver();
            default:
                return new SKOSDriver();
        }
    }
}
