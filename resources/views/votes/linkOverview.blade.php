<div class="row">
    <div class="col-md-4">
        <button class="preview btn-lg btn-block bg-aqua-gradient" onclick="preview('{{$link->source_entity}}')" data-toggle="popover" title="Preview" data-content="">{{EasyRdf_Namespace::shorten($link->source_entity, true)}}</button>
    </div>
    <div class="col-md-4">
        <button class="preview btn-lg btn-block bg-aqua-active" onclick="preview('{{$link->link_type}}')" data-toggle="popover" title="Preview" data-content="">{{EasyRdf_Namespace::shorten($link->link_type, true)}}</button>
    </div>
    <div class="col-md-4">
        <button class="preview btn-lg btn-block bg-light-blue-gradient" onclick="preview('{{$link->target_entity}}')" data-toggle="popover" title="Preview" data-content="">{{EasyRdf_Namespace::shorten($link->target_entity, true)}}</button>
    </div>
</div>