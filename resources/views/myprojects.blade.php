
@extends('layouts.app')

@section('htmlheader_title')
	Projects
@endsection

@section('contentheader_title')
	Projects
@endsection

@section('main-content')   

    @if(session()->has('notification'))
        @include('utility.info.successnotification')        
    @elseif(session()->has('error'))
        @include('utility.info.failnotification')        
    @endif
    
    @include('projects.projecttable')
        
@endsection
