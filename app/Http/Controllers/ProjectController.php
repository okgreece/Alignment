<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Project;
use App\File;
use App\Link;
use Auth;

class ProjectController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() {
        $user = Auth::user();
        return view('myprojects', ["user" => $user]);
    }

    public function create(Request $request) {
        $input = request()->all();
        
        $this->validate($request, [
            'name' => 'required|unique:projects|max:255'
        ]);

        $project = Project::create($input);

        $source = $project->source;

        $target = $project->target;

        $source->projects()->attach($project->id);
        $target->projects()->attach($project->id);

        return redirect()->route('myprojects')->with('notification', 'Project created!!!');
    }

    public function show() {
        $id = request('project');
        $project = Project::find($id);

        //find valid files to create a project
        $user = \App\User::find($project->user_id);
        $files = $user->files;
        $select = array();
        foreach ($files as $file) {
            if ($file->parsed) {
                $key = $file->id;
                $value = $file->resource_file_name;
                $select = array_add($select, $key, $value);
            }
        }
        //public files addition
        $files = \App\File::where('public', '=', '1')->get();
        foreach ($files as $file) {
            if ($file->parsed) {
                $key = $file->id;
                $value = $file->resource_file_name;
                $select = array_add($select, $key, $value);
            }
        }

        return view('projects.edit', ["project" => $project, 
                                      "select" => $select,
            ]);
    }

    public function update(Request $request) {
        $input = request()->all();

        $project = Project::find($input['id']);
        
        $this->validate($request, [
            'name' => 'required|unique:projects|max:255'
        ]);
        
        $project->fill($input)->save();

        return redirect()->route('myprojects')->with('notification', 'Project updated!!!');
    }

    public function destroy(Request $request, Project $project) {
        $this->authorize('destroy', $project);

        $project_links = $project->links;

        foreach ($project_links as $link) {
            $link->delete();
        }

        $project->delete();

        return redirect()->route('myprojects')->with('notification', 'Project Deleted!!!');
    }

}
