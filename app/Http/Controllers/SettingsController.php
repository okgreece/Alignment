<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Settings;
use App\Project;
use Auth;
use Storage;
use Cache;

class SettingsController extends Controller {

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
        //$user->load("sessions.links");
        return view('settings', ["user" => $user]);
    }

    public function create() {
        $input = request()->all();
        $input = array_filter($input);
        Settings::create($input);
        return redirect()->route('settings')->with('notification', 'Settings Created!!!');
    }

    public function create_config($project_id) {
        $project = Project::find($project_id);
        //dd($project);
        $settings = $project->settings;
        $project->processed = 0;
        $project->save();
              SettingsController::silkConfiguration($project);
//comment out for now because it is lost during reloading so there is no reason to exist
//        $client   = new \Hoa\Websocket\Client(
//         new \Hoa\Socket\Client('ws://127.0.0.1:8889')
//        );
//        $client->setHost('localhost');
//        $client->connect();
//        $client->send("Dispatching SiLK Job...");
//      
              
        dispatch(new \App\Jobs\RunSilk($project));
        return redirect()->route('myprojects')->with('notification', 'SiLK Config File Created succesfully!!!');
    }
    
    public function runSiLK($id) {
        
        //websocket initiallization
        
        $websocket_host = 'localhost';
         $client   = new \Hoa\Websocket\Client(
         new \Hoa\Socket\Client('ws://'.$websocket_host.':8889')
        );
        $client->setHost($websocket_host);
      
        
        //$filename = storage_path() . "/app/projects/project" . $id . "/project" . $id . "_config.xml";
        $filename = storage_path() . "/app/projects/project" . $id . "/project" . $id . "_config.xml";
        
        $project = Project::find($id);
        $client->connect();
        $message = json_encode(array("message"=>"Started Job...","project"=>$project->id, "state"=>"start"));
        $client->send($message);
        $client->close();
        
        exec('java -d64 -Xms2048M -Xmx4096M -DconfigFile=' . $filename . ' -Dreload=true -Dthreads=4 -jar '.  app_path() .'/functions/silk/silk.jar');
        
        
        
        $settingsID = $project->settings->id;
        if($settingsID==1||$settingsID==2){
            if(Storage::disk("projects")->exists("/project" . $project->id ."/score_project" . $project->id . ".rdf" )){
                Storage::disk("projects")->delete("/project" . $project->id ."/score_project" . $project->id . ".rdf" );
            }
            Storage::disk("projects")->move("/project" . $project->id ."/score.rdf", "/project" . $project->id ."/score_project" . $project->id . ".rdf" );
        }
        
        $client->connect();
        $message = json_encode(array("message"=>"Finished SiLK similarities Calculations...","project"=>$project->id, "state"=>"parsing"));
        $client->send($message);
        $client->close();
        
        $score_filepath = storage_path() . "/app/projects/project" . $id . "/" . "score_project" . $id . ".rdf";
        //echo "Finished SiLK similarities Calculations...";
        $scores = new \EasyRdf_Graph;
        $scores->parseFile($score_filepath, "rdfxml");
        
        $client->connect();
        $message = json_encode(array("message"=>"Project ready!!!","project"=>$project->id,"state"=>"finish"));
        $client->send($message);
        $client->close();
      
        //echo "Finished Score Graph Parsing...";
        Cache::forever( "scores_graph_project" . $id, $scores);
        $project->processed = 1;
        $project->save();
    }
    
    
    public function updateDefault(Project $project){
        Storage::disk("projects")->makeDirectory("project" . $project->id);
        $filename = storage_path() . "/app/projects/default_config.xml";
        $suffix1 = ($project->source->filetype != 'rdfxml' ) ? '.rdf' : '';
        
        $source = file_get_contents($project->source->resource->path() .$suffix1);
        Storage::disk("projects")->put("/project" . $project->id . "/source.rdf", $source );
        $suffix2 = ($project->target->filetype != 'rdfxml' ) ? '.rdf' : '';
        $target = file_get_contents($project->target->resource->path(). $suffix2);
        Storage::disk("projects")->put("/project" . $project->id . "/target.rdf", $target );
        $config = file_get_contents($filename);
        Storage::disk("projects")->put("/project" . $project->id ."/project" . $project->id . "_config.xml", $config );
        
        
    }
    
    public function destroy(){
        return 0;
    }
    
    public function update(){
        return 0;
    }
    
    
    public function silkConfiguration(Project $project) {
        Storage::disk("projects")->makeDirectory("project" . $project->id);
        $filename = storage_path() . "/app/projects/project" . $project->id . "/project" . $project->id . "_config.xml";
        
        $settingsID = $project->settings->id;
        if($settingsID==1||$settingsID==2){
            
            SettingsController::updateDefault($project);
            return 0;   
        }
        
// ----------------------------------------------------------------
// --- VARIABLES
// ---> label και code βάσει του κλικ του χρήστη! (εδώ έτοιμα)

        $prefix1 = "rdfs";
        $namespace1 = "http://www.w3.org/2000/01/rdf-schema#";
        $prefix2 = "xsd";
        $namespace2 = "http://www.w3.org/2001/XMLSchema#";
        $prefix3 = "owl";
        $namespace3 = "http://www.w3.org/2002/07/owl#";
        $prefix4 = "rdf";
        $namespace4 = "http://www.w3.org/1999/02/22-rdf-syntax-ns#";
        $prefix5 = "sesame";
        $namespace5 = "http://www.openrdf.org/schema/sesame#";
        $prefix6 = "fn";
        $namespace6 = "http://www.w3.org/2005/xpath-functions#";
        $prefix7 = "skos";
        $namespace7 = "http://www.w3.org/2004/02/skos/core#";

        $datasourceid1 = "codelist1";
        $datasourcetype1 = "file";
        $paramuri1 = "file";
// ---> path του source file
        //$source_list = "source";
        //$paramuriv1 = $source_list . ".rdf";
        $paramuriv1 = $project->source->resource->path();
        $paramgraph1 = "format";
// format του source
        $paramgraphv1 = "RDF/XML";

        $datasourceid2 = "codelist2";
        $datasourcetype2 = "file";
        $paramuri2 = "file";
// ---> path του target file
        //$target_list=

        $paramuriv2 = $project->target->resource->path();
        $paramgraph2 = "format";
// format του target
        $paramgraphv2 = "RDF/XML";


        $interlinkId = "labels";
// τύπος σύνδεσης (χρησιμοποιείται το 1ο. δυνατότητα επιλογής; ίσως μετά τα αποτελέσματα)
        $linktypeV = "skos:closeMatch";
        $linktypeV2 = "skos:exactMatch";

// source datasource id (όπως έχει δηλωθεί παραπάνω; )
        $sdDs = "codelist1";
// var όπως θα περιέχεται στο ερώτημα
        $sdVar = "a";
// target datasource id (όπως έχει δηλωθεί παραπάνω; )
        $tdDs = "codelist2";
// var όπως θα περιέχεται στο ερώτημα
        $tdVar = "b";

// queries (sparql restriction)
        //$queryS="?a skos:prefLabel " . $word ;
        //$queryT="?b rdf:type skos:Concept";
        $queryS = "";
        $queryT = "";

// ενσωμάτωση συγκρίσεων (max, min, quadraticMean, geometricMean)
        $aggType = $project->settings->aggregate;
// παράμετροι σύγκρισης 
// https://www.assembla.com/wiki/show/silk/Comparison
        $compMetric1 = "levenshtein";
        $compThre1 = $project->settings->thre1;
        $compMetric2 = "jaro";
        $compThre2 = $project->settings->thre2;
        $compMetric3 = "jaroWinkler";
        $compThre3 = $project->settings->thre3;
        $compMetric4 = "jaccard";
        $compThre4 = $project->settings->thre4;
        $compMetric5 = "dice";
        $compThre5 = $project->settings->thre5;
        $compMetric6 = "softjaccard";
        $compThre6 = $project->settings->thre6;
// ερώτήματα σύγκρισης 1
        $input1aPath = $project->settings->path1a;
        $input1bPath = $project->settings->path1b;
        $input2aPath = $project->settings->path2a;
        $input2bPath = $project->settings->path2b;
        $input3aPath = $project->settings->path3a;
        $input3bPath = $project->settings->path3b;
        $input4aPath = $project->settings->path4a;
        $input4bPath = $project->settings->path4b;
        $input5aPath = $project->settings->path5a;
        $input5bPath = $project->settings->path5b;
        $input6aPath = $project->settings->path6a;
        $input6bPath = $project->settings->path6b;


// limit 
        $filterLimit = $project->settings->filter_limit;

        $outputType1 = "file";
        $outputType2 = "file";
        $outputType3 = "alignment";
        $outputId1 = "suggestions";
        $outputId2 = "exactMatch";
        $outputId3 = "score";
// min ή και max confidence
        $outputMin1 = "0.5";
        $outputMin2 = "1";
        $outputMin3 = ($project->settings->minC1) / 100;
        $outputMax3 = ($project->settings->maxC1) / 100;
        $output_param1aName = "file";
        $output_param2aName = "file";
        $output_param3aName = "file";
// όνομα αρχείου παραμετροποιήσιμο βάσει source_list (όνομα λίστας) και code (όρου προς σύγκριση) 
        //$source_list = "cpa";
        //$target_list = "cpc";
//	$output_param1aValue="top10_" . $source_list . "_" . $code . "_" . $target_list . ".nt";
//	$output_param2aValue="exact_" . $source_list . "_" . $code . "_" . $target_list . ".nt";
//        $output_param3aValue="score_" . $source_list . "_" . $code . "_" . $target_list . ".rdf";
        $output_param1aValue = "top10_project" . $project->id . ".nt";
        $output_param2aValue = "exact_project" . $project->id . ".nt";
        $output_param3aValue = "score_project" . $project->id . ".rdf";
        $output_param1bName = "format";
        $output_param2bName = "format";
        $output_param3bName = "format";
// format αρχείου
        $output_param1bValue = "N-TRIPLE";
        $output_param2bValue = "N-TRIPLE";
        $output_param3bValue = "RDF/XML";

        $dom = new \DomDocument;

        $dom->formatOutput = true;

        $root = $dom->createElement('Silk');
        $root = $dom->appendChild($root);

// --- PREFIXES

        $prefixes = $dom->createElement('Prefixes');
        $prefixes = $root->appendChild($prefixes);

        $prefix = $dom->createElement('Prefix');
        $prefix = $prefixes->appendChild($prefix);
        $id = $dom->createAttribute('id');
        $id->appendChild($dom->createTextNode($prefix1));
        $prefix->appendChild($id);
        $namespace = $dom->createAttribute('namespace');
        $namespace->appendChild($dom->createTextNode($namespace1));
        $prefix->appendChild($namespace);

        $prefix_s = $dom->createElement('Prefix');
        $prefix_s = $prefixes->appendChild($prefix_s);
        $id_s = $dom->createAttribute('id');
        $id_s->appendChild($dom->createTextNode($prefix2));
        $prefix_s->appendChild($id_s);
        $namespace_s = $dom->createAttribute('namespace');
        $namespace_s->appendChild($dom->createTextNode($namespace2));
        $prefix_s->appendChild($namespace_s);

        $prefix_t = $dom->createElement('Prefix');
        $prefix_t = $prefixes->appendChild($prefix_t);
        $id_t = $dom->createAttribute('id');
        $id_t->appendChild($dom->createTextNode($prefix3));
        $prefix_t->appendChild($id_t);
        $namespace_t = $dom->createAttribute('namespace');
        $namespace_t->appendChild($dom->createTextNode($namespace3));
        $prefix_t->appendChild($namespace_t);

        $prefix_c4 = $dom->createElement('Prefix');
        $prefix_c4 = $prefixes->appendChild($prefix_c4);
        $id_c4 = $dom->createAttribute('id');
        $id_c4->appendChild($dom->createTextNode($prefix4));
        $prefix_c4->appendChild($id_c4);
        $namespace_c4 = $dom->createAttribute('namespace');
        $namespace_c4->appendChild($dom->createTextNode($namespace4));
        $prefix_c4->appendChild($namespace_c4);

        $prefix_c5 = $dom->createElement('Prefix');
        $prefix_c5 = $prefixes->appendChild($prefix_c5);
        $id_c5 = $dom->createAttribute('id');
        $id_c5->appendChild($dom->createTextNode($prefix5));
        $prefix_c5->appendChild($id_c5);
        $namespace_c5 = $dom->createAttribute('namespace');
        $namespace_c5->appendChild($dom->createTextNode($namespace5));
        $prefix_c5->appendChild($namespace_c5);

        $prefix_c6 = $dom->createElement('Prefix');
        $prefix_c6 = $prefixes->appendChild($prefix_c6);
        $id_c6 = $dom->createAttribute('id');
        $id_c6->appendChild($dom->createTextNode($prefix6));
        $prefix_c6->appendChild($id_c6);
        $namespace_c6 = $dom->createAttribute('namespace');
        $namespace_c6->appendChild($dom->createTextNode($namespace6));
        $prefix_c6->appendChild($namespace_c6);

        $prefix_c7 = $dom->createElement('Prefix');
        $prefix_c7 = $prefixes->appendChild($prefix_c7);
        $id_c7 = $dom->createAttribute('id');
        $id_c7->appendChild($dom->createTextNode($prefix7));
        $prefix_c7->appendChild($id_c7);
        $namespace_c7 = $dom->createAttribute('namespace');
        $namespace_c7->appendChild($dom->createTextNode($namespace7));
        $prefix_c7->appendChild($namespace_c7);


// --- DATASOURCES

        $datasources = $dom->createElement('DataSources');
        $datasources = $root->appendChild($datasources);

// --- SOURCE DATASOURCE

        $datasource_s = $dom->createElement('DataSource');
        $datasource_s = $datasources->appendChild($datasource_s);

        $datasource_id = $dom->createAttribute('id');
        $datasource_id->appendChild($dom->createTextNode($datasourceid1));
        $datasource_s->appendChild($datasource_id);

        $datasource_type = $dom->createAttribute('type');
        $datasource_type->appendChild($dom->createTextNode($datasourcetype1));
        $datasource_s->appendChild($datasource_type);

        $dpm = $dom->createElement('Param');
        $dpm = $datasource_s->appendChild($dpm);
        $dpm_uri = $dom->createAttribute('name');
        $dpm_uri->appendChild($dom->createTextNode($paramuri1));
        $dpm->appendChild($dpm_uri);
        $dpm_uriv = $dom->createAttribute('value');
        $dpm_uriv->appendChild($dom->createTextNode($paramuriv1));
        $dpm->appendChild($dpm_uriv);

        $dpm2 = $dom->createElement('Param');
        $dpm2 = $datasource_s->appendChild($dpm2);
        $dpm_graph = $dom->createAttribute('name');
        $dpm_graph->appendChild($dom->createTextNode($paramgraph1));
        $dpm2->appendChild($dpm_graph);
        $dpm_graphv = $dom->createAttribute('value');
        $dpm_graphv->appendChild($dom->createTextNode($paramgraphv1));
        $dpm2->appendChild($dpm_graphv);

// --- TARGET DATASOURCE 

        $datasource_t = $dom->createElement('DataSource');
        $datasource_t = $datasources->appendChild($datasource_t);

        $datasource_id2 = $dom->createAttribute('id');
        $datasource_id2->appendChild($dom->createTextNode($datasourceid2));
        $datasource_t->appendChild($datasource_id2);

        $datasource_type2 = $dom->createAttribute('type');
        $datasource_type2->appendChild($dom->createTextNode($datasourcetype2));
        $datasource_t->appendChild($datasource_type2);

        $dpm_t = $dom->createElement('Param');
        $dpm_t = $datasource_t->appendChild($dpm_t);
        $dpm_uri2 = $dom->createAttribute('name');
        $dpm_uri2->appendChild($dom->createTextNode($paramuri2));
        $dpm_t->appendChild($dpm_uri2);
        $dpm_uriv2 = $dom->createAttribute('value');
        $dpm_uriv2->appendChild($dom->createTextNode($paramuriv2));
        $dpm_t->appendChild($dpm_uriv2);

        $dpm2_t = $dom->createElement('Param');
        $dpm2_t = $datasource_t->appendChild($dpm2_t);
        $dpm_graph2 = $dom->createAttribute('name');
        $dpm_graph2->appendChild($dom->createTextNode($paramgraph2));
        $dpm2_t->appendChild($dpm_graph2);
        $dpm_graphv2 = $dom->createAttribute('value');
        $dpm_graphv2->appendChild($dom->createTextNode($paramgraphv2));
        $dpm2_t->appendChild($dpm_graphv2);


// --- INTERLINKS

        $interlinks = $dom->createElement('Interlinks');
        $interlinks = $root->appendChild($interlinks);

        $interlink = $dom->createElement('Interlink');
        $interlink = $interlinks->appendChild($interlink);
        $interlink_id = $dom->createAttribute('id');
        $interlink_id->appendChild($dom->createTextNode($interlinkId));
        $interlink->appendChild($interlink_id);

// --- SOURCE DATASET

        $sourcedataset = $dom->createElement('SourceDataset');
        $sourcedataset = $interlink->appendChild($sourcedataset);
        $sd_ds = $dom->createAttribute('dataSource');
        $sd_ds->appendChild($dom->createTextNode($sdDs));
        $sourcedataset->appendChild($sd_ds);
        $sd_var = $dom->createAttribute('var');
        $sd_var->appendChild($dom->createTextNode($sdVar));
        $sourcedataset->appendChild($sd_var);

        $restrictto_s = $dom->createElement('RestrictTo');
        $restrictto_s = $sourcedataset->appendChild($restrictto_s);

        $query_s = $dom->createTextNode($queryS);
        $restrictto_s->appendChild($query_s);

// --- TARGET DATASET

        $targetdataset = $dom->createElement('TargetDataset');
        $targetdataset = $interlink->appendChild($targetdataset);
        $td_ds = $dom->createAttribute('dataSource');
        $td_ds->appendChild($dom->createTextNode($tdDs));
        $targetdataset->appendChild($td_ds);
        $td_var = $dom->createAttribute('var');
        $td_var->appendChild($dom->createTextNode($tdVar));
        $targetdataset->appendChild($td_var);

        $restrictto_t = $dom->createElement('RestrictTo');
        $restrictto_t = $targetdataset->appendChild($restrictto_t);

        $query_t = $dom->createTextNode($queryT);
        $restrictto_t->appendChild($query_t);


// --- LINKAGE RULE


        $linkagerule = $dom->createElement('LinkageRule');
        $linkagerule = $interlink->appendChild($linkagerule);
        $linktype = $dom->createAttribute('linkType');
        $linktype->appendChild($dom->createTextNode($linktypeV));
        $linkagerule->appendChild($linktype);


        $aggregate = $dom->createElement('Aggregate');
        $aggregate = $linkagerule->appendChild($aggregate);
        $agg_type = $dom->createAttribute('type');
        $agg_type->appendChild($dom->createTextNode($aggType));
        $aggregate->appendChild($agg_type);


// --- COMPARISON 1

        $compare1 = $dom->createElement('Compare');
        $compare1 = $aggregate->appendChild($compare1);
        $comp_metric1 = $dom->createAttribute('metric');
        $comp_metric1->appendChild($dom->createTextNode($compMetric1));
        $compare1->appendChild($comp_metric1);
        $comp_thre1 = $dom->createAttribute('threshold');
        $comp_thre1->appendChild($dom->createTextNode($compThre1));
        $compare1->appendChild($comp_thre1);

        $input1a = $dom->createElement('Input');
        $input1a = $compare1->appendChild($input1a);
        $input1a_path = $dom->createAttribute('path');
        $input1a_path->appendChild($dom->createTextNode($input1aPath));
        $input1a->appendChild($input1a_path);

        $input1b = $dom->createElement('Input');
        $input1b = $compare1->appendChild($input1b);
        $input1b_path = $dom->createAttribute('path');
        $input1b_path->appendChild($dom->createTextNode($input1bPath));
        $input1b->appendChild($input1b_path);

// --- COMPARISON 2

        $compare2 = $dom->createElement('Compare');
        $compare2 = $aggregate->appendChild($compare2);
        $comp_metric2 = $dom->createAttribute('metric');
        $comp_metric2->appendChild($dom->createTextNode($compMetric2));
        $compare2->appendChild($comp_metric2);
        $comp_thre2 = $dom->createAttribute('threshold');
        $comp_thre2->appendChild($dom->createTextNode($compThre2));
        $compare2->appendChild($comp_thre2);

        $input2a = $dom->createElement('Input');
        $input2a = $compare2->appendChild($input2a);
        $input2a_path = $dom->createAttribute('path');
        $input2a_path->appendChild($dom->createTextNode($input1aPath));
        $input2a->appendChild($input2a_path);

        $input2b = $dom->createElement('Input');
        $input2b = $compare2->appendChild($input2b);
        $input2b_path = $dom->createAttribute('path');
        $input2b_path->appendChild($dom->createTextNode($input1bPath));
        $input2b->appendChild($input2b_path);

// --- COMPARISON 3

        $compare3 = $dom->createElement('Compare');
        $compare3 = $aggregate->appendChild($compare3);
        $comp_metric3 = $dom->createAttribute('metric');
        $comp_metric3->appendChild($dom->createTextNode($compMetric3));
        $compare3->appendChild($comp_metric3);
        $comp_thre3 = $dom->createAttribute('threshold');
        $comp_thre3->appendChild($dom->createTextNode($compThre3));
        $compare3->appendChild($comp_thre3);

        $input3a = $dom->createElement('Input');
        $input3a = $compare3->appendChild($input3a);
        $input3a_path = $dom->createAttribute('path');
        $input3a_path->appendChild($dom->createTextNode($input1aPath));
        $input3a->appendChild($input3a_path);

        $input3b = $dom->createElement('Input');
        $input3b = $compare3->appendChild($input3b);
        $input3b_path = $dom->createAttribute('path');
        $input3b_path->appendChild($dom->createTextNode($input1bPath));
        $input3b->appendChild($input3b_path);

// --- COMPARISON 4

        $compare4 = $dom->createElement('Compare');
        $compare4 = $aggregate->appendChild($compare4);
        $comp_metric4 = $dom->createAttribute('metric');
        $comp_metric4->appendChild($dom->createTextNode($compMetric4));
        $compare4->appendChild($comp_metric4);
        $comp_thre4 = $dom->createAttribute('threshold');
        $comp_thre4->appendChild($dom->createTextNode($compThre4));
        $compare4->appendChild($comp_thre4);

        $input4a = $dom->createElement('Input');
        $input4a = $compare4->appendChild($input4a);
        $input4a_path = $dom->createAttribute('path');
        $input4a_path->appendChild($dom->createTextNode($input1aPath));
        $input4a->appendChild($input4a_path);

        $input4b = $dom->createElement('Input');
        $input4b = $compare4->appendChild($input4b);
        $input4b_path = $dom->createAttribute('path');
        $input4b_path->appendChild($dom->createTextNode($input1bPath));
        $input4b->appendChild($input4b_path);

// --- COMPARISON 5

        $compare5 = $dom->createElement('Compare');
        $compare5 = $aggregate->appendChild($compare5);
        $comp_metric5 = $dom->createAttribute('metric');
        $comp_metric5->appendChild($dom->createTextNode($compMetric5));
        $compare5->appendChild($comp_metric5);
        $comp_thre5 = $dom->createAttribute('threshold');
        $comp_thre5->appendChild($dom->createTextNode($compThre5));
        $compare5->appendChild($comp_thre5);

        $input5a = $dom->createElement('Input');
        $input5a = $compare5->appendChild($input5a);
        $input5a_path = $dom->createAttribute('path');
        $input5a_path->appendChild($dom->createTextNode($input1aPath));
        $input5a->appendChild($input5a_path);

        $input5b = $dom->createElement('Input');
        $input5b = $compare5->appendChild($input5b);
        $input5b_path = $dom->createAttribute('path');
        $input5b_path->appendChild($dom->createTextNode($input1bPath));
        $input5b->appendChild($input5b_path);

// --- COMPARISON 6

        $compare6 = $dom->createElement('Compare');
        $compare6 = $aggregate->appendChild($compare6);
        $comp_metric6 = $dom->createAttribute('metric');
        $comp_metric6->appendChild($dom->createTextNode($compMetric6));
        $compare6->appendChild($comp_metric6);
        $comp_thre6 = $dom->createAttribute('threshold');
        $comp_thre6->appendChild($dom->createTextNode($compThre6));
        $compare6->appendChild($comp_thre6);

        $input6a = $dom->createElement('Input');
        $input6a = $compare6->appendChild($input6a);
        $input6a_path = $dom->createAttribute('path');
        $input6a_path->appendChild($dom->createTextNode($input1aPath));
        $input6a->appendChild($input6a_path);

        $input6b = $dom->createElement('Input');
        $input6b = $compare6->appendChild($input6b);
        $input6b_path = $dom->createAttribute('path');
        $input6b_path->appendChild($dom->createTextNode($input1bPath));
        $input6b->appendChild($input6b_path);


// --- Filter 

        $filter = $dom->createElement('Filter');
        $filter = $linkagerule->appendChild($filter);
        $limit = $dom->createAttribute('limit');
        $limit->appendChild($dom->createTextNode($filterLimit));
        $filter->appendChild($limit);

        $outputs = $dom->createElement('Outputs');
        $outputs = $root->appendChild($outputs);


// --- 1st OUTPUT


        $output = $dom->createElement('Output');
        $output = $outputs->appendChild($output);
        $output_id1 = $dom->createAttribute('id');
        $output_id1->appendChild($dom->createTextNode($outputId1));
        $output->appendChild($output_id1);
        $output_type1 = $dom->createAttribute('type');
        $output_type1->appendChild($dom->createTextNode($outputType1));
        $output->appendChild($output_type1);
        $output_min1 = $dom->createAttribute('minConfidence');
        $output_min1->appendChild($dom->createTextNode($outputMin1));
        $output->appendChild($output_min1);

        $output_param1a = $dom->createElement('Param');
        $output_param1a = $output->appendChild($output_param1a);
        $output_param1a_name = $dom->createAttribute('name');
        $output_param1a_name->appendChild($dom->createTextNode($output_param1aName));
        $output_param1a->appendChild($output_param1a_name);
        $output_param1a_value = $dom->createAttribute('value');
        $output_param1a_value->appendChild($dom->createTextNode($output_param1aValue));
        $output_param1a->appendChild($output_param1a_value);

        $output_param1b = $dom->createElement('Param');
        $output_param1b = $output->appendChild($output_param1b);
        $output_param1b_name = $dom->createAttribute('name');
        $output_param1b_name->appendChild($dom->createTextNode($output_param1bName));
        $output_param1b->appendChild($output_param1b_name);
        $output_param1b_value = $dom->createAttribute('value');
        $output_param1b_value->appendChild($dom->createTextNode($output_param1bValue));
        $output_param1b->appendChild($output_param1b_value);


// --- 2nd OUTPUT


        $output2 = $dom->createElement('Output');
        $output2 = $outputs->appendChild($output2);
        $output_id2 = $dom->createAttribute('id');
        $output_id2->appendChild($dom->createTextNode($outputId2));
        $output2->appendChild($output_id2);
        $output_type2 = $dom->createAttribute('type');
        $output_type2->appendChild($dom->createTextNode($outputType2));
        $output2->appendChild($output_type2);
        $output_min2 = $dom->createAttribute('minConfidence');
        $output_min2->appendChild($dom->createTextNode($outputMin2));
        $output2->appendChild($output_min2);

        $output_param2a = $dom->createElement('Param');
        $output_param2a = $output2->appendChild($output_param2a);
        $output_param2a_name = $dom->createAttribute('name');
        $output_param2a_name->appendChild($dom->createTextNode($output_param2aName));
        $output_param2a->appendChild($output_param2a_name);
        $output_param2a_value = $dom->createAttribute('value');
        $output_param2a_value->appendChild($dom->createTextNode($output_param2aValue));
        $output_param2a->appendChild($output_param2a_value);

        $output_param2b = $dom->createElement('Param');
        $output_param2b = $output2->appendChild($output_param2b);
        $output_param2b_name = $dom->createAttribute('name');
        $output_param2b_name->appendChild($dom->createTextNode($output_param2bName));
        $output_param2b->appendChild($output_param2b_name);
        $output_param2b_value = $dom->createAttribute('value');
        $output_param2b_value->appendChild($dom->createTextNode($output_param2bValue));
        $output_param2b->appendChild($output_param2b_value);


        // --- 3rd OUTPUT


        $output3 = $dom->createElement('Output');
        $output3 = $outputs->appendChild($output3);
        $output_id3 = $dom->createAttribute('id');
        $output_id3->appendChild($dom->createTextNode($outputId3));
        $output3->appendChild($output_id3);
        $output_type3 = $dom->createAttribute('type');
        $output_type3->appendChild($dom->createTextNode($outputType3));
        $output3->appendChild($output_type3);
        $output_min3 = $dom->createAttribute('minConfidence');
        $output_min3->appendChild($dom->createTextNode($outputMin3));
        $output3->appendChild($output_min3);
        $output_max3 = $dom->createAttribute('maxConfidence');
        $output_max3->appendChild($dom->createTextNode($outputMax3));
        $output3->appendChild($output_max3);

        $output_param3a = $dom->createElement('Param');
        $output_param3a = $output3->appendChild($output_param3a);
        $output_param3a_name = $dom->createAttribute('name');
        $output_param3a_name->appendChild($dom->createTextNode($output_param3aName));
        $output_param3a->appendChild($output_param3a_name);
        $output_param3a_value = $dom->createAttribute('value');
        $output_param3a_value->appendChild($dom->createTextNode($output_param3aValue));
        $output_param3a->appendChild($output_param3a_value);

        $output_param3b = $dom->createElement('Param');
        $output_param3b = $output3->appendChild($output_param3b);
        $output_param3b_name = $dom->createAttribute('name');
        $output_param3b_name->appendChild($dom->createTextNode($output_param3bName));
        $output_param3b->appendChild($output_param3b_name);
        $output_param3b_value = $dom->createAttribute('value');
        $output_param3b_value->appendChild($dom->createTextNode($output_param3bValue));
        $output_param3b->appendChild($output_param3b_value);


// --- OUTPUTS
        //Storage::disk("projects")->makeDirectory("project" . $project->id);
        $filename = storage_path() . "/app/projects/project" . $project->id . "/project" . $project->id . "_config.xml";
        $dom->save($filename);
    }
}
