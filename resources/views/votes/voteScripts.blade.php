<script>
    var user= {{Auth::user()->id}};
    
    $('form.textarea').attr('autocomplete', 'off');
    
    //function to upvote
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
    //function to downvote
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
    
    //function to update comment modal
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
                $("#comment-modal-body").html('No Comments Yet!!!');
            }
            
            else{
                var counter = data.length;
                var i;
                document.querySelector("#comment-modal-body").innerHTML='';
                var content = document.querySelector('template').content;
                for(i = 0; i < counter; i++){
                    var commentAvatar = content.querySelector('.avatar');
                    var commentText = content.querySelector('.comment-text');
                    var commentUser = content.querySelector('.user');
                    var commentDate = content.querySelector('.date');
                    
                    commentAvatar.innerHTML = '<img src="' + data[i].avatar + '" class="img-circle new comment-image" alt="User Image" />';
                    commentText.innerHTML = data[i].text;
                    commentUser.textContent = data[i].user;
                    var date = new Date(data[i].date.date);
                    commentDate.textContent = date.toLocaleString();
                    
                    document.querySelector("#comment-modal-body").appendChild(
                    document.importNode(content, true));
                    
                }
                
            }
            }
    });
    });
    //function to post a comment
    function postcomment(id) {
        var form = $('#comment-form')[0];
        var token = form[0].value;
        var body = form[1].value;
        $(".textarea").val('');
        
        $.ajax({
        type: "POST",
            url:  'comments/create',
            data: {link_id : id, user_id : user, body : body, _token : token},
            success: function(data){
                $("#comment-modal .close").click();
            }
    });
   
    };
    // function to get a preview of the entity
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
<script>
    // function to initiallize popovers
$(function () {
  $('[data-toggle="popover"]').popover({
      container: '.container',
     trigger: "focus",
     html: true,
  })
})
</script>
<script>
//    function to destroy previous tab
    function destroy(tab){
        if (tab == 1){
            
            $('#tab_1-body').html('');
         
        }
        else{
            $('#project-vote').html('');
            $.ajax({
                type: "GET",
                url:  'myvotes/mylinks',
                success: function(data) {
                    $('#tab_1-body').html(data);
                }
            });
            
        }
    }
</script>

