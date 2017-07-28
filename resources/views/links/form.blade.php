<div class="form-inline">
    <div class="form-group-lg">
        <div class="col-lg-6" id="select-project-form">
            
            <form >
                <label for="selectProject">Select Project</label>
                <select id="selectProject" class="form-control" name='project'>
                <option value="" selected="selected"></option>
                @foreach($projects as $project)
                
                <option value="{{$project->id}}">
                    {{$project->name}}
                </option>
                @endforeach
            </select>
            </form>            
        </div>
        <button id="refresh" class="btn-lg btn-primary" onclick="reload()" title="Refresh Link Table"><i class="fa fa-repeat"></i></button>
        <button type="button" class="btn-lg btn-primary" data-toggle="modal" data-target="#export-dialog" title="Export Links">Export</button>
        <button type="button" class="btn-lg btn-primary" data-toggle="modal" data-target="#import-dialog" title="Import Links">Import</button>
    </div>
</div>