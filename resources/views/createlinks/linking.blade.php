<script>
    $(function () {
        $('#SiLK').slimScroll({
            height: '280px'
        });
        $('#create_links').slimScroll({
            height: '280px'
        });

    });
</script>
<script>
$(document).ready(function(){
    
    $("#radio").load(
                    "{{URL::to("/")}}/linktype/update",
                    { "group" : "SKOS" ,
                    }
                );
});

function updateRadio(){
    var group = $("#group-selector")[0].value;
    
    $("#radio").load(
                    "{{URL::to("/")}}/linktype/update",
                    { "group" : group,
                    }
                );
}
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
                @include('createlinks.partials.groups')
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="create_links" >
                    <div class="container" id="link_chooser">
                        @include('createlinks.linking_form')
                    </div>
                    <div id="links-utility" hidden="">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<div id="created_links" class="row">
    <div class="box box-primary" id="SiLK">
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
<script>
    var previous_url = '';
    function click_button(url) {  
        if((url !== previous_url) ){
        searchField = "d.url";
        searchText = fixedEncodeURIComponent(url);
        clearAll(root_right);
        expandAll(root_right);
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
$("#searchName").on("select2-selecting", function(e) {
    clearAll(root);
    expandAll(root);
    searchField = "d.name";
    searchText = e.object.text;
    searchTree(root);
    console.log(e);
    root.children.forEach(collapseAllNotFound);
    $('#comparison').html('<img id="spinner" src="../img/spinner.gif"/>'); 
    $("#source_info").load("utility/infobox",{"url":e.object.url,'dump':"source"});
    $("#comparison").load("utility/comparison/{{$project->id}}",{"url":e.object.url});
    update(root);
});

$("#searchName2").on("select2-selecting", function(e) {
    clearAll(root_right);
    expandAll(root_right);
    searchField = "d.name";
    searchText = e.object.text;
    searchTree(root_right);
    console.log(e);
    root_right.children.forEach(collapseAllNotFound);
    $("#target_info").load("utility/infobox",{"url":e.object.url,'dump':"target"});
    update_right(root_right);
});

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
</script>
