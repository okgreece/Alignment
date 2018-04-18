<?php

namespace App\Http\Controllers;

use App\File;
use App\Jobs\InitiateCalculations;
use App\Project;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('myprojects', ['user' => $user]);
    }

    public function create(Request $request)
    {
        $input = request()->all();
        $this->validate($request, [
            'name' => 'required|unique:projects|max:255',
        ]);
        $project = Project::create($input);
        $source = $project->source;
        $target = $project->target;
        $source->projects()->attach($project->id);
        $target->projects()->attach($project->id);

        return redirect()->route('myprojects')->with('notification', 'Project created!!!');
    }

    public function show()
    {
        $id = request('project');
        $project = Project::find($id);
        //find valid files to create a project
        $user = User::find($project->user_id);
        $select = [];
        foreach ($user->files as $file) {
            if ($file->parsed) {
                $key = $file->id;
                $value = $file->resource_file_name;
                $select = array_add($select, $key, $value);
            }
        }
        //public files addition
        foreach (File::where('public', '=', '1')->get() as $file) {
            if ($file->parsed) {
                $key = $file->id;
                $value = $file->resource_file_name;
                $select = array_add($select, $key, $value);
            }
        }

        return view('projects.edit', ['project' => $project,
                                      'select' => $select,
            ]);
    }

    public function update(Request $request)
    {
        $input = request()->all();

        $project = Project::find($input['id']);

        $this->validate($request, [
            'name' => 'required|unique:projects,name,'.$project->id.'|max:255',
        ]);

        $project->fill($input)->save();

        return redirect()->route('myprojects')->with('notification', 'Project updated!!!');
    }

    public function destroy(Request $request, Project $project)
    {
        $this->authorize('destroy', $project);
        $project_links = $project->links;
        foreach ($project_links as $link) {
            $link->delete();
        }
        $project->delete();

        return redirect()->route('myprojects')->with('notification', 'Project Deleted!!!');
    }

    public function prepareProject($id)
    {
        $project = Project::find($id);
        $provider = $project->settings->provider;
        $user = auth()->user();
        InitiateCalculations::withChain([
                    new $provider->job($project, $user),
                    new \App\Jobs\ParseScores($project, $user),
                    new \App\Jobs\Convert($project, $user, 'source'),
                    new \App\Jobs\Convert($project, $user, 'target'),
                    new \App\Jobs\ProjectReady($project, $user),
                ])->dispatch($project, $provider, $user);

        return redirect()->route('myprojects')->with('notification', 'Project calculations initiated!!!');
    }
}
