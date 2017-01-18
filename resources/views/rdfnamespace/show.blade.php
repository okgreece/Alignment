@extends('layouts.app')

@section('content')
<div class="container box">

    <h1>RDF Namespace {{ $rdfnamespace->id }}
        <a href="{{ url('RDFBrowser/rdfnamespace/' . $rdfnamespace->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit rdfnamespace"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['RDFBrowser/rdfnamespace', $rdfnamespace->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete rdfnamespace',
                    'onclick'=>'return confirm("Confirm delete?")'
            ));!!}
        {!! Form::close() !!}
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                
                <tr><th> Prefix </th><td> {{ $rdfnamespace->prefix }} </td></tr><tr><th> IRI </th><td> {{ $rdfnamespace->uri }} </td></tr><tr><th> Added </th><td> {{ $rdfnamespace->added }} </td></tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
