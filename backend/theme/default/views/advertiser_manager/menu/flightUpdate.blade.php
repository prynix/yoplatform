<div class="sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="#"><i class="fa fa-location-arrow"></i> Quick link<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::Route('FlightAdvertiserManagerShowCreate')}}">New Flight</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('FlightAdvertiserManagerShowList')}}">View Flight</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('FlightAdvertiserManagerShowView', Request::segment(5))}}">View Detail</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
