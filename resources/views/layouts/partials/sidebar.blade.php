<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    @if(Auth::user()->avatar)
                        <img src="{{Auth::user()->avatar}}" class="img-circle" alt="User Image" />
                    @else
                        changed
                        <img src="{{asset('/img/avatar04.png')}}" class="img-circle" alt="User Image" />
                    @endif                    
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Main Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a  href="{{ route('dashboard')  }}"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
            <li><a  href="{{ route('settings')  }}"><i class='fa fa-wrench'></i> <span>Settings</span></a></li>
            <li><a  href="{{ route('mygraphs')  }}"><i class='fa fa-file-text-o'></i> <span>My Ontologies</span></a></li>
            <li><a  href="{{ route('mylinks')  }}"><i class='fa fa-link'></i><span>My Links</span></a></li>
            <li><a  href="{{ route('myvotes')  }}"><i class='fa fa-thumbs-up'></i><span>My Votes</span></a></li>
            <li><a  href="{{ route('myprojects')  }}"><i class='fa fa-desktop'></i> <span>My Projects</span></a></li>
            <li><a  href="{{ route('about')  }}"><i class='fa fa-info'></i> <span>About</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>