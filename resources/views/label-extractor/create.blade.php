@extends('layouts.app')

@section('contentheader_title')
    Settings
@endsection

@section('content')
<div class="box box-primary">
    <div class="container">
        <div class="box-header">
            <h1>Create New LabelExtractor</h1>
            <hr/>
        </div>
        <div class="box-body">

            {!! Form::open(['url' => 'label-extractor', 'class' => 'form-horizontal']) !!}

                        <div class="form-group {{ $errors->has('property') ? 'has-error' : ''}}">
                {!! Form::label('property', 'Property', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('property', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('property', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('priority') ? 'has-error' : ''}}">
                {!! Form::label('priority', 'Priority', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('priority', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('priority', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('enabled') ? 'has-error' : ''}}">
                {!! Form::label('enabled', 'Enabled', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                                <div class="checkbox">
                <label>{!! Form::radio('enabled', '1') !!} Yes</label>
            </div>
            <div class="checkbox">
                <label>{!! Form::radio('enabled', '0', true) !!} No</label>
            </div>
                    {!! $errors->first('enabled', '<p class="help-block">:message</p>') !!}
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