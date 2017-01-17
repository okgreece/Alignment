<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{$user_profile->avatar?:asset('/img/avatar04.png')}}" alt="User profile picture">
        <h3 class="profile-username text-center">{{$user_profile->name}}</h3>
        <div class="text-center">
            Member since: {{$user_profile->created_at}}
        </div>
        
        <div class="text-center">
        @foreach($user_profile->social as $social)
        
            @if($social->provider == 'github')
                {{-- FIXME not working properly for github --}}
                <a href="https://github.com/" title="Show user profile on Github" class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>
            @elseif($social->provider == 'google')
                <a href="https://plus.google.com/{{$social->provider_user_id}}" title="Show user profile on Google+"class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
            @elseif($social->provider == 'facebook')
                <a href="https://facebook.com/{{$social->provider_user_id}}" title="Show user profile on Facebook" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
            @endif
        @endforeach
        </div>
        
        
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Projects created</b> <a class="pull-right">{{sizeOf($user_profile->projects)}}</a>
            </li>
            <li class="list-group-item">
                <b>Projects participating</b> <a class="pull-right">0</a>
            </li>
            <li class="list-group-item">
                <b>Links Created</b> <a class="pull-right">{{sizeOf($user_profile->links)}}</a>
            </li>
            <li class="list-group-item">
                <b>Votes</b> <a class="pull-right">{{sizeOf($user_profile->votes)}}</a>
            </li>
            <li class="list-group-item">
                <b>Upvotes</b> <a class="pull-right">0</a>
            </li>
            <li class="list-group-item">
                <b>Downvotes</b> <a class="pull-right">0</a>
            </li>
            <li class="list-group-item">
                <b>Comments</b> <a class="pull-right">{{sizeOf($user_profile->comments)}}</a>
            </li>
        </ul>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->