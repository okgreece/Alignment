<div class="row">
    <div class="col-md-4">
        <button class="preview btn-lg btn-block bg-aqua-gradient" onclick="preview('{{$link->source_entity}}', {{$link->project_id}}, 'source')" data-toggle="popover" title="Preview" data-content="">{{$link->source_label}}</button>
    </div>
    <div class="col-md-4">
        <button class="preview btn-lg btn-block bg-aqua-active" onclick="preview('{{$link->link_type}}', {{$link->project_id}}), 'link_type')" data-toggle="popover" title="Preview" data-content="">{{$link->link_label}}</button>
    </div>
    <div class="col-md-4">
        <button class="preview btn-lg btn-block bg-light-blue-gradient" onclick="preview('{{$link->target_entity}}', {{$link->project_id}}, 'target')" data-toggle="popover" title="Preview" data-content="">{{$link->target_label}}</button>
    </div>
</div>