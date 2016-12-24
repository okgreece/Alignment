<!DOCTYPE html>
<html lang="en">
@section('htmlheader')
    @include('layouts.partials.htmlheader')
    @section('scripts')
        @include('layouts.partials.scripts')
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
        </section><!-- /.content -->
        
        @include('layouts.partials.sse_script')
<!--<script>
  var host   = 'ws://{{$_SERVER["HTTP_HOST"]}}/socket/';  
  //var host   = 'ws://127.0.0.1:8889';
  var socket = null;
  
  var output = document.getElementById('output');
  var print  = function (message) {
      var samp       = document.createElement('samp');
      samp.innerHTML = message + '\n';
      output.appendChild(samp);

      return;
  };

    try {
      socket = new WebSocket(host);
      socket.onopen = function () {
          //print('connection is opened');
          

          return;
      };
      socket.onmessage = function ( msg ) {
          //print(msg.data);
          console.log( msg );
          var myData = JSON.parse(msg.data);
          console.log(myData.project);
          var selector = 'form[action="' + '{{URL::to("/")}}' + '/createlinks/' + myData.project +'"]';
          
          if( myData.state == "finish" ){
            var myButton = $( selector )[0][1];
            myButton.className = "btn";
            $.toaster({ priority : 'success', title : 'Success', message : myData.message});
          }
          else{
              $.toaster({ priority : 'success', title : 'Success', message : myData.message});
          }
          
          

          return;
      };
      socket.onclose = function () {
          //print('connection is closed');

          return;
      };
  } catch (e) {
      console.log(e);
  }
</script>-->
<script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
     container: '.container',
     trigger: "focus",
     html: true,
    });
    $("#notifications").load(
                    "{{URL::to("/")}}/notification/get",
                    { "user" : {{auth()->user()->id}} ,
                    }
                );
});
</script>
                                                                                                        
    </div><!-- /.content-wrapper -->
    @include('layouts.partials.controlsidebar')
    @include('layouts.partials.footer')
</div><!-- ./wrapper -->
</body>
</html>