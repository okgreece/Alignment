<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Link;
use App\Project;
use Auth;

class LinkController extends Controller
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
        return view('mylinks',["user"=>$user]);
    }
    
    public function project_links(Request $request)
    {
        session_start();
        $project = Project::find($request->project_id);
        return view('links.link_table',["project"=>$project]);
    }
    
    public function create(Request $request)
    {
        $input = request()->all();
        $project = Project::find($request->project_id);
        $previous = Link::where('project_id', '=', $request->project_id)
                ->where('source_entity', '=', $request->source)
                ->where('target_entity', '=', $request->target)
                ->where('link_type', '=', $request->link_type)
                ->first();
        if($previous == null){
            $link = Link::create( $input );
            $link->project_id = $request->project_id;
            $link->user_id = auth()->user()->id;
            $link->source_id = $project->source_id;
            $link->target_id = $project->target_id;
            $link->source_entity = $request->source;
            $link->target_entity = $request->target;
            $link->link_type = $request->link_type;
            $link->save();
            return 1;
        }
        else{
            
            return 0;
        }        
    }
    
    public function destroy(Request $request, Link $link)
    {
        $this->authorize('destroy', $link);
        $link->delete();
        return \Illuminate\Support\Facades\Redirect::back()->with('notification', 'Link Deleted!!!');
    }
    
    public function delete_all(Request $request)
    {
               
        $project = Project::find($request->project_id);
        //dd($project);
        $links = $project->links;
        foreach($links as $link){
           // $this->authorize('destroy', $link);
            $link->delete();
        }
        return \Illuminate\Support\Facades\Redirect::back()->with('notification', 'All Links Deleted!!!');
    }
    
    public function destroy_all(Request $request, Project $project)
    {   
        $this->authorize('destroy', $file);
        $file->delete();
        return \Illuminate\Support\Facades\Redirect::back()->with('notification', 'File Deleted!!!');
    }
    
    public  function CreateRDFGraph(User $user, $project_id){
        $myGraph = new \EasyRdf_Graph;
        $project = Project::find($project_id);
        //dd($project);
        if($project == null){
            foreach ($user->projects as $project){
                $links = $project->links;
                foreach ($links as $link){
                   $myGraph ->addResource($link->source_entity, $link->link_type,$link->target_entity); 
                }
            }
        }
        else{
            $links = $project->links;
            foreach ($links as $link){
                   $myGraph ->addResource($link->source_entity, $link->link_type,$link->target_entity); 
                }
            }    
        return $myGraph;
    }

    public function export(Request $request){
        $user = \Illuminate\Support\Facades\Auth::user();  
        $project_id = $request->project_id;
        //dd(!empty($project_id));
        if(!is_numeric($project_id) && !empty($project_id)){
            $project = Project::where('name', '=', $project_id)->first();
            $project_id = $project->id;
        }
        $myGraph = LinkController::CreateRDFGraph($user, $project_id);
        $format = $request->format;
        LinkController::CreateRDFFile($myGraph, $format, $project_id);
    }

    function DownloadFile($file,$extension) { // $file = include path 
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=Export.'.$extension);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
            exit;
        }
    }

    function CreateRDFFile($myGraph,$format, $project_id){
        $export = $myGraph->serialise($format);
        $File_Name          = "Export";
        $File_Ext           = \EasyRdf_Format::getFormat($format)->getDefaultExtension(); //get file extention
        if($project_id == null){
            $NewFileName = storage_path() . "/app/projects/Export.$File_Ext";
            file_put_contents(storage_path() . "/app/projects/Export.$File_Ext", $export);
        }
        else{
            $NewFileName = storage_path() . "/app/projects/project$project_id/Export.$File_Ext";
            file_put_contents(storage_path() . "/app/projects/project$project_id/Export.$File_Ext", $export);
        }
        LinkController::DownLoadFile($NewFileName,$File_Ext);
    }
}