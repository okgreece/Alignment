<script>
var margin = {top: 30, right: 20, bottom: 30, left: 100},
    width = 960 - margin.left - margin.right,
    barHeight = 20,
    barWidth = width * .3;

var i_right = 0,
    duration = 400,
    root_right;

var tree_right = d3.layout.tree()
    .nodeSize([0, 20]);

var diagonal_right = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var svg_right = d3.select("div#target").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("id","right")
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    
    //add clippath
  d3.select("svg").append("clipPath")
          .attr("id","clip_path2")
          .append("rect")
          .attr("x",-10)
          .attr("y",-10)
          .attr("width",barWidth+"px")
          .attr("height",barHeight+"px");

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

$(document).ready(function(){
    d3.json("{{$_SESSION["target_json"]}}", function(error, flare_right) {
  if (error) throw error;

  flare_right.x0 = 0;
  flare_right.y0 = 0;
  update_right(root_right = flare_right); 
  
  // Initialize the display to show a few nodes.
  root_right.children.forEach(closeAll);
  
  update_right(root_right = flare_right);
  
  select2Data2 = [];
  select2DataCollectName2(root_right);
  select2DataObject2 = [];
  select2Data2.sort(function(a, b) {
            if (a > b) return 1; // sort
            if (a < b) return -1;
            return 0;
        })
        .filter(function(item, i, ar) {
            return ar.indexOf(item) === i;
        }) // remove duplicate items
        .filter(function(item, i, ar) {
            select2DataObject2.push({
                "id": i,
                "text": item.name,
                "url" : item.url
            });
            //console.log(item);
        });
    //console.log(select2Data);
  $("#searchName2").select2({
        data: select2DataObject2,
        containerCssClass: "search",
        placeholder: "search a target element",
        allowClear:true
  });
});

});

// Toggle children.
function toggle(d) {
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
}

function update_right(source) {

  // Compute the flattened node list. TODO use d3.layout.hierarchy.
  var nodes_right = tree_right.nodes(root_right);

  var height_right = Math.max(500, nodes_right.length * barHeight + margin.top + margin.bottom);

  d3.select("svg#right").transition()
      .duration(duration)
      .attr("height", height_right);

  d3.select(self.frameElement).transition()
      .duration(duration)
      .style("height", height_right + "px");

  // Compute the "layout".
  nodes_right.forEach(function(n_right, i_right) {
    n_right.x = i_right * barHeight;
  });

  // Update the nodes…
  var node_right = svg_right.selectAll("g.node")
      .data(nodes_right, function(d) { return d.id || (d.id = ++i_right); });

  var nodeEnter_right = node_right.enter().append("g")
      .attr("class", "node target_node")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      .attr("id", function(d) { return d.id ;})
      .style("opacity", 1e-6);

  // Enter any new nodes at the parent's previous position.
  nodeEnter_right.append("rect")
      .attr("y", -barHeight / 2)
      .attr("height", barHeight)
      .attr("width", barWidth)
      .style("fill", color)
      .on("click", click_right);

  nodeEnter_right.append("circle")
      .attr("cy", 0)
      .attr("cx", -15)
      .attr("r", 6)
      .style("fill", "lightgray")
      .style("stroke", "black")
      .style("stroke-width", 1)
      .on("click", click_right);

  nodeEnter_right.append("text")
      .attr("dy", 3.5)
      .attr("dx", 5.5)
      .attr("clip-path","url(#clip_path2)")
      .text(function(d) { return d.name; });
      
  nodeEnter_right.append("url")
       .text(function(d) { return d.url; });
  
  //tooltip creation
//    nodeEnter_right.append("rect")
//      .attr("y", -barHeight / 2)
//      .attr("height", barHeight)
//      .attr("width", function(d) { 
//            var myWidth = 0;
//            if(d.name.length<(barWidth/5)){
//              myWidth = barWidth;
//            }
//            else {
//              myWidth = (d.name.length*5)+20;
//            }
//            return myWidth; })
//      .attr("class","tooltip")
//      .style("fill", "yellow")
//      .style("fill-opacity","1")
//      .on("click", click_right);     
//  
//    nodeEnter_right.append("text")
//      .attr("dy", 3.5)
//      .attr("dx", 5.5)
//      .attr("class","tooltip")      
//      .text(function(d) { return d.name; });

  // Transition nodes to their new position.
    nodeEnter_right.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
      .style("opacity", 1);

    node_right.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
      .style("opacity", 1)
      .select("rect")
      .style("fill", color);

  // Transition exiting nodes to the parent's new position.
  node_right.exit().transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
      .style("opacity", 1e-6)
      .remove();

  // Update the links…
  var link_right = svg_right.selectAll("path.link")
      .data(tree_right.links(nodes_right), function(d) { return d.target.id; });

  // Enter any new links at the parent's previous position.
  link_right.enter().insert("path", "g")
      .attr("class", "link")
      .attr("d", function(d) {
        var o = {x: source.x0, y: source.y0};
        return diagonal_right({source: o, target: o});
      })
    .transition()
      .duration(duration)
      .attr("d", diagonal_right);

  // Transition links to their new position.
  link_right.transition()
      .duration(duration)
      .attr("d", diagonal_right);

  // Transition exiting nodes to the parent's new position.
  link_right.exit().transition()
      .duration(duration)
      .attr("d", function(d) {
        var o = {x: source.x, y: source.y};
        return diagonal_right({source: o, target: o});
      })
      .remove();

  // Stash the old positions for transition.
  nodes_right.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
  
  var panZoomTarget = svgPanZoom('#right',{
      fit: false,
      zoomScaleSensitivity: 0.1,
      contain: false,
      center: false,
      minZoom: 0.7,
      mouseWheelZoomEnabled: false
    });
    document.getElementById('zoom-in-target').addEventListener('click', function(ev){
          ev.preventDefault()

          panZoomTarget.zoomIn()
        });

        document.getElementById('zoom-out-target').addEventListener('click', function(ev){
          ev.preventDefault()

          panZoomTarget.zoomOut()
        });

        document.getElementById('reset-target').addEventListener('click', function(ev){
          ev.preventDefault()

          panZoomTarget.resetZoom(),
          panZoomTarget.resetPan()
        });
    
    
}

// Toggle children on click.
function click_right(d) {
    //trick to change color on selected rect
  //$("#selected_target").removeAttr('id');
  //$(this).siblings("rect").attr('id','selected_target');
  
  clearAll(root_right);
  d.class = "found";
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  var collapsed_target = $("#target_info").hasClass("collapsed-box");
  $("#target_info").load("utility/infobox", {"url":d.url, 'dump':"target", "collapsed":collapsed_target});
  update_right(d);
}

function color(d) {
    if(d.class2){
        return "blue";
    }
    else if(d.class === "found"){
        return "green";
        }
    else if(d._children){
        return "#3182bd";
    }
    else if(d.children){
        return "#c6dbef";
    }
    else{
        return "#fd8d3c";
    }    
  
}
function indicator(d) {
    if(d.connected){
        //console.log("gotcha");
        return "connected";
        
    }
    else{
        return "";
    }    
  
}

</script>