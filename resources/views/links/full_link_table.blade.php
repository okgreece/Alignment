@include('links.script')
<div class="box" width="80%">
    <div class="box-header">
        <h3 class="box-title">Links Overview</h3>
        <button id="refresh" class="btn btn-primary" onclick="refresh_table()" title="Refresh Link Table"><i class="fa fa-repeat"></i></button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#export-dialog" title="Export Links">Export</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <table class="table table-bordered" id="links-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Project</th>
                    <th>Source</th>
                    <th>Link</th>
                    <th>Target</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.box-body -->
</div>

@push('scripts')
<script>
    $(function () {
        $('#links-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('links.ajax') !!}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'project', name: 'project'},
                {data: 'source', name: 'source',},
                {data: 'link', name: 'link'},
                {data: 'target', name: 'target'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@endpush