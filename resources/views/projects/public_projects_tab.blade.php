<table id="myTable2" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Project ID</th>
            <th>Project Name</th>
            <th>Source Ontology</th>
            <th>Target Ontology</th>
            <th>Public</th>
            <th>Created at</th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
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