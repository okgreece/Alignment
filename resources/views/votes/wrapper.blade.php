@if(!empty($project))
    @include('votes.project-overview')
@endif
<div>
    @foreach($links as $link)
        @include('votes.candidate', $link)
    @endforeach
    
</div>

{{ $links->links() }}
@include('votes.voteScripts')
