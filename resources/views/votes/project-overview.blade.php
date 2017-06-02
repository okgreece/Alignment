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
    {!! Form::open(['method' => 'GET', 'url' => 'createlinks/' . $project->id]) !!}
        <button type="submit"><i class="glyphicon glyphicon-play"></i>Create New Links</button>
    {!! Form::close() !!}
        <button type="submit" onclick="getPoll({{$project->id}}, {{auth()->user()->id}})"><i class="glyphicon glyphicon-play"></i>Start a New Poll</button>
    
</div>
<div id="candidates">
    @foreach($links as $link)
        @include('votes.candidate', $link)
    @endforeach
    {{ $links->appends(['project_id' => $project->id])->links() }}
</div>


@include('voteApp.partials.scripts')
@include('votes.comment-modal')