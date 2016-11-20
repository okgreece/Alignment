<div id="{{$link->id}}" class="candidate">
    

<div class="link-info box box-info">
    <div class="box-body">
        @include('votes.linkOverview', $link)
    </div>
    <div class="box-footer">
        @include('votes.voteButtons', $link)
    </div>
    
    
</div>
    
</div>