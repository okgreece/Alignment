<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Alignment - A system aided ontology linking platform">
    <meta name="author" content="Sotiris Karampatakis">
    <title>Alignment - OKF GREECE</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('/js/smoothscroll.js') }}"></script>
</head>
<body data-spy="scroll" data-offset="0" data-target="#navigation">
<!-- Fixed navbar -->
<div id="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>Alignment</b></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#home" class="smothscroll">Home</a></li>
                <li><a href="#desc" class="smothscroll">Description</a></li>
                <li><a href="#showcase" class="smothScroll">Showcase</a></li>
                <li><a href="#contact" class="smothScroll">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
<!--                    <li><a href="{{ url('/register') }}">Register</a></li>-->
                @else
                    <li><a href="{{route('dashboard')}}">{{ Auth::user()->name }}</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row centered">
            <div class="col-lg-12">
                <h1>Alignment</h1>
                <h3>A tool to for semi-guided ontology alignment</h3>
                <h3><a href="{{ url('/login') }}" class="btn btn-lg btn-success">Get Started!</a></h3>
            </div>
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/SRjIg3OyZMw?rel=0&amp;controls=0" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
    </div> <!--/ .container -->
</div><!--/ #headerwrap -->
<section id="desc" name="desc"></section>
<div id="intro">
    <div class="container">
        <div class="row centered">
            <h1>Build to Connect</h1>
            <br>
            <br>
            <div class="col-lg-4">
                <img src="{{ asset('/img/intro01.png') }}" alt="">
                <h3>Community</h3>
                <p>See <a href="https://github.com/okfngr/Alignment">Github project</a>, post <a href="https://github.com/okfngr/Alignment/issues">issues</a> and <a href="https://github.com/okgreece/Alignment/pulls">Pull requests</a></p>
            </div>
            <div class="col-lg-4">
                <img src="{{ asset('/img/intro03.png') }}" alt="">
                <h3>Easy configurable</h3>
                <p>Easy configuration through panels.</p>
            </div>
            <div class="col-lg-4">
                <img style="height:128px" src="{{ asset('/img/link.ico') }}" alt="">
                <h3>Silk Framework Integration</h3>
                <p>Silk Linking Framework Integration as it is a Linked Data standard.</p>
            </div>
            
        </div>
        <br>
        <hr>
    </div>  
</div><!--/ #introwrap -->
<section id="showcase" name="showcase"></section>
<div id="showcase">
    <div class="container">
        <div class="row">
            <h1 class="centered">Some Screenshots</h1>
            <br>
            <div class="col-lg-8 col-lg-offset-2">
                <div id="carousel-example-generic" class="carousel slide">
                      
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img style="height:600px" src="{{ asset('/img/gui.png') }}" alt="">
                        </div>
                        <div class="item">
                            <img style="height:600px" src="{{ asset('/img/checked_venn.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div> 
</div>
<section id="contact" name="contact"></section>
<div id="c">
    <div class="container">
        <p>
            <strong>Copyright &copy; 2016 <a href="http://www.okfn.gr">OKF GREECE</a>.</strong> 
        </p>

    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
</body>
</html>