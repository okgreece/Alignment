<div>Project Overview
    <div>
        Name: {{$project->name}}
    </div>
    <div>
        Total links: {{sizeOf($project->links)}}
    </div>
    <div>
        Creator: <a href='profile/{{$project->user->id}}'>{{$project->user->name}}</a>
    </div>
    {!! Form::open(['method' => 'POST', 'url' => 'createlinks/' . $project->id]) !!}
        <button type="submit"><i class="glyphicon glyphicon-play"></i>Create New Links</button>
    {!! Form::close() !!}
</div>