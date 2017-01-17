<table id="myTable" class="table table-bordered table-striped table-hover">
    @include('projects.table_header')
    <tbody>
                <?php $projects = $user->projects;
                ?>
        @foreach ($projects as $project)
        <tr>
            @include('projects.table_project_info')
            <td class="text-center">
                <form action="{{ url('settings/create_config/'.$project->id) }}" method="POST">
                    <button title="Calculate Similarities" class="btn"><span class="glyphicon glyphicon-link text-green" ></span></button>
                </form>
            </td>
            <td class="text-center">
                <form action="{{ url('createlinks/'.$project->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button title="Create New Links" class="btn <?php if(!$project->processed){echo 'disabled';}?>"><span class="glyphicon glyphicon-play text-blue" ></span></button>
                </form>
            </td>
            <td class="text-center">
                <form action="{{ url('project/delete/'.$project->id) }}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button title="Delete this Project" class="btn"><span class="glyphicon glyphicon-remove text-red" ></span></button>
                </form>
            </td>
            <td class="text-center">
                <button title="Edit this Project" class="btn" data-toggle="modal" data-project="{{$project->id}}" data-target="#editProject"><span class="glyphicon glyphicon-cog text-black" ></span></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>      