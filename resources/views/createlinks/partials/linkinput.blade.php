@foreach($instances as $instance)
    <input type="radio" name="link_type" value="{{$instance->value}}" />{{$instance->inner}} <br/>
@endforeach