
@extends('layouts.app')

@section('htmlheader_title')
	My Projects
@endsection

@section('contentheader_title')
	My Projects
@endsection

@section('main-content')   

    @if(session()->has('notification'))
        @include('utility.info.successnotification')        
    @elseif(session()->has('error'))
        @include('utility.info.failnotification')        
    @endif
    
	
    @include('projects.createform')
    
    @include('projects.projecttable')
        
@endsection
