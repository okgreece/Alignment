@extends('layouts.app')

@section('content')
<div class="box box-primary">
    <div class="container">
        <div class="box-header">
            <h1>Create New RDF Namespace</h1>
            <hr/>
        </div>
        <div class="box-body">

            {!! Form::open(['url' => '/RDFBrowser/rdfnamespace', 'class' => 'form-horizontal']) !!}

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
                    {!! Form::submit('Create', ['class' => 'btn btn-success']) !!}
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
@include('modals.closeCreate')