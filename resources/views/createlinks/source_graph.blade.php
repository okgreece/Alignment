<script>
var margin = {top: 30, right: 20, bottom: 30, left: 20},
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
 
d3.json("<?php echo $_SESSION["source_json"];?>", function(error, flare) {
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
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      .style("opacity", 1e-6);
      

  
  
  
  // Enter any new nodes at the parent's previous position.
  nodeEnter.append("rect")
      .attr("y", -barHeight / 2)
      .attr("height", barHeight)
      .attr("width", barWidth)
      .style("fill", color)
      .on("click", click);
      

  nodeEnter.append("text")
      .attr("dy", 3.5)
      .attr("dx", 5.5)
      .attr("clip-path","url(#clip_path1)")      
      .text(function(d) { return d.name; });
      
  nodeEnter.append("url")
       .text(function(d) { return d.url; });
    
    //tooltip creation
    nodeEnter.append("rect")
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
      .on("click", click);
  
    nodeEnter.append("text")
      .attr("dy", 3.5)
      .attr("dx", 5.5)
      .attr("class","tooltip")      
      .text(function(d) { return d.name; });
      
      

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

  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
}

// Toggle children on click.
function click(d) {
  //trick to change color on selected rect
  $("#selected_source").removeAttr('id');
  $(this).siblings("rect").attr('id','selected_source');
  
  // children finder
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  //infobox update
  
  $('#comparison').html('<img id="spinner" src="../img/spinner.gif"/>'); 
  $("#source_info").load("utility/infobox",{"url":d.url,'dump':"source"});
  
  $("#comparison").load("utility/comparison/{{$project->id}}",{"url":d.url});
          update(d);
  
  
  
}

function color(d) {
  return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
}

</script>
