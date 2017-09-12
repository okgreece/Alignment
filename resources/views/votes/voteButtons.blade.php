<?php
//    $comments = $link->comments();
$nocomments = $link->comments()->count();
?>
<ul class="list-inline">
    <a id="up-{{$link->id}}" class="btn btn-app bg-green {{$link->myvote === 1 ? 'disabled' : 'enabled'}}" onclick="upvote({{$link->id}}, event)">

        <span class="badge bg-purple">{{$link->up_votes}}</span>
        <i class="fa fa-thumbs-up"></i>
        Upvote
    </a>
    <a id="down-{{$link->id}}" class="btn btn-app bg-red {{$link->myvote === -1 ? 'disabled' : 'enabled'}}" onclick="downvote({{$link->id}}, event)">
        <span class="badge bg-purple">{{$link->down_votes}}</span>
        <i class="fa fa-thumbs-down"></i>
        Downvote
    </a>
    <li class="pull-right">
        <a id="comment-{{$link->id}}" class="link-black text-sm modal-toggle" data-toggle="modal" data-target="#comment-modal" data-id="{{$link->id}}">
            <i class="fa fa-comments-o margin-r-5"></i>
            Comments ({{$nocomments}})
        </a>
    </li>
</ul>