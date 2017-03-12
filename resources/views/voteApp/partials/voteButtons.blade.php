<?php
$nocomments = $candidate->comments()->count();
?>
<ul class="list-inline">
    
    <button id="up-{{$candidate->id}}" type="button" class="btn btn-success" onclick="upvote({{$candidate->id}}, event, {{$key+1}})" >Up Vote</button>
    <button id="skip-{{$candidate->id}}" type="button" class="btn btn-warning" onclick="skip({{$key+1}})">Skip</button>
    <button id="down-{{$candidate->id}}" type="button" class="btn btn-danger" onclick="downvote({{$candidate->id}}, event, {{$key+1}})">Down Vote</button>
    <a id="comment-{{$candidate->id}}" class="link-black text-sm modal-toggle" data-toggle="modal" data-target="#comment-modal" data-id="{{$candidate->id}}">
            <i class="fa fa-comments-o margin-r-5"></i>
            Comments ({{$nocomments}})
        </a>
    <li class="pull-right">
        
    </li>
</ul>