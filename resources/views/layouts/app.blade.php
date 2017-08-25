<!DOCTYPE html>
<html lang="en">
@section('htmlheader')
    @include('layouts.partials.htmlheader')
    @section('scripts')
        @include('layouts.partials.scripts')
        @stack('scripts')
    @show
@show
<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
    @include('layouts.partials.mainheader')
    @include('layouts.partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper watermark">
        @include('layouts.partials.contentheader')
        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
            @yield('content')
        </section><!-- /.content -->
        @include('layouts.partials.sse_script')
<script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>
$(document).ready(function(){
    
    $("#notifications").load(
                    "{{URL::to("/")}}/notification/get",
                    { "user" : {{auth()->user()->id}} ,
                    }
                );
});
</script>
    </div><!-- /.content-wrapper -->
    @include('layouts.partials.controlsidebar')
    @include('layouts.partials.footer')
</div><!-- ./wrapper -->
</body>
</html>