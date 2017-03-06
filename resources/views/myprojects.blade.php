
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
    
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <p>
            Could not create project:
        </p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @include('projects.projecttable')
        
@endsection
