@foreach($instances as $instance)
<?php
    if(!Illuminate\Support\Facades\Cache::has($instance->group. '.ontology')){
        $graph = new EasyRdf_Graph;
        $graph->parseFile(storage_path('app/ontologies/' . strtolower($instance->group) . '.rdf'));
        Illuminate\Support\Facades\Cache::forever($instance->group. '.ontology' , $graph);
    }
    else{
        $graph = Illuminate\Support\Facades\Cache::get($instance->group. '.ontology');
    }
    $description = $graph->get($instance->value, new \EasyRdf_Resource('rdfs:comment'))?:$graph->get($instance->value, new \EasyRdf_Resource('skos:definition'));
?>

<input type="radio" name="link_type" value="{{$instance->value}}" />
    <i data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="This option will create a link of type {{ EasyRdf_Namespace::shorten($instance->value)}}. Definition of link type: {{$description}}" class="fa fa-fw fa-info-circle info-icon"></i>
    {{$instance->inner}} <br/>
@endforeach