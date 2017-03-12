<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $(document).ready(function () {
        $('.table').DataTable({
            "columnDefs": [
                {"orderable": false, "targets": [-1, -2, -3, -4]},
                {"searchable": false, "targets": [-1, -2, -3, -4]}
            ],
            "fixedColumns": true,
            "autoWidth": false,
            "scrollX": true
        });

    });
</script>
<div id="editProject" class="modal fade" role="dialog">
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#editProject').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var project = button.data('project'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        $.ajax({
            url: "myprojects/show",
            data: {"project": project},
            type: "POST"})
                .done(function (data) {
                    $("#editProject").html(data);
                });
    });
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Available Projects</h3>
        @include('projects.createform')
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">My projects</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Public Projects</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Vote Only Projects</a></li>
                <li class=""></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @include('projects.user_projects_tab')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    @include('projects.public_projects_tab') 
                </div>
                <div class="tab-pane" id="tab_3">
                    @include('projects.vote_projects_tab') 
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.box-body -->
</div>
<script>
    function noPermissionProject() {
        $.toaster({priority: 'error', title: 'Error', message: 'You do not have permission to delete this project.'});
    }
</script>