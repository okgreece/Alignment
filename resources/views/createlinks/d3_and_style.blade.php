<link href="{{asset('/css/createlinks/graph_style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/infobox_style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/comparison.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/create_links.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/style.css')}}" rel="stylesheet" type="text/css">
<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
    function click_button(url) {  
        $("#target_info").load("utility/infobox.php",{"url":url,"dump":"target"});
    }            
</script>