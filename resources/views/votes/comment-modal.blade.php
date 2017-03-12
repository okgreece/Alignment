@include('votes.comment')

<div id="comment-modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Comments</h4>
            </div>
            <div id="comment-modal-body" class="modal-body">
            </div>
            <div class="modal-footer">
                {!! Form::open(['id' => 'comment-form','url' => 'comments/create']) !!}
                {{Form::textarea('body','',array("placeholder" => "Enter your comment here...", "autocomplete" => "off", "class" => "textarea"))}}
                {{Form::button('Post Comment',array("onclick" => "postcomment()", "id" => "postCommentButton"))}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
