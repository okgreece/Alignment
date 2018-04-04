<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use App\User;
use Auth;

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
        $user = Auth::user();
        $files = $this->ownGraphs($user)->merge($this->publicGraphs($user));
        return view('files.index',["user"=>$user, "files"=>$files]);
    }
    
    public function ownGraphs(User $user){
        $files = File::where("user_id", $user->id)->withCount("projects")->with("projects")->get();
        return $files;
    }
    
    public function publicGraphs(User $user){
        $files = File::where("public", true)->where("user_id", "!=", $user->id)->withCount("projects")->with("projects")->get();
        return $files;
    }
    
    public function store()
    {
        $input = request()->all();
        $validator = \Validator::make($input, [
            'resource' => 'file',
            'resource_url' => 'url',
        ])->validate();
        if($input["resource_url"] !== null){
            $input["resource"] = $input["resource_url"];
        }
	$file = File::create( $input );        
        return redirect()->route('mygraphs')->with('notification', 'File Uploaded!!!');
    }
    
    public function show()
    {
        $id = request('file');
        $file = File::find($id);
        return view('files.edit', ["file" => $file]);       
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
    
    public function download(Request $request, File $file){
        return $file->download($request->format);
    }
    
    public function parse(File $file)
    {        
        /*
         * Read the graph
         */
        try{
          if($file->filetype != 'ntriples'){
              FileController::convert($file);
              $file->cacheGraph();              
          }
          else{
              $file->cacheGraph();
          }
          return redirect()->route('mygraphs')->with('notification', 'Graph Parsed!!!');
          
        } catch (\Exception $ex) {
            $file->parsed = false;
            $file->save();
            error_log($ex);
          return redirect()->route('mygraphs')->with('error', 'Failed to parse the graph. Please check the logs.' . $ex);
        }       
    }
    
    public function convert(File $file){
        $command = 'rapper -i ' . $file->filetype . ' -o ntriples ' . $file->resource->path() . ' > ' . $file->resource->path(). '.nt';
        $out = [];
        logger($command);
        exec( $command, $out);
        logger(var_dump($out));
        return;
    }
}
