@extends('layouts.app')

@section('htmlheader_title')
	My Links
@endsection

@section('contentheader_title')
	My Links
@endsection


@section('main-content')
    @if(session()->has('notification'))
        @include('utility.info.successnotification')        
    @elseif(session()->has('error'))
        @include('utility.info.failnotification')        
    @endif

    @include('links.export_modal')
    @include('links.import_modal', ["select" => $select])
    @include('links.full_link_table')
@endsection
        
