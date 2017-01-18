@extends('layouts.app')

@section('content')
<div class="box box-primary">
    <div class="container">
        <div class="box-header">
            <h1>Edit RDF Namespace {{ $rdfnamespace->id }}</h1>
        </div>
        <div class="box-body">
            {!! Form::model($rdfnamespace, [
                'method' => 'PATCH',
                'url' => ['/RDFBrowser/rdfnamespace', $rdfnamespace->id],
                'class' => 'form-horizontal'
            ]) !!}

                        <div class="form-group {{ $errors->has('prefix') ? 'has-error' : ''}}">
                {!! Form::label('prefix', 'Prefix', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('prefix', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('prefix', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('uri') ? 'has-error' : ''}}">
                {!! Form::label('uri', 'Uri', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('uri', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('uri', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('added') ? 'has-error' : ''}}">
                {!! Form::label('added', 'Added', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                                <div class="checkbox">
                <label>{!! Form::radio('added', '1') !!} Yes</label>
            </div>
            <div class="checkbox">
                <label>{!! Form::radio('added', '0', true) !!} No</label>
            </div>
                    {!! $errors->first('added', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                <center>
                    <button type ="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Cancel</button>
                    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                </center>
            </div>
            {!! Form::close() !!}

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
@include('modals.closeEdit')