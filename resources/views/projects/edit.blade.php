    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Project</h4>
            </div>
            <div class="modal-body">
                <?= Form::open(['url' => route('myprojects.update'), 'method' => 'PUT']) ?>
                <div class="form-group">
                    <?= Form::hidden('user_id', $project->user_id) ?>
                    <?= Form::hidden('id', $project->id) ?>
                </div>
                <div class="form-group">
                    <p class="help-block">Give a simple name to your project.</p>
                    <?= Form::label('name', 'Project Name') ?>
                    <?= Form::text('name', $project->name, ['required' => 'required']) ?>
                </div>
                <div class="form-group">
                    <p class="help-block">Choose access type. Pick Public if you want your project <br /> to be publicly available</p>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="private" value="0" <?php if(!$project->public){ echo 'checked=""';}?> >
                            Private
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="public" value="1" <?php if($project->public){ echo 'checked=""';}?>>
                            Public
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    ?>
                    <?= Form::label('source', 'Select Source ontology') ?>
                    <?= Form::select('source_id', array($project->source_id => $select[$project->source_id]) , ['readonly' => 'true']) ?>
                    <p class="help-block">(You cannot change ontologies if the project contains links.)</p>
                </div>

                <div class="form-group">
                    <?= Form::label('target', 'Select Target ontology') ?>
                    <?= Form::select('target_id', array($project->target_id => $select[$project->target_id]) , ['readonly' => 'true']) ?>
                    <p class="help-block">(You cannot change ontologies if the project contains links.)</p>
                </div>

                <div class="form-group">
                    <?php

                    use App\Settings;

                    $settings = Settings::where("valid", "=", true)->get();
                    $select = array();
                    foreach ($settings as $setting) {
                        $key = $setting->id;
                        $value = $setting->name;
                        $select = array_add($select, $key, $value);
                    }
                    ?>
                    <?= Form::label('settings', 'Select SiLK Framework Settings Profile') ?>
                    <?= Form::select('settings_id', $select, $project->settings_id, array('required' => 'required')) ?>
                    
                </div>
                <div class="pull-right">
                    <?= Form::submit('submit', ['class' => 'btn btn-primary']) ?>
                    <?= Form::close() ?>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
