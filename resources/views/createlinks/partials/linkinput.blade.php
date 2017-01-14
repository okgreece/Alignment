@foreach($instances as $instance)
<input type="radio" name="link_type" value="{{$instance->value}}" /><i data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="This option will create a link of type {{ EasyRdf_Namespace::shorten($instance->value)}}" class="fa fa-fw fa-info-circle info-icon"></i> {{$instance->inner}} <br/>
@endforeach