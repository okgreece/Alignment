<div class="box" width="80%">
    <div class="box-header">
        @include('settings.partials.buttons')
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @include('settings.partials.table')
    </div>
    <!-- /.box-body -->
</div>
<script>
//initialize variable
var table;

//catch change event
function delete_setting(id){
    $.ajax({
        url: "settings/delete",
        method: "POST",
        data:{id:id, _method:"DELETE", _token:"{{csrf_token()}}"}
    })
    .done(function(data){
       $.toaster({ priority : 'success', title : 'Success', message : data}); 
       reload(false);         
    });
}

function export_setting(id){
    window.open("settings/export?id=" + id);
    $.toaster({ priority : 'success', title : 'Success', message : data});
}

//reload button
function reload(paging = true){
    table.ajax.reload(null, paging);
}
</script>
@push('scripts')
<script>
$(function() {
    table = $('#settings-table').DataTable({
        destroy:true,
        processing: true,
        serverSide: true,
        ajax: {
            "url" : '{!! route('settings.ajax') !!}',
            "type" : "GET",            
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'public', name: 'public'},
            {data: 'valid', name: 'valid'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});            
</script>
@endpush