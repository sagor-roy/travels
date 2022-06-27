<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i
                        class="fa fa-link"></i>
                    <span>Dashboard</span></a></li>
            <li
                class="treeview {{ Route::is('admin.fleet.type.create') || Route::is('admin.fleet.type.index') || Route::is('admin.fleet.vehicles.create') || Route::is('admin.fleet.vehicles.index') || Route::is('admin.fleet.schedule.create') || Route::is('admin.fleet.schedule.index') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-link"></i> <span>Fleet Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li
                        class="treeview {{ Route::is('admin.fleet.type.create') || Route::is('admin.fleet.type.index') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Fleet Type
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Route::is('admin.fleet.type.create') ? 'active' : '' }}"><a
                                    href="{{ route('admin.fleet.type.create') }}"><i class="fa fa-circle-o"></i> Add
                                    Fleet</a></li>
                            <li class="{{ Route::is('admin.fleet.type.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.fleet.type.index') }}"><i class="fa fa-circle-o"></i> Fleet
                                    List</a></li>
                        </ul>
                    </li>
                    <li
                        class="treeview {{ Route::is('admin.fleet.vehicles.create') || Route::is('admin.fleet.vehicles.index') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Vehicles
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Route::is('admin.fleet.vehicles.create') ? 'active' : '' }}"><a
                                    href="{{ route('admin.fleet.vehicles.create') }}"><i class="fa fa-circle-o"></i>
                                    Add
                                    Vehicles</a></li>
                            <li class="{{ Route::is('admin.fleet.vehicles.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.fleet.vehicles.index') }}"><i class="fa fa-circle-o"></i>
                                    Vehicles List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li
                class="treeview {{ Route::is('admin.trip.dest.create') || Route::is('admin.trip.dest.index') || Route::is('admin.trip.route.create') || Route::is('admin.trip.route.index') || Route::is('admin.trip.schedule.create') || Route::is('admin.trip.schedule.index') || Route::is('admin.trip.create') || Route::is('admin.trip.index') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-link"></i> <span>Trip Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li
                        class="treeview {{ Route::is('admin.trip.dest.create') || Route::is('admin.trip.dest.index') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Destination
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Route::is('admin.trip.dest.create') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.dest.create') }}"><i class="fa fa-circle-o"></i> Add
                                    Destination</a></li>
                            <li class="{{ Route::is('admin.trip.dest.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.dest.index') }}"><i class="fa fa-circle-o"></i>
                                    Destination List</a></li>
                        </ul>
                    </li>
                    <li
                        class="treeview {{ Route::is('admin.trip.route.create') || Route::is('admin.trip.route.index') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Route
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Route::is('admin.trip.route.create') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.route.create') }}"><i class="fa fa-circle-o"></i> Add
                                    Route</a></li>
                            <li class="{{ Route::is('admin.trip.route.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.route.index') }}"><i class="fa fa-circle-o"></i> Route
                                    List</a></li>
                        </ul>
                    </li>
                    <li
                        class="treeview {{ Route::is('admin.trip.schedule.create') || Route::is('admin.trip.schedule.index') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Schedules
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Route::is('admin.trip.schedule.create') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.schedule.create') }}"><i class="fa fa-circle-o"></i>
                                    Add Schedule</a></li>
                            <li class="{{ Route::is('admin.trip.schedule.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.schedule.index') }}"><i class="fa fa-circle-o"></i>
                                    Schedule List</a></li>
                        </ul>
                    </li>
                    <li
                        class="treeview {{ Route::is('admin.trip.create') || Route::is('admin.trip.index') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Trip
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Route::is('admin.trip.create') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.create') }}"><i class="fa fa-circle-o"></i> Add
                                    Trip</a></li>
                            <li class="{{ Route::is('admin.trip.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.trip.index') }}"><i class="fa fa-circle-o"></i> Trip
                                    List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
