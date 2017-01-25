<div id="export-voted-modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Export Voted Links</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'export-voted-form']) !!}
                <div class="form-group">
                    <?php
                    $projects = auth()->user()->projects;
                    $select = array();
                    foreach ($projects as $project) {
                            $key = $project->id;
                            $value = $project->name;
                            $select = array_add($select, $key, $value);
                    }
                    //public files addition
                    $projects = App\Project::where('public', '=', '1')->get();
                    foreach ($projects as $project) {
                            $key = $project->id;
                            $value = $project->name;
                            $select = array_add($select, $key, $value);
                    }
                    ?>
                    <?= Form::label('project', 'Select Project') ?>
                    <?= Form::select('project_id', $select) ?>
                </div>
                <div class="form-group">
                    
                    <?= Form::label('threshold', 'Select Threshold') ?>
                    <?= Form::select('project_id', $select) ?>
                </div>
                
                {{Form::button('Export',array("onclick" => "export()", "id" => "exportVotedButton"))}}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
