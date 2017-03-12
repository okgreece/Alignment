<script>    
$(document).ready(function() {
    var table = $('#myTable').DataTable( {
        "columnDefs": [
            { "orderable": false, "targets": [-1] },
            { "searchable": false, "targets": [-1] },
            { "width":"20%", "targets": [2,3,4,]}
        ],
        "fixedColumns":true,
        "autoWidth":false,
        "scrollX" :true,       
        initComplete: function () {
            this.api().columns([1]).every( function () {
                var column = this;
                var place = $("#myTable_length");
                var filter = $('<select class="form-control input-md" id="filter"><option value="">Filter by project</option></select>')
                    .appendTo( $(place))
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $("#filter").val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                var select = $("#filter");
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    });
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
});
</script>
