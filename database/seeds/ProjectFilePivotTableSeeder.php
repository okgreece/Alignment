<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectFilePivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $projects = Project::all();
        foreach ($projects as $project) {
            $source = $project->source;

            $target = $project->target;

            $source->projects()->attach($project->id);
            $target->projects()->attach($project->id);
        }
    }
}
