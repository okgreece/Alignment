<div class="row">
    <div class="col-md-6 col-md-offset-3">    
        <div class="panel panel-default">
            <div class="panel-heading">Settings</div>
            <div class="panel-body">

                <?= Form::open(['url' => route('settings.create'), 'method' => 'POST']) ?>
                @include('settings.settings_form')
                <div class="form-group">
                    <?= Form::button('submit', ['type' => 'submit', 'class' => 'form-control btn btn-primary']) ?>
                </div>
                <?= Form::close() ?>
            </div>
        </div>

    </div>
</div>