<script type="text/javascript" src="{{asset('/plugins/slimScroll/jquery.slimscroll.js')}}"></script>
<meta name="source_json" content="{{$_SESSION["source_json"]}}">
<meta name="target_json" content="{{$_SESSION["target_json"]}}">
<script>
    // Slimscroll Doc: http://rocha.la/jQuery-slimScroll    
    var wheelStep = '10px';
    $(function () {
        $('#details_source').slimScroll({
        height: '250px',
        wheelStep: wheelStep
    });
    $('#source').slimScroll({
        height: '250px',
        wheelStep: wheelStep
    });
    $('#details_target').slimScroll({
        height: '250px',
        wheelStep: wheelStep
    });
    $('#target').slimScroll({
        height: '250px',
        wheelStep: wheelStep
    });
});
</script>
<div id="info_wrapper" class="row">
    <!--    source graph code-->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Source</h3>
                <div id="block_container">
                    <div id="searchName"></div>
                </div>
                <div class="box-tools pull-right" >
                    <button id="sort-source" type="button" class="btn btn-box-tool sort-button" onclick="sortGraph('source')">Sort by Name</button>
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
                <div class="controls-source-graph">
                    <button id="zoom-in-source">Zoom in</button>
                    <button id="zoom-out-source">Zoom out</button>
                    <button id="reset-source">Reset</button>
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
                <div id="block_container2">
                    <div id="searchName2"></div>
                </div>
                <div class="box-tools pull-right">
                    <button id="sort-target" type="button" class="btn btn-box-tool sort-button" onclick="sortGraph('target')">Sort by Name</button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="target">
                    @include('createlinks.target_graph')
                </div>
                <div class="controls">
                    <button id="zoom-in-target">Zoom in</button>
                    <button id="zoom-out-target">Zoom out</button>
                    <button id="reset-target">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div id="target_info" class="box box-primary collapsed-box">
            @include('createlinks.partials.info',array("dump"=>"target"))
        </div>
    </div>
</div>
<script>
    function sortGraph(graph){
        var file,json,enabled,newJSON, meta;
        meta = $("meta[name=" + graph + "_json]").attr("content");
        json = meta.split(".");
        newJSON = json[0] + "name." + json[1];
        enabled = $("#sort-" + graph).hasClass("enabled");
        if(enabled){
            file = meta;
            $("#sort-" + graph).removeClass("enabled");
        }
        else{
            file = newJSON;
            $("#sort-"+ graph).addClass("enabled");
        }
        graph == "source" ? source_graph(file) : target_graph(file);
    }
</script>