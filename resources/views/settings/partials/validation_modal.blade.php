<!-- Modal -->
<div id="validation-dialog" class="modal" role="dialog">
    <div class="modal-dialog" style="margin:80px auto">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="validation-modal-body" class="modal-body">
                
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
$('#validation-dialog').on('show.bs.modal', function (event) {
    $('#validation-modal-body').html("");
    var id = event.relatedTarget.getAttribute("data");
  $.ajax({
      url: "settings/validation/errors",
      type:"GET",
      data:{id:id}
  }).done(function(data){
      $('#validation-modal-body').html(data);
  });
          
});

</script>