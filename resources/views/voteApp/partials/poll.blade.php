<?php
if ($candidates != null) {
    $nocandidates = $candidates->count();
    $source_graph = \Illuminate\Support\Facades\Cache::get($candidates[0]->source_id . "_graph");
    $target_graph = \Illuminate\Support\Facades\Cache::get($candidates[0]->target_id . "_graph");
    $ontologies_graph = \Illuminate\Support\Facades\Cache::get('ontologies_graph');
}
?>
<div class="candidate-panel">

@if($candidates != null)
    

<div id="panel-0" class='panel panel-primary'>
    <div class="panel-heading">
        Start a new Poll
    </div>
    <div class="panel-body">
        You are ready to start a new Poll for the project {{$project->name}}. Click on GO to continue, or back to return on the selection screen. 
    </div>
    <div class="panel-footer">
        <a href="{{route("voteApp")}}" class="btn btn-default" onclick="">Back</a>
        <button  type="button" class="btn btn-success" onclick="next(0)">GO</button>
    </div>
</div>
@foreach($candidates as $key=>$candidate)
<div id="panel-{{$key+1}}" class='panel panel-primary candidate-app'>
    <div class="panel-heading">
        Link {{$key+1}} out of {{$nocandidates}}
    </div>
    <div class="panel-body">
        <?php
        $source_label = \App\RDFTrait::label($source_graph, $candidate->source_entity)? : EasyRdf_Namespace::shorten($candidate->source_entity, true);
        $link_type_label = \App\RDFTrait::label($ontologies_graph, $candidate->link_type)? : EasyRdf_Namespace::shorten($candidate->link_type, true);
        $target_label = \App\RDFTrait::label($target_graph, $candidate->target_entity)? : EasyRdf_Namespace::shorten($candidate->target_entity, true);
        ?>
        <a href="{{$candidate->source_entity}}" target="_blank">{{$source_label}}</a> <b><a href="{{$candidate->link_type}}">{{$link_type_label}}</b></a> <a href="{{$candidate->target_entity}}" target="_blank">{{$target_label}}</a>
    </div>
    <div class="panel-footer">
        @include('voteApp.partials.voteButtons')
    </div>
</div>
@endforeach
<div id="panel-{{$nocandidates+1}}" class='panel panel-primary candidate-app'>
    <div class="panel-heading">
        Poll Finished!!!
    </div>
    <div class="panel-body">
        You have finished the Poll for the project {{$project->name}}. Would you like to review your votes or start a new Poll? 
    </div>
    <div class="panel-footer">
        <a href="{{route("voteApp")}}" class="btn btn-default" onclick="">Back</a>
        <button  type="button" class="btn btn-success" onclick="getPoll({{$project->id}}, {{$project->user->id}})">Start New Poll</button>
        <button  type="button" class="btn btn-primary" onclick="review({{$nocandidates+1}})">Review</button>
    </div>
</div>
@else
<div class='panel panel-primary'>
    <div class="panel-heading">
        No more links Available
    </div>
    <div class="panel-body">
        You have voted on all available links. Would you like to review them?
    </div>
    <div class="panel-footer">
        <a href="{{route("voteApp")}}" class="btn btn-default" onclick="">Back</a>
        <button  type="button" class="btn btn-primary" onclick="">Review</button>
    </div>
</div>
@endif
</div>