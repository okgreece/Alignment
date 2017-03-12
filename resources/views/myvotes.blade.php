
@extends('layouts.app')

@section('htmlheader_title')
Votes
@endsection

@section('contentheader_title')
Votes
@endsection

@section('contentheader_description')
Here you can find links to vote or review your votes
@endsection


@section('main-content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" onclick="destroy(2)" data-toggle="tab">My votes</a>
                    </li>
                    <li>
                        <a href="#tab_2" onclick="destroy(1)" data-toggle="tab">Vote</a>
                    </li>
                    <li>
                        <a class="btn btn-success" data-toggle="modal" data-target="#export-voted-modal">
                            Export
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div id='tab_1-body' class="panel-body">
                            @include('votes.wrapper')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="panel-body">
                            @include('votes.voter')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</div>
@include('votes.comment-modal')
@include('votes.export-voted-modal')
@endsection