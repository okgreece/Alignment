<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\File;
use App\User;
use Auth;
use Cache;


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
        return view('mygraphs',["user"=>$user, "files"=>$files]);
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
	File::create( $input );
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
    
    public function destroy(Request $request, File $file)
    {
        $this->authorize('destroy', $file);

        $file->delete();

        return redirect()->route('mygraphs')->with('notification', 'File Deleted!!!');
    }
    
    public function parse(File $file)
    {
        $graph = new \EasyRdf_Graph();
        /*
         * Read the graph
         */
        try{
          if($file->filetype != 'ntriples'){
              logger('inserted converter');
              FileController::convert($file);
              logger('exited converter');
              
              $graph->parseFile($file->resource->path() . '.nt', 'ntriples');
              logger('parsing_finished');
          }
          else{
              $graph->parseFile($file->resource->path(), 'ntriples');
          }
          logger('passed check');
          logger("finished parsing");
          $file->parsed = true;
          $file->save();
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
    
    public function cacheGraph(\App\File $file){
        if(Cache::has($file->id. "_graph")){
            return 1;
        }
        else{
            $graph = new \EasyRdf_Graph;
            $suffix = ($file->filetype != 'ntriples' ) ? '.nt' : '';
            $graph->parseFile($file->resource->path() . $suffix, 'ntriples');
            Cache::forever($file->id. "_graph", $graph);
            return 1;
        }
        
    }
}
