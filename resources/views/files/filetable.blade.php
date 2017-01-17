<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>    
$(document).ready(function() {
    $('#myTable').DataTable( {
        "columnDefs": [
            { "orderable": false, "targets": [-1, -2, -3] },
            { "searchable": false, "targets": [-1, -2, -3] }
            
        ]
} );
});

$('[data-toggle="tooltip"]').tooltip();
</script>

<div id="editFile" class="modal fade" role="dialog">   
    
</div>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $('#editFile').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var file = button.data('file'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        $.ajax({
            url: "file/show",
            data : {"file":file}, 
            type : "POST"})
            .done(function(data) {
                $("#editFile").html(data);            
            });
});
</script>
<div class="box">
    <div class="box-header">
      <h3 class="box-title">My Ontologies</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="myTable" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
              <!--<th>File ID</th>-->
              <th>File name</th>
              <th>File type</th>
              <th>Created at</th>
              <th class="text-center">Public Status</th>
              <th class="text-center">Parsed</th>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
                          
            </tr>
        </thead>
        <tbody>
            <?php $files = $user->files ?>
                @foreach ($files as $file)
                <tr>
                    <!--<td>{{ $file->id }}</td>-->
                    <td>{{ $file->resource_file_name }}</td>
                    <td>{{ $file->resource_content_type }}</td>
                    <td>{{ $file->created_at }}</td>
                    <td class="text-center">@if($file->public)
                            <span class="glyphicon glyphicon-ok-sign text-green" title="This ontology is Public"></span>
                        @else
                            <span class="glyphicon glyphicon-ban-circle text-red" title="This ontology is Private"></span>
                        @endif
                    </td>
                    <td class="text-center">@if($file->parsed)
                            <span class="glyphicon glyphicon-ok-sign text-green" title="This ontology is parsed succesfully by EasyRDF"></span>
                        @else
                            <span class="glyphicon glyphicon-ban-circle text-red" title="This ontology was not parsed or there was a problem"></span>
                        @endif
                    </td>
                    
                    <td class="text-center">
                        <form action="{{ url('file/parse/'.$file->id) }}" method="POST">
                         {!! csrf_field() !!}
                        <button class="btn"><span class="glyphicon glyphicon-play text-blue" title="Parse this File"></span></button>
                        </form>
                    </td>                  
                    <?php 
                    $tooltip = "";
                    if(count($file->projects)){
                                $counter = 1;
                                $projects = $file->projects;
                                
                                if (count($file->projects)>1){
                                    $tooltip =  'Ontology is in use in projects ';
                                    foreach ($projects as $project){
                                           $tooltip = $tooltip . $project->id;
                                            if(count($file->projects) == $counter){
                                            $tooltip = $tooltip . '. ';
                                            }
                                            else{
                                             $tooltip = $tooltip . ', ';
                                            }
                                            $counter++;
                                    }                                    
                                        $tooltip = $tooltip . 'Please remove them firstly.';
                                }
                                else{
                                    $tooltip = 'Ontology is in use in project '. $projects[0]->id.'. Please remove it firtsly.';
                                }
                            }
                             
                            ?>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{$tooltip}}" class="text-center">
                        <form action="{{ url('file/delete/'.$file->id) }}" method="POST">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <button class="btn <?php if(count($file->projects)){ echo "disabled";}?>"><span class="glyphicon glyphicon-remove text-red" title="Remove this Ontology"></span></button> 
                            </form>
                    </td>
                    <td class="text-center">
                        <button class="btn" data-toggle="modal" data-file="{{$file->id}}" data-target="#editFile"><span class="glyphicon glyphicon-cog text-black" title="Edit this Ontology File"></span></button>
                    </td>
                    
                </tr>
                @endforeach
                {{-- public files addition --}}
                <?php $files = App\File::where('public','=','1')->get(); ?>
                @foreach ($files as $file)
                @if($file->user_id!=$user->id)
                <tr>
                    <!--<td>{{ $file->id }}</td>-->
                    <td>{{ $file->resource_file_name }}</td>
                    <td>{{ $file->resource_content_type }}</td>
                    <td>{{ $file->created_at }}</td>
                    <td class="text-center">@if($file->public)
                            <span class="glyphicon glyphicon-ok-sign text-green" title="This ontology is Public"></span>
                        @else
                            <span class="glyphicon glyphicon-ban-circle text-red" title="This ontology is Private"></span>
                        @endif
                    </td>
                    <td class="text-center">@if($file->parsed)
                            <span class="glyphicon glyphicon-ok-sign text-green" title="This ontology is parsed succesfully by EasyRDF"></span>
                        @else
                            <span class="glyphicon glyphicon-ban-circle text-red" title="This ontology was not parsed or there was a problem"></span>
                        @endif
                    </td>
                    
                    <td class="text-center">
                        <form action="{{ url('file/parse/'.$file->id) }}" method="POST">
                         {!! csrf_field() !!}
                        <button class="btn"><span class="glyphicon glyphicon-play text-blue" title="Parse this Ontology File"></span></button>
                        </form>
                    </td>
                    <td class="text-center">
                        <button class="btn" onclick="noPermissionFile()"><span class="glyphicon glyphicon-remove text-red" title="You do not have permission to delete this file."></span></button>
                    </td>
                    <td class="text-center">
                        <button class="btn disabled" data-toggle="modal" data-file="{{$file->id}}" data-target="#editFile"><span class="glyphicon glyphicon-cog text-black" title="Edit this Ontology File"></span></button>
                    </td>
                    
                </tr>
                @endif
                @endforeach
        </tbody>

      </table>
    </div>
    <!-- /.box-body -->
</div>
<script>
    function noPermissionFile(){
        $.toaster({ priority : 'error', title : 'Error', message : 'You do not have permission to delete this file.'});
    }
</script>