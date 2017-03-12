<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{trans('theme/admin/modals/edit.header')}}</h4>
      </div>
      <div class="modal-body">
        {{trans('theme/admin/modals/edit.body')}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('theme/admin/modals/edit.back')}}</button>
        <button type="button" onclick="goBack()" class="btn btn-primary">{{trans('theme/admin/modals/edit.quit')}}</button>
      </div>
    </div>
  </div>
</div>
<script>
function goBack() {
    window.history.back();
}
</script>