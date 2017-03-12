<tr>
    <?php
    $source_label = \App\RDFTrait::label($source_graph, $link->source_entity)?:EasyRdf_Namespace::shorten($link->source_entity, true);
    $link_type_label = \App\RDFTrait::label($ontologies_graph, $link->link_type)?:EasyRdf_Namespace::shorten($link->link_type, true);
    $target_label = \App\RDFTrait::label($target_graph, $link->target_entity)?:EasyRdf_Namespace::shorten($link->target_entity, true);
    ?>
    <td></td>
    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{$link->source_entity}}">{{ $source_label}}</td>
    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{$link->link_type}}">{{ $link_type_label}}</td>
    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{$link->target_entity}}">{{ $target_label}}</td>
</tr>