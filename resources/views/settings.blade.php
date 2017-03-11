
@extends('layouts.app')

@section('htmlheader_title')
Settings
@endsection

@section('contentheader_title')
Settings
@endsection

@section('contentheader_description')
Configure your settings
@endsection

@section('main-content')

@if(session()->has('notification'))
@include('utility.info.successnotification')        
@elseif(session()->has('error'))
@include('utility.info.failnotification')        
@endif


@include('settings.index')
@include('settings.partials.create_modal')
@include('settings.partials.validation_modal')
@endsection
