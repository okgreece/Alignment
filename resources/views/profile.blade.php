
@extends('layouts.app')

@section('htmlheader_title')
User Profile
@endsection

@section('contentheader_title')
User Profile
@endsection

@section('contentheader_description')
Overview of user porofile
@endsection
@section('main-content')
    @include('profile.skeleton')
@endsection
