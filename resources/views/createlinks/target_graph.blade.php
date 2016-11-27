<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
var margin = {top: 30, right: 20, bottom: 30, left: 20},
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

d3.json("<?php echo $_SESSION["target_json"];?>", function(error, flare_right) {
  if (error) throw error;

  flare_right.x0 = 0;
  flare_right.y0 = 0;
  update_right(root_right = flare_right);
  
  
  
  
  // Initialize the display to show a few nodes.
  root_right.children.forEach(closeAll);
  
  update_right(root_right = flare_right);
  

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
      .attr("class", "node")
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

  nodeEnter_right.append("text")
      .attr("dy", 3.5)
      .attr("dx", 5.5)
      .attr("clip-path","url(#clip_path2)")
      .text(function(d) { return d.name; });
      
  nodeEnter_right.append("url")
       .text(function(d) { return d.url; });
  
  //tooltip creation
    nodeEnter_right.append("rect")
      .attr("y", -barHeight / 2)
      .attr("height", barHeight)
      .attr("width", function(d) { 
            var myWidth = 0;
            if(d.name.length<(barWidth/5)){
              myWidth = barWidth;
            }
            else {
              myWidth = (d.name.length*5)+20;
            }
            return myWidth; })
      .attr("class","tooltip")
      .style("fill", "yellow")
      .style("fill-opacity","1")
      .on("click", click_right);
      
      
  
    nodeEnter_right.append("text")
      .attr("dy", 3.5)
      .attr("dx", 5.5)
      .attr("class","tooltip")      
      .text(function(d) { return d.name; });

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
}

// Toggle children on click.
function click_right(d) {
    //trick to change color on selected rect
  $("#selected_target").removeAttr('id');
  $(this).siblings("rect").attr('id','selected_target');
  
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  $("#target_info").load("utility/infobox",{"url":d.url,'dump':"target"});
  update_right(d);
}

function color(d) {
    if(d.class2){
        return "green";
    }
    else if(d.class == "found"){
        return "blue";
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
  //return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
}
</script>