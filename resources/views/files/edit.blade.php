<div class="modal-dialog" style="margin:80px auto">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Ontology File Info</h4>
        </div>
        <div class="modal-body">
            <?= Form::model($file, ['url' => route('mygraphs.update'), 'method' => 'PUT', 'files' => true]) ?>

            <div class="form-group">                  
                <?= Form::hidden('user_id', $file->user_id) ?>
                <?= Form::hidden('id', $file->id) ?>
                <p><b>File Name:</b>{{$file->resource_file_name}}</p>
            </div>
            <div class="form-group">
                <p class="help-block">Choose file type.</p>
                <div class="radio">
                    <label>
                        {{Form::radio('filetype', 'rdfxml')}} RDF/XML
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('filetype', 'turtle')}} Turtle
                    </label>
                </div>                  
                <div class="radio">
                    <label>
                        {{Form::radio('filetype', 'ntriples')}} N-Triples
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('filetype', 'trig')}} Trig
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('filetype', 'nquads')}} N-Quads
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p class="help-block">Choose access type. Pick Public if you want your file <br /> to be publicly available</p>
                <div class="radio">
                    <label>
                        {{Form::radio('public', 0)}} Private
                    </label>
                </div>
                <div class="radio">
                    <label>
                        {{Form::radio('public', 1)}} Public
                    </label>
                </div>
            </div>
            <div class="pull-right">
                <?= Form::submit('submit', ['class' => 'btn btn-primary']) ?>
                <?= Form::close() ?>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
    </div>
</div>