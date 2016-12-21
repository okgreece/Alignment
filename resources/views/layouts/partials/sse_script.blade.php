<script>
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("{{env('APP_URL')}}/sse");
    source.onmessage = function(event) {
        var data = JSON.parse(event.data);
        if(data.status == -1){
            
        }
        else{
            $.toaster({ priority : 'success', title : 'Success', message : data.message});
            
            if( data.status == 3 ){
                var selector = 'form[action="' + '{{URL::to("/")}}' + '/createlinks/' + data.project_id +'"]';
                var myButton = $( selector )[0][1];
                myButton.className = "btn";
                
            }
            $.ajax({
                method: "POST",
                url: "{{env('APP_URL')}}/notification/read",
                
            })
            .done(function( msg ) {
                //$.toaster({ priority : 'success', title : 'Success', message : msg});
            });
            }
        
    };
} else {
    
}
</script>
