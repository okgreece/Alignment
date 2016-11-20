
@extends('layouts.app')

@section('htmlheader_title')
	My Graphs
@endsection

@section('contentheader_title')
	My graphs
@endsection

@section('contentheader_description')
	Graph Management
@endsection

@section('main-content')   

    @if(session()->has('notification'))
        @include('utility.info.successnotification')        
    @elseif(session()->has('error'))
        @include('utility.info.failnotification')        
    @endif
    
	
    @include('files.uploadform')
    
    @include('files.filetable')
        
@endsection


