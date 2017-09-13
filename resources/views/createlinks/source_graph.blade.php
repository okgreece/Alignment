<script>
    function select2DataCollectName(d) {
    if (d.children)
        d.children.forEach(select2DataCollectName);
    else if (d._children)
        d._children.forEach(select2DataCollectName);
    select2Data.push({"name": d.name , "url": d.url});
    
}

function select2DataCollectName2(d) {
    if (d.children)
        d.children.forEach(select2DataCollectName2);
    else if (d._children)
        d._children.forEach(select2DataCollectName2);
    select2Data2.push({"name": d.name , "url": d.url});
}
window.onload = function start(){
    check_connectivity();
    check_connectivity_right();
}

</script>

<script>
var margin = {top: 30, right: 20, bottom: 30, left: 100},
    width = 960 - margin.left - margin.right,
    barHeight = 20,
    barWidth = width * .3;

var i = 0,
    duration = 400,
    root;

var tree = d3.layout.tree()
    .nodeSize([0, 20]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var svg = d3.select("div#source").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr('id', 'left')
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

//add clippath
  d3.select("svg").append("clipPath")
          .attr("id","clip_path1")
          .append("rect")
          .attr("x",-10)
          .attr("y",-10)
          .attr("width",barWidth+"px")
          .attr("height",barHeight+"px");
  
$(document).ready(function(){
    source_graph("{{$_SESSION["source_json"]}}");
    target_graph("{{$_SESSION["target_json"]}}");
});

// Toggle children.

function source_graph(file){
    d3.json(file, function(error, flare) {
        if (error) throw error;
        flare.x0 = 0;
        flare.y0 = 0;
        function toggleAll(d) {
            if (d.children) {
                d.children.forEach(toggleAll);
                toggle(d);
            }
        }

        function closeAll(d) {
            if (d.children) {
                d.children.forEach(closeAll);
                toggle(d);
            }
        }
        // Initialize the display to show a few nodes.
        update(root = flare);
        root.children.forEach(closeAll);
        update(root = flare);
        //toggle(root.children[0].children[1]);

        select2Data = [];
        select2DataCollectName(root);
        select2DataObject = [];
        select2Data.sort(function(a, b) {
            if (a > b) return 1; // sort
            if (a < b) return -1;
            return 0;
        })
            .filter(function(item, i, ar) {
                return ar.indexOf(item) === i;
            }) // remove duplicate items
            .filter(function(item, i, ar) {
                select2DataObject.push({
                    "id": i,
                    "text": item.name,
                    "url" : item.url
                });
                //console.log(item);
            });
        //console.log(select2Data);
        $("#searchName").select2({
            data: select2DataObject,
            minimumInputLength: 3,
            containerCssClass: "search",
            placeholder: "search a source element",
            allowClear:true
        });
    });
}

function toggle(d) {
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
}

function update(source) {

  // Compute the flattened node list. TODO use d3.layout.hierarchy.
  var nodes = tree.nodes(root);
  
  var height = Math.max(500, nodes.length * barHeight + margin.top + margin.bottom);

  d3.select("svg").transition()
      .duration(duration)
      .attr("height", height);

  d3.select(self.frameElement).transition()
      .duration(duration)
      .style("height", height + "px");

  // Compute the "layout".
  nodes.forEach(function(n, i) {
    n.x = i * barHeight;   
  });
  
  // Update the nodes…
  var node = svg.selectAll("g.node")
      .data(nodes, function(d) { return d.id || (d.id = ++i); });

  var nodeEnter = node.enter().append("g")
      .attr("class", "node source_node")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      .style("opacity", 1e-6);

  // Enter any new nodes at the parent's previous position.
  nodeEnter.append("rect")
      .attr("y", -barHeight / 2)
      .attr("height", barHeight)
      .attr("width", barWidth)
      .style("fill", color)
      .on("click", click);
  //indicator node  
  nodeEnter.append("circle")
      .attr("cy", 0)
      .attr("cx", -15)
      .attr("r", 6)
      .attr("class", indicator)
      .style("fill", indicatorColor)
      .style("stroke", "black")
      .style("stroke-width", 1)
      .on("click", click);
  
  nodeEnter.append("text")
      .attr("dy", 3.5)
      .attr("dx", 5.5)
      .attr("clip-path","url(#clip_path1)")      
      .text(function(d) { return d.name; });
      
  nodeEnter.append("url")
       .text(function(d) { return d.url; });
    
  // Transition nodes to their new position.
  nodeEnter.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
      .style("opacity", 1);

  node.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
      .style("opacity", 1)
    .select("rect")
      .style("fill", color);

  // Transition exiting nodes to the parent's new position.
  node.exit().transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
      .style("opacity", 1e-6)
      .remove();
    //TODO:decide if the links will remain -> removed gives better performance
  /*
  // Update the links…
  var link = svg.selectAll("path.link")
      .data(tree.links(nodes), function(d) { return d.target.id; });

  // Enter any new links at the parent's previous position.
  link.enter().insert("path", "g")
      .attr("class", "link")
      .attr("d", function(d) {
        var o = {x: source.x0, y: source.y0};
        return diagonal({source: o, target: o});
      })
    .transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition links to their new position.
  link.transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition exiting nodes to the parent's new position.
  link.exit().transition()
      .duration(duration)
      .attr("d", function(d) {
        var o = {x: source.x, y: source.y};
        return diagonal({source: o, target: o});
      })
      .remove();
  */
  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
    if(d.class === "found"){
        $("#source").slimScroll({scrollTo: d.x + 'px'});
    }
  });
  
  var panZoomTarget = svgPanZoom('#left',{
      fit: false,
      zoomScaleSensitivity: 0.1,
      contain: false,
      center: false,
      minZoom: 0.7,
      mouseWheelZoomEnabled: false
    });
    document.getElementById('zoom-in-source').addEventListener('click', function(ev){
          ev.preventDefault()

          panZoomTarget.zoomIn()
        });

        document.getElementById('zoom-out-source').addEventListener('click', function(ev){
          ev.preventDefault()

          panZoomTarget.zoomOut()
        });

        document.getElementById('reset-source').addEventListener('click', function(ev){
          ev.preventDefault()

          panZoomTarget.resetZoom(),
          panZoomTarget.resetPan()
        });
}

