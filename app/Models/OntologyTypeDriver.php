<?php

namespace App\Models;
use App\Models\OntologyTypeDrivers\SKOSDriver;
class OntologyTypeDriver
{
    public static function Factory($type){
        switch ($type){
            case "SKOS":
                return new SKOSDriver();
                break;
            default:
                return new SKOSDriver();
        }
    }
}
