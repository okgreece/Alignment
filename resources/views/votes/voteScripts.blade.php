<script>
    var user= {{Auth::user()->id}};
    
    $('form.textarea').attr('autocomplete', 'off');
    
    function upvote(id, event){
    $.ajax({
    type: "POST",
            url:  'vote',
            data: {link_id : id, user_id : user, vote : 1},
            success: function(msg) {
            $("#up-" + id).children('span').html(msg["up_votes"]);
            $("#down-" + id).children('span').html(msg["down_votes"]);
            if (msg["valid"] == true){
            $.toaster({ priority : 'success', title : 'Success', message : msg["message"]});
            }
            else{
            $.toaster({ priority : 'error', title : 'Error', message : msg["message"]});
            };
            }
    });
    };
    
    function downvote(id, event){
    $.ajax({
    type: "POST",
            url:  'vote',
            data: {link_id : id, user_id : user, vote : - 1},
            success: function(msg) {
            $("#up-" + id).children('span').html(msg["up_votes"]);
            $("#down-" + id).children('span').html(msg["down_votes"]);
            if (msg["valid"] == true){
            $.toaster({ priority : 'success', title : 'Success', message : msg["message"]});
            }
            else{
            $.toaster({ priority : 'error', title : 'Error', message : msg["message"]});
            };
            }
    });
    };
    
    
    var infoModal = $('#comment-modal');
    $('.modal-toggle').on('click', function(){
        var id = $(this).data('id');
        $("#postCommentButton").attr('onclick', 'postcomment('+id+')');
         $.ajax({
    type: "POST",
            url:  'comments/show',
            data: {link_id : id},
            success: function(data){
            console.log(data);
            if($.isEmptyObject(data)){
                $(".modal-body").html('No Comments Yet!!!');
            }
            
            else{
                var counter = data.length;
                var i;
                document.querySelector('.modal-body').innerHTML='';
                var content = document.querySelector('template').content;
                for(i = 0; i < counter; i++){
                    var commentAvatar = content.querySelector('.avatar');
                    var commentText = content.querySelector('.comment-text');
                    var commentUser = content.querySelector('.user');
                    var commentDate = content.querySelector('.date');
                    
                    commentText.innerHTML = data[i].text;
                    commentUser.textContent = data[i].user;
                    var date = new Date(data[i].date.date);
                    commentDate.textContent = date.toLocaleString();
                    
                    document.querySelector('.modal-body').appendChild(
                    document.importNode(content, true));
                    
                }
                
            }
            }
    });
    });
    
    function postcomment(id) {
        var form = $('form')[0];
        var token = form[0].value;
        var body = form[1].value;
        $(".textarea").val('');
        console.log(body);
        $.ajax({
        type: "POST",
            url:  'comments/create',
            data: {link_id : id, user_id : user, body : body, _token : token},
            success: function(data){
                $("#comment-modal .close").click();
            }
    });
   
    };
    
    function preview(uri){
    $.ajax({
    type: "POST",
            url:  'preview',
            data: {uri:uri},
            success: function(msg) {
            if (msg["valid"] == true){
                $('.popover-content').html(msg["message"]);
            }
            else{
            $.toaster({ priority : 'error', title : 'Error', message : msg["message"]});
            };
            }
    });
    };
    
    
</script>

