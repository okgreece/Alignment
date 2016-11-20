<script type="text/javascript" src="{{asset('/plugins/slimScroll/jquery.slimscroll.js')}}"></script>
<script>
    $(function(){
    $('#details_source').slimScroll({
        height: '250px'
    });
    $('#source').slimScroll({
        height: '250px'
    });
    $('#details_target').slimScroll({
        height: '250px'
    });
    $('#target').slimScroll({
        height: '250px'
    });
});
</script>
<div id="info_wrapper" class="row">
    <!--    source graph code-->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Source</h3>
                <div class="box-tools pull-right" >
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="source"> 
                    @include('createlinks.source_graph')
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div id="source_info" class="box box-primary collapsed-box">
        @include('createlinks.partials.info',array("dump"=>"source"))
        </div>
        
    </div>

    <!--target graph code-->
    <div class="col-md-6">
        
    
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Target</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="target"> 
                    @include('createlinks.target_graph')
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div id="target_info" class="box box-primary collapsed-box">
        @include('createlinks.partials.info',array("dump"=>"target"))
        </div>
        </div>
  </div>

