<script>    
$(document).ready(function() {
    $('#myTable').DataTable( {
        "columnDefs": [
            { "orderable": false, "targets": [-1, -2, -3, -4, -5] },
            { "searchable": false, "targets": [-1, -2, -3] }            
        ]
} );
});
$('[data-toggle="tooltip"]').tooltip();
</script>

<script>
    function noPermissionFile(){
        $.toaster({ priority : 'error', title : 'Error', message : 'You do not have permission to delete this file.'});
    }
</script>
<div id="editFile" class="modal fade" role="dialog">    
</div>

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
                        <button title="Parse this File" class="btn"><span class="glyphicon glyphicon-play text-blue"></span></button>
                        </form>
                    </td>                    
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{$file->tooltip}}" class="text-center">
                        <form action="{{ url('file/delete/'.$file->id) }}" method="POST">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <button title="Remove this Ontology" class="btn {{$file->projects_count > 0 || $file->user_id != auth()->user()->id ? "disabled" : ""}}"><span class="glyphicon glyphicon-remove text-red"></span></button> 
                         </form>
                    </td>
                    <td class="text-center">
                        <button title="Edit this Ontology File" class="btn {{$file->user_id != auth()->user()->id ? "disabled" : ""}}" data-toggle="modal" data-file="{{$file->id}}" data-target="#editFile"><span class="glyphicon glyphicon-cog text-black"></span></button>
                    </td>                    
                </tr>
                @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
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