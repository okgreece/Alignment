@extends('voteApp.partials.layout')

@section('content')
    @include('voteApp.partials.projects', ["projects" => $projects])            
@endsection