<tr>
    <td></td>
    <td>{{ $link->project->name }}</td>
    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($source_entity)}}">{{ $source_entity }}</td>
    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($link_type)}}">{{ $link_type }}</td>
    <td data-toggle="tooltip" data-placement="auto" data-container="body" data-animations="true" title="{{EasyRDF_Namespace::expand($target_entity)}}">{{ $target_entity }}</td>
    <td class="text-center">
        <form action="{{ url('createlinks/utility/delete/' . $link->id) }}" method="POST">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <button class="btn" title="Delete this Link"><span class="glyphicon glyphicon-remove text-red"></span></button>
        </form>
    </td>
</tr>