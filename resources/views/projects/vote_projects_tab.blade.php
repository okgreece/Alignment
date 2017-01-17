<table id="myTable3" class="table table-bordered table-striped table-hover">
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
                <?php $projects = [];
                ?>
        @foreach ($projects as $project)
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
    </tbody>
</table>      