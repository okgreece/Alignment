<!DOCTYPE html>
<html lang="en">
@include('voteApp.partials.htmlheader')
<body data-spy="scroll" data-offset="0" data-target="#navigation">
<!-- Fixed navbar -->
@include('voteApp.partials.contentheader')
<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row centered" id="voting_area">
            @yield('content')
        </div>
    </div> <!--/ .container -->
</div><!--/ #headerwrap -->
@include('voteApp.partials.footer')
@include('voteApp.partials.scripts')
@include('votes.comment-modal')
</body>
</html>