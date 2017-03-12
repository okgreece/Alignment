@extends('layouts.app')

@section('contentheader_title')
    Settings
@endsection

@section('content')
<div class="container box">

    <h1>Label Extractor <a href="{{ url('label-extractor/create') }}" class="btn btn-primary btn-xs" title="Add New LabelExtractor"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> Property </th><th> Priority </th><th> Enabled </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($labelextractor as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->property }}</td><td>{{ $item->priority }}</td><td>{{ $item->enabled }}</td>
                    <td>
                        <a href="{{ url('label-extractor/' . $item->id) }}" class="btn btn-success btn-xs" title="View LabelExtractor"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('label-extractor/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit LabelExtractor"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['label-extractor', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete LabelExtractor" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete LabelExtractor',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $labelextractor->render() !!} </div>
    </div>

</div>
@endsection
