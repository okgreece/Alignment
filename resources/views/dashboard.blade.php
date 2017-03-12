
@extends('layouts.app')

@section('htmlheader_title')
Dashboard
@endsection

@section('contentheader_title')
Dashboard
@endsection

@section('contentheader_description')

@endsection


@section('main-content')
<div class="container spark-screen">
    
    <div class="row">
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <a href="profile/{{Auth::user()->id}}" class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>Profile</h3>
                    <p>Show user Profile</p>
                    <br>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <span class="small-box-footer">
                    Click for more <i class="fa fa-arrow-circle-right"></i>
                </span>
            </a>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <a href="voteApp" class="small-box bg-green-gradient">
                <div class="inner">
                    <h3>Vote</h3>
                    <p>Go to Vote App</p>
                    <br>
                </div>
                <div class="icon">
                    <i class="fa fa-thumbs-o-up"></i>
                </div>
                <span class="small-box-footer">
                    Click for more <i class="fa fa-arrow-circle-right"></i>
                </span>
            </a>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <a href="mygraphs" class="small-box bg-light-blue-gradient">
                <div class="inner">
                    <h3>Ontologies</h3>
                    <p>Upload or Edit an Ontology</p>
                    <br>
                </div>
                <div class="icon">
                    <i class="fa fa-files-o"></i>
                </div>
                <span class="small-box-footer">
                    Click for more <i class="fa fa-arrow-circle-right"></i>
                </span>
            </a>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <a href="myprojects" class="small-box bg-yellow-gradient">
                <div class="inner">
                    <h3>Projects</h3>
                    <p>Create or edit a Project and start creating Links!</p>
                    <br>
                </div>
                <div class="icon">
                    <i class="fa fa-desktop"></i>
                </div>
                <span class="small-box-footer">
                    Click for more <i class="fa fa-arrow-circle-right"></i>
                </span>
            </a>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <a href="settings" class="small-box bg-purple-gradient">
                <div class="inner">
                    <h3>Comparison Settings</h3>
                    <p>Fine Tune Silk LSL Settings</p>
                    <br>
                </div>
                <div class="icon">
                    <i class="fa fa-wrench"></i>
                </div>
                <span class="small-box-footer">
                     Click for more <i class="fa fa-arrow-circle-right"></i>
                </span>
            </a>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <a href="mylinks" class="small-box bg-maroon-gradient">
                <div class="inner">
                    <h3>My Links</h3>
                    <p>Import, Export, Delete or Review your links</p>
                    <br>
                </div>
                <div class="icon">
                    <i class="fa fa-link"></i>
                </div>
                <span class="small-box-footer">
                 Click for more <i class="fa fa-arrow-circle-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
