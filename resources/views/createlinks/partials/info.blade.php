
    <div class="box-header with-border">
        <h3 class="box-title">
            @if(isset($header))
                {!! $header !!}
            @else 
                No Selected Entity
            @endif
        </h3>
        <div class="box-tools pull-right" >
            <button type="button" title="Click for more details" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="details_{{$dump}}" class="infobox">
            
            @if(isset($details)) 
                {!! $details !!}
            @else 
                <i>(click on an element to provide more info)</i>
            @endif
        </div>
    </div>
    <!-- /.box-body -->
