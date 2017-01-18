<script>    
$(document).ready(function() {
    var table = $('#myTable').DataTable( {
        "columnDefs": [
            { "orderable": false, "targets": [0] },
            { "searchable": false, "targets": [0] }
            
        ]
    });
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
});
</script>