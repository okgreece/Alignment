<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
        return view('mygraphs',["user"=>$user]);
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
        return view('files.edit', $file);       
    }
    
    
    public function update()
    {
        $input = request()->all();
        
        $file = File::find($input['id']);
        
	$file->public = $input['public'];
        
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
          $graph -> parseFile($file->resource->path(),'rdfxml');
          $_SESSION['test' . "_graph" ] = $graph;
          
          $file->parsed = true;
          $file->save();
          return redirect()->route('mygraphs')->with('notification', 'Graph Parsed!!!');
          
        } catch (\EasyRdf_Parser_Exception $ex) {
            $file->parsed = false;
            $file->save();
            error_log($ex);
          return redirect()->route('mygraphs')->with('error', 'Failed to parse the graph. We currently support only RDF/XML format');
        }
        

        
    }
    
    
}
