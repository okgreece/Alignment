<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
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
    <div class="modal-dialog" style="margin:80px auto">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Project</h4>
            </div>
            <div class="modal-body">
                <?= Form::open(['url' => route('myprojects.update'), 'method' => 'PUT']) ?>

                <div class="form-group">

                    <?= Form::hidden('user_id', $user->id) ?>


                </div>
                <div class="form-group">
                    <p class="help-block">Give a simple name to your project.</p>
                    <?= Form::label('name', 'Project Name') ?>
                    <?= Form::text('name', '', ['required' => 'required']) ?>
                </div>
                <div class="form-group">
                    <p class="help-block">Choose access type. Pick Public if you want your project <br /> to be publicly available</p>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="private" value="0" checked="">
                            Private
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="public" id="public" value="1">
                            Public
                        </label>
                    </div>
                </div>


                <div class="form-group">
                    <?php
                    $files = $user->files;
                    $select = array();
                    foreach ($files as $file) {
                        if ($file->parsed) {
                            $key = $file->id;
                            $value = $file->resource_file_name;
                            $select = array_add($select, $key, $value);
                        }
                    }
                    //public files addition
                    $files = App\File::where('public', '=', '1')->get();
                    foreach ($files as $file) {
                        if ($file->parsed) {
                            $key = $file->id;
                            $value = $file->resource_file_name;
                            $select = array_add($select, $key, $value);
                        }
                    }
                    ?>
                    <?= Form::label('source', 'Select Source graph') ?>
                    <?= Form::select('source_id', $select) ?>

                </div>

                <div class="form-group">
                    <?= Form::label('target', 'Select Target graph') ?>
                    <?= Form::select('target_id', $select) ?>
                </div>

                <div class="form-group">
                    <?php

                    use App\Settings;

$settings = Settings::all();
                    $select = array();
                    foreach ($settings as $setting) {

                        $key = $setting->id;
                        $value = $setting->name;
                        $select = array_add($select, $key, $value);
                    }
                    ?>
                    <?= Form::label('settings', 'Select SiLK Framework Settings Profile') ?>
                    <?= Form::select('settings_id', $select, array('required' => 'required')) ?>

                </div>

            </div>
            <div class="modal-footer">
                <?= Form::submit('submit', ['class' => 'btn btn-primary']) ?>
                <?= Form::close() ?>
            </div>
        </div>
    </div>
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
            data : {"project":project}, 
            type : "POST"})
            .done(function(data) {
                $("#editProject").html(data);            
            });
        
        
        
});
</script>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">My Projects</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="myTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Source Graph</th>
                    <th>Target Graph</th>
                    <th>Public</th>
                    <th>Created at</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <?php $projects = $user->projects;
                ?>
                @foreach ($projects as $project)

                <tr>

                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->source->resource_file_name}}</td>
                    <td>{{ $project->target->resource_file_name}}</td>
                    <td class="text-center">@if($project->public)
                        <span class="glyphicon glyphicon-ok-sign text-green" title="This graph is Public"></span>
                        @else
                        <span class="glyphicon glyphicon-ban-circle text-red" title="This graph is Private"></span>
                        @endif
                    </td>
                    <td>{{ $project->created_at }}</td>

                    <td class="text-center">
                        <form action="{{ url('settings/create_config/'.$project->id) }}" method="POST">


                            <button class="btn"><span class="glyphicon glyphicon-link text-green" title="Calculate Similarities"></span></button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="{{ url('createlinks/'.$project->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <button class="btn <?php if(!$project->processed){echo 'disabled';}?>"><span class="glyphicon glyphicon-play text-blue" title="Create New Links"></span></button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="{{ url('project/delete/'.$project->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button class="btn"><span class="glyphicon glyphicon-remove text-red" title="Delete this Project"></span></button>
                        </form>
                    </td>
                    <td class="text-center">

                        <button class="btn" data-toggle="modal" data-project="{{$project->id}}" data-target="#editProject"><span class="glyphicon glyphicon-cog text-black" title="Edit this Project"></span></button>

                    </td>


                </tr>
                @endforeach
                <?php $projects = App\Project::where('public', '=', '1')->get(); ?>


                @foreach ($projects as $project)
                @if($project->user_id!=$user->id)
                <tr>

                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->source->resource_file_name}}</td>
                    <td>{{ $project->target->resource_file_name}}</td>
                    <td class="text-center">@if($project->public)
                        <span class="glyphicon glyphicon-ok-sign text-green" title="This project is Public"></span>
                        @else
                        <span class="glyphicon glyphicon-ban-circle text-red" title="This project is Private"></span>
                        @endif
                    </td>
                    <td>{{ $project->created_at }}</td>
                    <td class="text-center">
                        <form action="{{ url('settings/create_config/'.$project->id) }}" method="POST">
                           <button class="btn"><span class="glyphicon glyphicon-link text-green" title="Calculate Similarities"></span></button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="{{ url('createlinks/'.$project->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <button class="btn"><span class="glyphicon glyphicon-play text-blue" title="Create New Links"></span></button>
                        </form>
                    </td>
                    <td class="text-center">
                       <button class="btn" onclick="noPermissionProject()"><span class="glyphicon glyphicon-remove text-red" title="You do not have permission to delete this file. Only the owner of this file can delete it"></span></button>
                    </td>
                    <td class="text-center">
                        
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
    function noPermissionProject(){
        $.toaster({ priority : 'error', title : 'Error', message : 'You do not have permission to delete this project.'});
    }
</script>








