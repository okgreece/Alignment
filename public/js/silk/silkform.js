


function erasePath(field) {

document.getElementById(field).value="";

}

function showpaths(p) {

var path="path"+p;
var field_a = "path"+p+"a";
var field_b = "path"+p+"b";
var field2_a = "trans"+p+"a";
var field2_b = "trans"+p+"b";
var field2_c = "trans"+p+"c";
var field2_d = "trans"+p+"d";

if(document.getElementById(path).style.display=="none"){
document.getElementById(path).style.display="block";
document.getElementById(field_a).value="source path";
document.getElementById(field_b).value="target path";
document.getElementById(field2_a).value="none";
document.getElementById(field2_b).value="none";
document.getElementById(field2_c).value="none";
document.getElementById(field2_d).value="none";
}
else if(document.getElementById(path).style.display=="block")
document.getElementById(path).style.display="none";
}

function changeSource() {

if(document.getElementById("sds_type").value=="sparqlEndpoint"){
document.getElementById("source_selection").innerHTML='<table class="table_box"><colgroup span="1" style="width:180px;"></colgroup><colgroup span="1" style="width:240px;"></colgroup><tr><td align="center">endpointURI</td><td align="center"><input type="text" name="source_var1"></td></tr><tr><td align="center">graph</td><td align="center"><input type="text" name="source_var2"></td></tr></table>';
}

else if(document.getElementById("sds_type").value=="file"){
document.getElementById("source_selection").innerHTML='<table class="table_box"><colgroup span="1" style="width:180px;"></colgroup><colgroup span="1" style="width:240px;"></colgroup><tr><td align="center">file path</td><td align="center"><input type="text" name="source_var1"></td></tr><tr><td align="center">format</td><td align="center"><select name="source_var2"><option value="RDF/XML">RDF/XML</option><option value="N-TRIPLE">N-TRIPLE</option><option value="TURTLE">TURTLE</option><option value="TTL">TTL</option><option value="N3">N3</option></select></td></tr></table>';
}

}


function changeTarget() {

if(document.getElementById("tds_type").value=="sparqlEndpoint"){
document.getElementById("target_selection").innerHTML='<table class="table_box"><colgroup span="1" style="width:180px;"></colgroup><colgroup span="1" style="width:240px;"></colgroup><tr><td align="center">endpointURI</td><td align="center"><input type="text" name="target_var1"></td></tr><tr><td align="center">graph</td><td align="center"><input type="text" name="target_var2"></td></tr></table>';
}

else if(document.getElementById("tds_type").value=="file"){
document.getElementById("target_selection").innerHTML='<table class="table_box"><colgroup span="1" style="width:180px;"></colgroup><colgroup span="1" style="width:240px;"></colgroup><tr><td align="center">file path</td><td align="center"><input type="text" name="target_var1"></td></tr><tr><td align="center">format</td><td align="center"><select name="target_var2"><option value="RDF/XML">RDF/XML</option><option value="N-TRIPLE">N-TRIPLE</option><option value="TURTLE">TURTLE</option><option value="TTL">TTL</option><option value="N3">N3</option></select></td></tr></table>';
}
}



