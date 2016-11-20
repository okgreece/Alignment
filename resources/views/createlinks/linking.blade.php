<script>
    function click_button(url) {  
        $("#target_info").load("utility/infobox",{"url":url,"dump":"target"});
    }            
</script>
<script>
    $(function(){
    $('#SiLK').slimScroll({
        height: '280px'
    });
    $('#create_links').slimScroll({
        height: '280px'
    });
    
});
</script>
<div id="linking_wrapper" class="row">
   
        <h3 class="ui-widget-header">Link Creation Helpers</h3>
        <div class="col-md-6">
        
    
        <div class="box box-primary" id="SiLK">
            <div class="box-header with-border">
                <h3 class="box-title">SiLK Scores</h3>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="comparison">
           
            </div>
            </div>
            <!-- /.box-body -->
        </div>
        
    </div>
        <div class="col-md-6">
        
    
        <div class="box box-primary" id="link_form">
            <div class="box-header with-border">
                <h3 class="box-title">Choose link type to create:</h3>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="create_links">
            <div id="link_chooser">
                @include('createlinks.linking_form')
            </div>
            <div id="links-utility">
<!--                <p>Status:</p>                -->
            </div>
            
            
        </div>
            </div>
            <!-- /.box-body -->
        </div>
        
    </div>
        
            
    </div>

<div id="created_links" class="row">
        <div class="box box-primary collapsed-box" id="SiLK">
            <div class="box-header with-border">
                <h3 class="box-title">Created Links</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="links">
               @include('links.link_table')
                
            </div>
            </div>
            <!-- /.box-body -->
        </div>
 </div>
        