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