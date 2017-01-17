<?php $nofiles = DB::table('files')
        ->select(DB::raw('count(*) as parsed_files'))
        ->where([
            ['parsed', '=', '1'],
            ['user_id', '=', $user->id]
        ])
        ->orWhere([
            ['parsed', '=', '1'],
            ['public', '=', '1']
        ])
        ->groupBy('parsed')
        ->get()
;?>
@if(!$nofiles)
<button type="button" class="btn btn-success" onclick="noFile()">Create New Project</button>
@else
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProject">Create New Project</button>
@endif
<script>
    function noFile(){
        $.toaster({ priority : 'error', title : 'Error', message : 'Cannot create project. Please upload and parse at least one file!!!'});
    }
</script>
<!-- Modal -->
<div id="createProject" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New Project</h4>
            </div>
            <div class="modal-body">
                <?= Form::open(['url' => route('myprojects.create'), 'method' => 'POST']) ?>

                <div class="form-group">

                    <?= Form::hidden('user_id', $user->id) ?>


                </div>
                <div class="form-group">
                    <p class="help-block">Give a simple name to your project.</p>
                    <?= Form::label('name', 'Project Name') ?>
                    <?= Form::text('name', '', ['required' => 'required']) ?>


                </div>
                <div class="form-group">
                    <p class="help-block">Choose access type. Pick Public if you want your project <br /> to be publicly available</p>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="private" value="0" checked="">
                            Private
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="public" value="1">
                            Public
                        </label>
                    </div>
                </div>


                <div class="form-group">
                    <?php
                    $files = $user->files;
                    $select = array();
                    foreach ($files as $file) {
                        if ($file->parsed) {
                            $key = $file->id;
                            $value = $file->resource_file_name;
                            $select = array_add($select, $key, $value);
                        }
                    }
                    //public files addition
                    $files = App\File::where('public', '=', '1')->get();
                    foreach ($files as $file) {
                        if ($file->parsed) {
                            $key = $file->id;
                            $value = $file->resource_file_name;
                            $select = array_add($select, $key, $value);
                        }
                    }
                    ?>
                    <?= Form::label('source', 'Select Source ontology') ?>
                    <?= Form::select('source_id', $select) ?>

                </div>

                <div class="form-group">
                    <?= Form::label('target', 'Select Target ontology') ?>
                    <?= Form::select('target_id', $select) ?>
                </div>

                <div class="form-group">
                    <?php

                    use App\Settings;

$settings = Settings::all();
                    $select = array();
                    foreach ($settings as $setting) {

                        $key = $setting->id;
                        $value = $setting->name;
                        $select = array_add($select, $key, $value);
                    }
                    ?>
                    <?= Form::label('settings', 'Select SiLK Framework Settings Profile') ?>
                    <?= Form::select('settings_id', $select, array('required' => 'required')) ?>

                </div>

            </div>
            <div class="modal-footer">
                <?= Form::submit('submit', ['class' => 'btn btn-primary']) ?>
                <?= Form::close() ?>
            </div>
        </div>


    </div>


</div>



