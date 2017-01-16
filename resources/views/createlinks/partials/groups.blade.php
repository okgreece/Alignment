<div class="form-group form-horizontal">
    <div class="col-sm-2 control-label">
        <label>Link Group <i data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="Please select a group of link types" class="fa fa-fw fa-info-circle info-icon"></i></label>
    </div>
    <div class="col-sm-10">
        <select id="group-selector" onchange="updateRadio()" class="form-control">
    @foreach($groups as $group)
        <option>{{$group->option}}</option>
    @endforeach
</select> 
    </div>


</div>    