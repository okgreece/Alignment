<?php

use App\File;
use App\Project;
use Illuminate\Database\Seeder;

class TestProject extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path().'/app/test/';

        $source = new File();
        $source->filetype = 'ntriples';
        $source->public = 1;
        $source->user_id = 1;
        $tmpFilePath = sys_get_temp_dir().'/stw.nt';
        copy($path.'stw.nt', $tmpFilePath);
        $source->resource = $tmpFilePath;
        $source->save();

        $target = new File();
        $target->filetype = 'ntriples';
        $target->public = 1;
        $target->user_id = 1;
        $tmpFilePath = sys_get_temp_dir().'/jel.nt';
        copy($path.'jel.nt', $tmpFilePath);
        $target->resource = $tmpFilePath;
        $target->save();

        $project = new Project();
        $project->user_id = 1;
        $project->source_id = $source->id;
        $project->target_id = $target->id;
        $project->public = 1;
        $project->settings_id = 1;
        $project->name = 'SWT to JEL test project';
        $project->save();
    }
}
