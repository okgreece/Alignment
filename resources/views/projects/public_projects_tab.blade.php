<table id="myTable2" class="table table-bordered table-striped table-hover">
    @include('projects.table_header')
    <tbody>
        <?php $projects = App\Project::where('public', '=', '1')->get(); ?>
        @foreach ($projects as $project)
        @if($project->user_id!=$user->id)
        <tr>
            @include('projects.table_project_info')
            <td class="text-center">
                <form action="{{ route('myprojects.prepareproject', ['id' => $project->id]) }}" method="GET">
                    <button title="Calculate Similarities" class="btn"><span class="glyphicon glyphicon-link text-green" ></span></button>
                </form>
            </td>
            <td class="text-center">
                <form action="{{ url('createlinks/'.$project->id) }}" method="GET">
                   
                    <button title="Create New Links" class="btn"><span class="glyphicon glyphicon-play text-blue" ></span></button>
                </form>
            </td>
            <td class="text-center">
                <button title="You do not have permission to delete this file. Only the owner of this file can delete it." class="btn" onclick="noPermissionProject()"><span class="glyphicon glyphicon-remove text-red"></span></button>
            </td>
            <td class="text-center">
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>