<!-- Modal -->
<div id="import-dialog" class="modal" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Links</h4>
            </div>
            <div class="modal-body">
                <?= Form::open(['url' => action('LinkController@import'), 'method' => 'POST', 'files' => true]) ?>
                
                <div class="form-group">
                <label for="inputFile">File to import</label>
                <?= Form::file('resource',['id' => "inputFile", 'required'=>'true']) ?>
                <p class="help-block">Select a local File to import</p>
                </div>
        
                <div class="form-group">
                    <?= Form::label('project_id', 'Select Project to Import Links') ?>
                    <?= Form::select('project_id', $select, null, ["class" => "form-control"]) ?>
                </div>
                <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="filetype" id="optionsRDFXML" value="rdfxml" checked="">
                      RDF/XML
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="filetype" id="optionsTurtle" value="turtle">
                      Turtle
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="filetype" id="optionsNtriples" value="ntriples">
                      N-Triples
                    </label>
                  </div>
                    <div class="radio">
                    <label>
                      <input type="radio" name="filetype" id="optionsTriG" value="trig">
                      TriG
                    </label>
                  </div>
                    <div class="radio">
                    <label>
                      <input type="radio" name="filetype" id="optionsNQuads" value="nquads">
                      N-Quads
                    </label>
                  </div>
                </div>
                <?= Form::submit('Import') ?>
                <?= Form::close() ?>
                 
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>