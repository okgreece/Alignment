<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
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
    public function mygraphs()
    {
        $user = auth()->user();

        return view('files.index', ['user'=>$user, 'files'=>$user->userGraphs()]);
    }

    public function store()
    {
        $input = request()->all();
        $validator = \Validator::make($input, [
            'resource' => 'file',
            'resource_url' => 'url',
        ])->validate();
        if ($input['resource_url'] !== null) {
            $input['resource'] = $input['resource_url'];
        }
        $file = File::create($input);

        return redirect()->route('mygraphs')->with('notification', 'File Uploaded!!!');
    }

    public function show()
    {
        $id = request('file');
        $file = File::find($id);

        return view('files.edit', ['file' => $file]);
    }

    public function update()
    {
        $input = request()->all();

        $file = File::find($input['id']);

        $file->public = $input['public'];

        $file->filetype = $input['filetype'];

        $file->save();

        return redirect()->route('mygraphs')->with('notification', 'File updated!!!');
    }

    public function destroy(File $file)
    {
        $this->authorize('destroy', $file);
        $file->delete();

        return redirect()->route('mygraphs')->with('notification', 'File Deleted!!!');
    }

    public function download(Request $request, File $file)
    {
        return $file->download($request->format);
    }

    public function parse(File $file)
    {
        dispatch(new \App\Jobs\Parse($file, auth()->user()));

        return redirect()->back()->with('notification', 'Parsing Job Dispatched, check your logs.');
    }
}
