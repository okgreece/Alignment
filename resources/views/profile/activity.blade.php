<div class="col-md-9">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Activity</a></li>
       {{-- <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="true">Timeline</a></li> 
            <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li> --}}
        </ul>
        <div class="tab-content">
            @include('profile.posts')

           {{-- @include('profile.timeline') --}}

           {{-- @include('profile.settings') --}}
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
</div>
<!-- /.col -->