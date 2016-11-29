
@extends('layouts.app')

@section('htmlheader_title')
	Create Links
@endsection

@section('contentheader_title')
	Create Links
@endsection

@section('contentheader_description')
	Choose Source and Target Graph and create your links
@endsection


@section('main-content')
        @include('links.export_modal')
        @include('createlinks.d3_and_style')
        @if(session()->has('notification'))
             @include('utility.info.successnotification')        
        @elseif(session()->has('error'))
            @include('utility.info.failnotification')        
        @endif
	@include('createlinks.infobox')
        @include('createlinks.linking')
@endsection
