@include('links.project.script')
<?php
    $source_graph = $_SESSION["source_graph"];
    $target_graph = $_SESSION["target_graph"];
    $ontologies_graph = \Illuminate\Support\Facades\Cache::get('ontologies_graph');
?>
<div class="box">
    <div class="box-header">
      <h3 class="box-title"></h3>
      <button id="refresh" class="btn btn-primary" onclick="refresh_table()" title="Refresh Link Table"><i class="fa fa-repeat"></i></button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#export-dialog">Export</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="myTable" class="table table-bordered table-striped table-hover">
        @include('links.project.table_header')
        <tbody><?php $links = $project->links;
                    
                ?>
                <?php 
                    $prefixes = App\Prefix::all(); 
                    foreach($prefixes as $prefix){
                      EasyRdf_Namespace::set($prefix->prefix, $prefix->namespace);
                    }
                ?>
                @foreach ($links as $link)
                    @include('links.project.table_rows')
                @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
</div>
