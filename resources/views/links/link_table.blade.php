<script>    
$(document).ready(function() {
    $('#myTable').DataTable( {
        "columnDefs": [
            { "orderable": false, "targets": [] },
            { "searchable": false, "targets": [] }
            
        ]
} );
});
</script>

<div class="box">
    <div class="box-header">
      <h3 class="box-title"></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <button id="refresh" class="btn btn-primary" onclick="refresh_table()" title="Refresh Link Table"><i class="fa fa-repeat"></i></button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#export-dialog">Export</button>
      <table id="myTable" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
              <th>#</th>
              <th>Subject</th>
              <th>Property</th>
              <th>Object</th>
            </tr>
        </thead>
        <tbody><?php $links = $project->links; $counter = 0; ?>
                <?php 
                    $prefixes = App\Prefix::all(); 
                    foreach($prefixes as $prefix){
                      EasyRdf_Namespace::set($prefix->prefix, $prefix->namespace);
                    }
                ?>
          
                @foreach ($links as $link)
                <tr>
                    <?php                
                        $source_entity = EasyRdf_Namespace::shorten($link->source_entity, true); 
                        $link_type = EasyRdf_Namespace::shorten($link->link_type, true);
                        $target_entity = EasyRdf_Namespace::shorten($link->target_entity, true);              
                    ?>
                    <?php $counter = $counter+1; ?>
                    <td>{{ $counter}}</td>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($source_entity)}}">{{ $source_entity }}</td>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($link_type)}}">{{ $link_type }}</td>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($target_entity)}}">{{ $target_entity }}</td>
                </tr>
                @endforeach
            
        </tbody>

      </table>
    </div>
    <!-- /.box-body -->
</div>
