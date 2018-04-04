<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#uploadFile">Upload New Ontology</button>
<!-- Modal -->
<div id="uploadFile" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin:80px auto">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload New Graph</h4>
      </div>
      <div class="modal-body">
        <?= Form::open(['url' => route('mygraphs.store'), 'method' => 'POST', 'files' => true]) ?>
                <div class="form-group">
                    <?= Form::hidden('user_id',$user->id) ?>
                  <label for="resource">File input</label>
                  <?= Form::file('resource') ?>
                  <label for="url_file">...or upload from url</label>
                  <?= Form::url("resource_url")?>
                  <p class="help-block">Choose file type.</p>
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
                
                <div class="form-group">
                    <p class="help-block">Choose access type. Pick Public if you want your ontology <br /> to be publicly available</p>
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
            </div>
              <!-- /.box-body -->
              <div class="box-footer">  
            <div class="pull-right">
                <?= Form::submit('submit',['class'=> 'btn btn-primary']) ?>
            </div>
                <?= Form::close() ?>
            </div>
      </div>
    </div>    
</div> 