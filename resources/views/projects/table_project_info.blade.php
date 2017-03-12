<td>{{ $project->name }}</td>
<td><a href='profile/{{$project->user->id}}' title='Show user profile'>{{ $project->user->name }}</a></td>
<td>{{ $project->source->resource_file_name}}</td>
<td>{{ $project->target->resource_file_name}}</td>
<td class="text-center">@if($project->public)
    <span class="glyphicon glyphicon-ok-sign text-green" title="This project is Public"></span>
    @else
    <span class="glyphicon glyphicon-ban-circle text-red" title="This project is Private"></span>
    @endif
</td>
<td>{{ $project->created_at }}</td>