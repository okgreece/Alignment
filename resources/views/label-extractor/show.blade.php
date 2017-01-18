@extends('layouts.app')

@section('contentheader_title')
    Settings
@endsection

@section('content')
<div class="container box">

    <h1>LabelExtractor {{ $labelextractor->id }}
        <a href="{{ url('label-extractor/' . $labelextractor->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit LabelExtractor"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['RDFBrowser/labelextractor', $labelextractor->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete LabelExtractor',
                    'onclick'=>'return confirm("Confirm delete?")'
            ));!!}
        {!! Form::close() !!}
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID</th><td>{{ $labelextractor->id }}</td>
                </tr>
                <tr><th> Property </th><td> {{ $labelextractor->property }} </td></tr><tr><th> Priority </th><td> {{ $labelextractor->priority }} </td></tr><tr><th> Enabled </th><td> {{ $labelextractor->enabled }} </td></tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
