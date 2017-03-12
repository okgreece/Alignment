<div id="export-voted-modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Export Voted Links</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'export-voted-form', 'url'=>'myvotes/export']) !!}
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
                <div class="form-group col-lg-4 col-lg-offset-4">
                    <?= Form::label('project', 'Select Project') ?>
                    <?= Form::select('project_id', $select, null, ["class" => "form-control"]) ?>
                </div>
                <div class="form-group col-lg-4 col-lg-offset-4 text-center">
                    <div><b>Set a threshold:</b></div>
                    <label for="threshold" class='sr-only'>Threshold</label>
                    <input class="dial" type="text" name="threshold" value="50">
                </div>
                <div class="form-group col-lg-4 col-lg-offset-4">
                    <label for="filetype">Choose Format</label>
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
                      <input type="radio" name="filetype" id="optionsCSV" value="csv">
                      CSV
                    </label>
                  </div>
                </div>
                <div class="form-group col-lg-4 col-lg-offset-4 text-center">
                    <?= Form::submit('Export', ['onclick'=>'dismiss()', 'class' => 'btn btn-primary']) ?>
                {!! Form::close() !!}
                </div>
                </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<script>
    function dismiss(){
        $("#export-voted-modal").modal("hide");
    };
</script>    