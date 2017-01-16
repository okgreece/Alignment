<script>    
$(document).ready(function() {
    $('#myTable').DataTable( {
        "columnDefs": [
            { "orderable": false, "targets": [-1] },
            { "searchable": false, "targets": [-1] },
            { "width":"20%", "targets": [2,3,4,]}
        ],
        "fixedColumns":true,
        "autoWidth":false,
        "scrollX" :true
    });
});


</script>

<div class="box" width="80%">
    <div class="box-header">
      <h3 class="box-title"></h3>
      
    </div>
    
    <!-- /.box-header -->
    <div class="box-body">
        <button id="refresh" class="btn btn-primary" onclick="refresh_table()" title="Refresh Link Table"><i class="fa fa-repeat"></i></button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#export-dialog">Export</button>
        <!--        <button id="export" class="btn btn-primary" onclick="export_table('rdfxml')">Export</button>-->
      <table id="myTable" class="table table-bordered table-responsive table-striped table-hover display" width="100%">
        <thead>
            <tr>
              <th>#</th>
              <th>Project</th>
              <th>Subject</th>
              <th>Property</th>
              <th>Object</th>              
              <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $prefixes = App\Prefix::all(); 
                foreach($prefixes as $prefix){
                    EasyRdf_Namespace::set($prefix->prefix, $prefix->namespace);
                }
                
            ?>
            
            <?php $projects = $user->projects; $counter = 0; ?>
            @foreach($projects as $project)
            <?php $links = $project->links;?>
                @foreach ($links as $link)
               <?php 
               
               $source_entity = EasyRdf_Namespace::shorten($link->source_entity, true); 
               $link_type = EasyRdf_Namespace::shorten($link->link_type, true);
               $target_entity = EasyRdf_Namespace::shorten($link->target_entity, true);
               
               
               ?>
                <tr>
                    <?php $counter = $counter+1; ?>
                    <td>{{ $counter}}</td>
                    <td>{{ $link->project->name }}</td>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($source_entity)}}">{{ $source_entity }}</td>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($link_type)}}">{{ $link_type }}</td>
                    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($target_entity)}}">{{ $target_entity }}</td>

                    <td class="text-center">
                        <form action="{{ url('createlinks/utility/delete/' . $link->id) }}" method="POST">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                            <button class="btn"><span class="glyphicon glyphicon-remove text-red" title="Delete this Link"></span></button>
                        </form>
                    </td>
                    
                </tr>
                @endforeach
                @endforeach
        </tbody>

      </table>

    </div>
    <!-- /.box-body -->
</div>






    

