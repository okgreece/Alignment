
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
				<div class="panel panel-default">
					<div class="panel-heading">Links to Vote</div>

					<div class="panel-body">
						@include('votes.wrapper')
					</div>
				</div>
			</div>
		</div>
	</div>
@include('votes.comment-modal')
@endsection

