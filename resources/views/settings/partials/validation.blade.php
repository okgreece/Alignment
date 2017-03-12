@include('settings.partials.log_header', ["valid" => $valid])
@foreach($errors as $error)
    @include('settings.partials.error', ["error" => $error])
@endforeach