<button onclick="" class="btn btn-success" title="Show this Setting"><span class="glyphicon glyphicon-eye-open"></span></button>
<button onclick="" class="btn btn-primary" title="Edit this Setting"><span class="glyphicon glyphicon-pencil"></span></button>
<button onclick="" class="btn btn-warning" title="Copy this Setting"><span class="ion-ios-copy"></span></button>
<button onclick="" class="btn btn-default" title="Export this Setting"><span class="glyphicon glyphicon-download-alt"></span></button>
<button data="{{$setting->id}}" data-toggle="modal" data-target="#validation-dialog" class="btn btn-default error-log-button" title="Show Validation Errors"><span class="glyphicon glyphicon-exclamation-sign"></span></button>
<button onclick="delete_setting('{{$setting->id}}')" class="btn btn-danger" title="Delete this Setting"><span class="glyphicon glyphicon-remove"></span></button>