// Toggle children on click.
function click(d) {
  
  // children finder
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  clearAll(root);
  d.class = "found";
  //infobox update
  
  $('#comparison').html('<img id="spinner" src="../img/spinner.gif"/>');
  var collapsed = $("#source_info").hasClass("collapsed-box");
  $("#source_info").load("utility/infobox",{"uri":d.url,'dump':"source", "collapsed":collapsed, "project_id":{{$project->id}}});
  $("#comparison").load("utility/comparison/{{$project->id}}",{"url":d.url});
  update(d);
  
}

function check_connectivity(){
    
    var nodes = $(".source_node")
    $.ajax({
    type: "GET",
            url: "utility/connected",
            data: {project_id : {{$project->id}}, type : "source"},
            success: function(data){
                var connected = JSON.parse(data);
                $.each(nodes, function(i, n) {
                    var flag = false;
                    connected.forEach(function(e, j){
                        if (n.children[3].innerHTML === fixedEncodeURIComponent(e)) {
                            n.children[1].setAttribute("class", "connected");
                            flag = true;
                            return;
                        }
                    });
                    if(n.children[1].className.baseVal === "connected" && !flag){
                        n.children[1].classList.remove("connected");
                    }
                });
                setTimeout(check_connectivity,3000);
            }
    });
}

function check_connectivity_right(){
    
    var nodes = $(".target_node")
    $.ajax({
    type: "GET",
            url: "utility/connected",
            data: {project_id : {{$project->id}}, type : "target"},
            success: function(data){
                var connected = JSON.parse(data);
                $.each(nodes, function(i, n) {
                    var flag = false;
                    connected.forEach(function(e, j){
                        if (n.children[3].innerHTML === fixedEncodeURIComponent(e)){
                           n.children[1].setAttribute("class", "connected");
                           flag = true;
                           return;
                        }
                    });
                    if(n.children[1].className.baseVal === "connected" && !flag){
                        n.children[1].classList.remove("connected");
                    }
                });
                setTimeout(check_connectivity_right, 3000);
            }
        });
}

</script>
