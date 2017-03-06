<!--@include('links.script')-->
<div class="box" width="80%">
    <div class="box-header">
        @include('links.form')
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @include('links.table')
    </div>
    <!-- /.box-body -->
</div>
<script>
    
//initialize variable
var table;

//catch change event
$('#selectProject').change(function(){
    if(this.value !== ""){
        initializeDataTable(this.value); 
    }
   
});

function delete_link(id){
    $.ajax({
        url: "createlinks/utility/delete",
        method: "POST",
        data:{id:id, _method:"DELETE", _token:"{{csrf_token()}}"}
    })
    .done(function(data){
       $.toaster({ priority : 'success', title : 'Success', message : data}); 
       reload(false);         
    });
     
}


//reload button
function reload(paging = true){
    table.ajax.reload(null, paging);
}
</script>
@push('scripts')
<script>
function initializeDataTable(id){
    
    table = $('#links-table').DataTable({
        destroy:true,
        processing: true,
        serverSide: true,
        ajax: {
            "url" : '{!! route('links.ajax') !!}',
            "type" : "GET",
            "data" : {project :id}
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'project', name: 'project'},
            {data: 'source', name: 'source'},
            {data: 'link', name: 'link'},
            {data: 'target', name: 'target'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
}            
</script>
@endpush