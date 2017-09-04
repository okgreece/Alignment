<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestionProvider extends Model
{
    protected $fillable = [ "name", "description", "configuration"];

    public function validate(\App\Settings $settings){
        $configuration = new $this->configuration();
        $settings->valid = json_decode($configuration->validateSettingsFile($settings)->bag)->valid;
        $settings->save();
    }

    public function prepare(\App\Project $project){
        $configuration = new $this->configuration();
        $configuration->prepareProject($project);
    }


}
