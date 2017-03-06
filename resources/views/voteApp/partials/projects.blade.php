@foreach($projects as $project)
<div class="col-lg-4">
    <div class="project-box panel panel-primary">
        <div class="project-header panel-heading">
            {{$project->name}}
        </div>
        <div class="project-actions panel-body">
            Creator: 
        <!--<img class="profile-user-img img-responsive img-circle" src="{{$project->user->avatar?:asset('/img/avatar04.png')}}" alt="User profile picture">-->
            <a href='profile/{{$project->user->id}}' target="_blank"  title='Show user profile'>{{ $project->user->name }}</a>
<!--            Links: {{$project->links->count()}}-->
            <div class="btn-group btn-group-lg" role="group" aria-label="Action button groups"> 
                <button type="button" class="btn btn-default">Overview</button>
                <button type="button" class="btn btn-success" onclick="getPoll({{$project->id}}, {{$project->user->id}})">Vote</button>
            </div>
        </div>
    </div>
</div>
@endforeach    