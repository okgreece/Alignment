<script>
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("{{URL::to("/")}}/sse");
    source.onmessage = function(event) {
        var data = JSON.parse(event.data);
        if(data.status == -1){
            
        }
        else{
            $.toaster({ priority : 'success', title : 'Success', message : data.message});
            
            if( data.status == 3 && window.location.pathname == '/myprojects' ){
                var selector = 'form[action="' + '{{URL::to("/")}}' + '/createlinks/' + data.project_id +'"]';
                var myButton = $( selector )[0][1];
                myButton.className = "btn";
                
            }
            $.ajax({
                method: "POST",
                url: "{{URL::to("/")}}/notification/read",
                
            })
            .done(function( msg ) {
                //$.toaster({ priority : 'success', title : 'Success', message : msg});
                $("#notifications").load(
                    "{{URL::to("/")}}/notification/get",
                    { "user" : msg ,
                    }
                );
            });
            
            
            }
        
    };
} else {
    
}
</script>
