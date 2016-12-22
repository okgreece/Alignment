<?php $notifications_count = count($notifications);?>            

<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell-o"></i>
    @if($notifications_count)
    <span class="label label-danger">{{count($notifications)}}</span>
    @endif
</a>
<ul class="dropdown-menu">
    @if($notifications_count)
    <li class="header">You have {{count($notifications)}} new notifications</li>
    @else
       <li class="header">You don't have new notifications</li>
    @endif
    <li>
        <!-- inner menu: contains the actual data -->
        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
            <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">

                @foreach($notifications as $notification)
                <li>
                    <a href="#">
                        <i class="fa fa-info text-aqua"></i> {{$notification->message}}
                    </a>
                </li>
                @endforeach
            </ul>
            <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;">
                
            </div>
            <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                
            </div>
                
        </div>
    </li>
    <li class="footer"><a href="#">View all</a></li>
</ul>         