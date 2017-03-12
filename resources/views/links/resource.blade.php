<a href="{{$resource}}"
   data-toggle="tooltip"
   data-placement="auto"
   data-container="body"
   data-animations="true"
   title="{{$resource}}"
   >
   {{ \App\RDFTrait::label($graph, $resource)?:\EasyRdf_Namespace::shorten($resource, true)}}
</a>