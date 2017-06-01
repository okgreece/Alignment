<button data-toggle="modal" data-target="#voter-modal">
    Select Project
</button>
<div id='project-overview' class='panel-body'>
</div>

<script>
    function select(){
        var id = $('#voter-form')[0][1].value;
        $.ajax({
        type: "POST",
            url:  'myvotes/project',
            data: {project_id : id},
            success: function(data){
                $("#project-overview").html(data);
                $("#voter-modal .close").click();
            }
    });
    }
</script>
@include('votes.voter-modal')