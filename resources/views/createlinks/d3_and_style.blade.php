<link href="{{asset('/css/createlinks/graph_style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/infobox_style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/comparison.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/create_links.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/css/createlinks/style.css')}}" rel="stylesheet" type="text/css">
<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
    var previous_url = '';
    var previous_element = new Object;
    
    function click_button(url) {  
        //console.log((find_element(url)));  
        if((url !== previous_url) ){
        
        searchField = "d.url";
        
        searchText = fixedEncodeURIComponent(url);
        //var element = searchTree(root_right);
        clearAll(root_right);
    expandAll(root_right);
    update_right(root_right);
   
    searchTree(root_right);
    root_right.children.forEach(collapseAllNotFound);
    update_right(root_right);
        
        previous_url = url;
        $("#target_info").load("utility/infobox",{"url":url,"dump":"target"});
        }       
    } 
    
    //===============================================
    function fixedEncodeURIComponent (str) {
  return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}
//===============================================
function searchTree(d) {
    if (d.children)
        d.children.forEach(searchTree);
    else if (d._children)
        d._children.forEach(searchTree);
    var searchFieldValue = eval(searchField);
    //console.log(searchFieldValue);
    if (searchFieldValue && searchFieldValue == searchText) {
            //console.log("eureka", d);
            // Walk parent chain
            var ancestors = [];
            var parent = d;
            var counter = 0;
            while (typeof(parent) !== "undefined") {
                ancestors.push(parent);
		//console.log(parent);
                if(counter){
                    parent.class2 = "target";
                }
                parent.class = "found";
                parent = parent.parent;
                counter++;
            }
	    //console.log(ancestors);
            return ancestors;
    }
    
}

//===============================================
function clearAll(d) {
    d.class = "";
    d.class2 = ""; 
    if (d.children)
        d.children.forEach(clearAll);
    else if (d._children)
        d._children.forEach(clearAll);
}

//===============================================
function collapse(d) {
    if (d.children) {
        d._children = d.children;
        d._children.forEach(collapse);
        d.children = null;
    }
}

//===============================================
function collapseAllNotFound(d) {
    if (d.children) {
    	if (d.class !== "found") {
        	d._children = d.children;
        	d._children.forEach(collapseAllNotFound);
        	d.children = null;
	} else 
        	d.children.forEach(collapseAllNotFound);
    }
}

//===============================================
function expandAll(d) {
    if (d._children) {
        d.children = d._children;
        d.children.forEach(expandAll);
        d._children = null;
    } else if (d.children)
        d.children.forEach(expandAll);
}

//===============================================


//===============================================

</script>