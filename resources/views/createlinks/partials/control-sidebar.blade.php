{{--TODO:fix hidding procedure to be persistent--}}
<div class="control-sidebar-subheading">
    Source Graph
</div>
<a class="btn btn-app source-hide" onclick="hideConnected(this, 'source')"><i class="fa fa-eye"></i><span>Hide connected</span></a>

<div class="control-sidebar-subheading">
    Target Graph
</div>
<a class="btn btn-app source-hide" onclick="hideConnected(this, 'target')"><i class="fa fa-eye"></i><span>Hide connected</span></a>
<script>
    function hideConnected(element, graph){
        $("g."+graph+"_node circle.connected").parent().fadeToggle( "slow", "linear" );
        var icon = $(element).children()[0];
        $(icon).removeClass("fa-eye").addClass("fa-eye-slash");
        var text = $(element).children()[1];
        $(text).text("Show connected");
        $(element).attr('onclick','showConnected(this, "'+graph+'")');
    }

    function showConnected(element, graph){
        $("g."+graph+"_node circle.connected").parent().fadeToggle( "slow", "linear" );
        var icon = $(element).children()[0];
        $(icon).removeClass("fa-eye-slash").addClass("fa-eye");
        var text = $(element).children()[1];
        $(text).text("Hide connected");
        $(element).attr('onclick','hideConnected(this, "'+graph+'")');
    }
</script>