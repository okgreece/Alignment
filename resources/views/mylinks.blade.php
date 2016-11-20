@extends('layouts.app')

@section('htmlheader_title')
	My Links
@endsection

@section('contentheader_title')
	My Links
@endsection


@section('main-content')
    @include('links.export_modal')
    @include('links.full_link_table')
@endsection
        
