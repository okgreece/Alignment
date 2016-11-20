
@extends('layouts.app')

@section('htmlheader_title')
	About
@endsection

@section('contentheader_title')
	About
@endsection


@section('main-content')
	<div class="container spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-primary">
					<div class="panel-heading">Alignment</div>

					<div class="panel-body">
						Ontology matching is a crucial problem in the world of Semantic Web
                    and other distributed, open world applications. Diversity in tools,
                    knowledge, habits, language, interests and usually level of detail
                    may drive in heterogeneity. Thus, many automated applications have
                    been developed, implementing a large variety of matching techniques
                    and similarity measures, with impressive results. However,
                    there are situations where this is not enough and there must
                    be human decision in order to create a link. In this paper we
                    present Alignment, a collaborative, system aided,
                    user driven ontology matching application. Alignment offers a simple
                    GUI environment for matching two ontologies/vocubularies with aid of configurable
                    similarity algorithms. We undertake research for the evaluation and 
                    validation of the default settings, taking into account expert users feedback.
                    Multiple users can work on the same project simultaneously.
                    The application offers also social features, as users can vote,
                    providing feedback, on the produced linksets. The linksets are available
                    through a SPARQL endpoint and an API. K-Harmony is the outcome of the experience
                    working with heterogeneous public budget data, and has been used to align
                    SKOS Vocabularies describing budget data across diverse level of administrations
                    of the EU and it’s member states.
					</div>
				</div>
			</div>
		</div>
	</div>
 
@endsection
