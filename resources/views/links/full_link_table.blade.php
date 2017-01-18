@include('links.script')
<div class="box" width="80%">
    <div class="box-header">
      <h3 class="box-title">Links Overview</h3>
      <button id="refresh" class="btn btn-primary" onclick="refresh_table()" title="Refresh Link Table"><i class="fa fa-repeat"></i></button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#export-dialog" title="Export Links">Export</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="myTable" class="table table-bordered table-responsive table-striped table-hover display" width="100%">
        @include('links.table_header')
        <tbody>
            <?php 
                $prefixes = App\Prefix::all(); 
                foreach($prefixes as $prefix){
                    EasyRdf_Namespace::set($prefix->prefix, $prefix->namespace);
                }                
            ?>            
            <?php $links = $user->links;?>
                @foreach ($links as $link)
                    <?php 
                    $source_entity = EasyRdf_Namespace::shorten($link->source_entity, true); 
                    $link_type = EasyRdf_Namespace::shorten($link->link_type, true);
                    $target_entity = EasyRdf_Namespace::shorten($link->target_entity, true);
                    ?>
                    @include('links.table_rows')
                @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
</div>
