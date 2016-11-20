
@extends('layouts.app')

@section('htmlheader_title')
	Dashboard
@endsection

@section('contentheader_title')
	Dashboard
@endsection

@section('contentheader_description')
	Here you will Find your Dashboard
@endsection


@section('main-content')
	<div class="container spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Info</div>

					<div class="panel-body">
						You are logged in!
    					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
