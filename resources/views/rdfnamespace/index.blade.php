@extends('layouts.app')

@section('content')
<div class="container box">

    <h1>RDF Namespaces <a href="{{ url('RDFBrowser/rdfnamespace/create') }}" class="btn btn-primary btn-xs" title="Add New rdfnamespace"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th> Prefix </th><th> IRI </th><th> Added </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($rdfnamespace as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $item->prefix }}</td><td>{{ $item->uri }}</td><td>{{ $item->added }}</td>
                    <td>
                        <a href="{{ url('RDFBrowser/rdfnamespace/' . $item->id) }}" class="btn btn-success btn-xs" title="View rdfnamespace"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('RDFBrowser/rdfnamespace/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit rdfnamespace"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['RDFBrowser/rdfnamespace', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete rdfnamespace" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete rdfnamespace',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $rdfnamespace->render() !!} </div>
    </div>

</div>
@endsection
