
@extends('layouts.app')

@section('htmlheader_title')
	My Ontologies
@endsection

@section('contentheader_title')
	My Ontologies
@endsection

@section('contentheader_description')
	Ontology Management
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