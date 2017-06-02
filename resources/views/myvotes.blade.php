
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
                    
                    <li>
                        <a href="#tab_2" class="active" onclick="destroy(1)" data-toggle="tab">Vote</a>
                    </li>
                    <li>
                        <a class="btn btn-success" data-toggle="modal" data-target="#export-voted-modal">
                            Export
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tab_2">
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
    <div class="row">
        <div id="project-vote">
            <div id='voting_area'>
            </div>    
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            getPosts($(this).attr('href'));
            e.preventDefault();
        });
    });
    function getPosts(page) {
        $.ajax({
            url : page,
            
        }).done(function (data) {
            $("#project-overview").html(data);
            
        }).fail(function () {
            alert('Posts could not be loaded.');
        });
    }
    </script>
@include('votes.comment-modal')
@include('votes.export-voted-modal')
@endsection