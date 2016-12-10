<?= Form::open(['url' => route('mylinks.create'), 'method' => 'POST']) ?>
    <fieldset>
        
            <input type="radio" name="link_type" value="http://www.w3.org/2002/07/owl#sameAs" />owl:sameAs <br />
            <input type="radio" name="link_type" value="http://www.w3.org/2004/02/skos/core#exactMatch" />skos:exactMatch<br />
            <input type="radio" name="link_type" value="http://www.w3.org/2002/07/owl#seeAlso" />owl:seeAlso<br />
            <input id="other1" type="radio" name="link_type" value="other1" />Other<br />
                <?= Form::text("other-text1","",['name'=>"other-text1",'id'=>'other-text1', 'class'=>'form-control']) ?>
            <button type="button" id="create-btn" class="btn btn-success" title="Click to create the link" onclick="get_action()" >Create Link</button>
    </fieldset>
<?= Form::close() ?>
<div style="height: 350px" id="delete-dialog" title="Delete All" hidden="true">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
<script>
    
    function refresh_table(){
        var my_project = window.location.pathname;
        console.log(my_project.substr(my_project.lastIndexOf('/') + 1));
        var project_id = parseInt(my_project.substr(my_project.lastIndexOf('/') + 1),10);;
        $("#links").load("utility/link_table",{"project_id":project_id});
    }
    function delete_all(){
        var my_project = window.location.pathname;
        console.log(my_project.substr(my_project.lastIndexOf('/') + 1));
        var project_id = parseInt(my_project.substr(my_project.lastIndexOf('/') + 1),10);
        $("#links-utility").load("utility/delete_all",{"project_id":project_id},function(){
            $("#links").load("utility/link_table",{"project_id":project_id});
        })
    }
    function delete_dialog(){
        $(function() {
            $( "#delete-dialog" ).dialog({
              resizable: false,
              height:250,
              width:550,
              modal: true,
              buttons: {
                "Confirm Delete All": function() {
                  $( this ).dialog( "close" );
                  delete_all();
                },
                Cancel: function() {
                  $( this ).dialog( "close" );
                }
              }
            });
        });
    }
      
  function get_action() {
    var target = "";
    var source = "";
    var link_type = "";
    var data = $("fieldset").children().each(function(){
        if($(this).is(':checked')){
            if(this.value==="other1"){
                if($('#other-text1').val()===""){
                    alert("Other is checked. Please give a valid URL in textarea");
                    console.log('no url given');
                }
                else{
                    //TODO check if url is valid...
                    //checks
                    var myLink = $('#other-text1').val();
                    console.log(URLValidation(myLink));
                    if(URLValidation(myLink)){
                        console.log(myLink);
                        link_type = myLink;
                    }
                    else{
                        alert("Invalid URL given. Please give a valid URL in textarea");
                    }
                }
            }
            else{
                console.log(this.value);
                link_type = this.value;
            }

        }
    });
    var source = $('#details_source').children().first().attr('id');
    var target = $('#details_target').children().first().attr('id');
    if(source && target && link_type){
        console.log(source);
        console.log(target);
       
        /////////////////////////////////////////
        //only for test change this on production
        /////////////////////////////////////////
        var my_project = window.location.pathname;
        console.log(my_project.substr(my_project.lastIndexOf('/') + 1));
        var project_id = parseInt(my_project.substr(my_project.lastIndexOf('/') + 1),10);
        
        /////////////////////////////////////////
        $("#links-utility").load("utility/create",{"source":source,"target":target,"link_type":link_type,"project_id":project_id},function(){
        $.toaster({ priority : 'success', title : 'Success', message : 'Link Created Succesfully'});    
        $("#links").load("utility/link_table",{"project_id":project_id});}
        );
    }
}

function URLValidation(s) {    
    var match_url_re=/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S)?@)?(?:(?!10(?:.\d{1,3}){3})(?!127(?:.\d{1,3}){3})(?!169.254(?:.\d{1,3}){2})(?!192.168(?:.\d{1,3}){2})(?!172.(?:1[6-9]|2\d|3[0-1])(?:.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)[a-z\u00a1-\uffff0-9]+)(?:.(?:[a-z\u00a1-\uffff0-9]+-?)[a-z\u00a1-\uffff0-9]+)(?:.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
    //var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return match_url_re.test(s);    
}
</script>



