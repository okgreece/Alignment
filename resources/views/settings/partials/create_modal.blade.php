<!-- Modal -->
<div id="create-settings-dialog" class="modal" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create a New Setting</h4>
            </div>
            <div class="modal-body">
                <?= Form::open(['url' => action('SettingsController@create'), 'method' => 'POST', 'files' => true]) ?>
                
                <div class="form-group">
                <label for="inputFile">Configuration File</label>
                <?= Form::file('resource', ['id' => 'inputFile', 'required'=>'true']) ?>
                <p class="help-block">Attach a valid provider specific configuration file</p>
                </div>
        
                <div class="form-group">
                    <?= Form::label('name', 'Enter a user friendly name') ?>
                    <?= Form::text('name', null, ['class' => 'form-control']) ?>
                </div>
                    <p class="help-block">Select Suggestions Provider</p>
                    <div class="form-group">
                        @foreach($providers as $provider)
                        <div class="radio">
                            <label>
                                <input type="radio" name="suggestion_provider_id" value="{{$provider->id}}">
                                {{$provider->name}}
                            </label>
                        </div>
                        @endforeach
                     </div>
                <p class="help-block">Select settings ownership</p>
                <div class="form-group">
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
                <?= Form::submit('Save') ?>
                <?= Form::close() ?>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>