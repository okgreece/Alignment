<script>
    function export_table(format, project){
        var my_project = window.location.pathname;
        //console.log(my_project.substr(my_project.lastIndexOf('/') + 1));
        var project_id = parseInt(my_project.substr(my_project.lastIndexOf('/') + 1),10);
        var project_id2 = $('#selectProject option:selected').val();
        
        if (isNaN(project_id)){
            //console.log("Found Nan");
            if (project_id2){
                project_id = project_id2;
            }
            else{
                project_id = '';
            }
            window.open("mylinks/utility/export_table?project_id="+project_id+"&format="+format);            
        }
        else{
            window.open("utility/export_table?project_id="+project_id+"&format="+format);            
        }//console.log(project_id);
    }
</script>
<!-- Modal -->
<div id="export-dialog" class="modal" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Export Links</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary" onclick="export_table('rdfxml')" data-dismiss="modal">RDF/XML</button>
                <button type="button" class="btn btn-primary" onclick="export_table('turtle')" data-dismiss="modal">Turtle</button>
                <button type="button" class="btn btn-primary" onclick="export_table('ntriples')" data-dismiss="modal">N-Triples</button>
                <button type="button" class="btn btn-primary" onclick="export_table('json')" data-dismiss="modal">Json</button>
                <button type="button" class="btn btn-primary" onclick="export_table('csv')" data-dismiss="modal">CSV</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



