@php
$user = Auth::user();
@endphp
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
            @if ($user->can('booking.view') || $user->can('booking.create') || $user->can('booking.delete'))
                <li
                    class="treeview {{ Route::is('admin.ticket.booking.index') || Route::is('admin.ticket.booking.create') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-link"></i> <span>Ticket Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if ($user->can('booking.view') || $user->can('booking.create'))
                            <li
                                class="treeview {{ Route::is('admin.ticket.booking.index') || Route::is('admin.ticket.booking.create') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Booking Information
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('booking.create'))
                                        <li class="{{ Route::is('admin.ticket.booking.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.ticket.booking.create') }}"><i
                                                    class="fa fa-circle-o"></i> Add
                                                Booking</a></li>
                                    @endif
                                    @if ($user->can('booking.view'))
                                        <li class="{{ Route::is('admin.ticket.booking.index') ? 'active' : '' }}">
                                            <a href="{{ route('admin.ticket.booking.index') }}"><i
                                                    class="fa fa-circle-o"></i> Booking
                                                List</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        <li class="treeview">
                            <a href="#"><i class="fa fa-circle-o"></i> Passenger
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class=""><a href=""><i class="fa fa-circle-o"></i>
                                        Add
                                        Passenger</a></li>
                                <li class=""><a href=""><i class="fa fa-circle-o"></i>
                                        Passenger List</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif

            @if ($user->can('fleet.view') || $user->can('fleet.create') || $user->can('fleet.edit') || $user->can('fleet.delete') || $user->can('vehicle.view') || $user->can('vehicle.create') || $user->can('vehicle.edit') || $user->can('vehicle.delete'))
                <li
                    class="treeview {{ Route::is('admin.fleet.type.create') || Route::is('admin.fleet.type.index') || Route::is('admin.fleet.vehicles.create') || Route::is('admin.fleet.vehicles.index') || Route::is('admin.fleet.schedule.create') || Route::is('admin.fleet.schedule.index') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-link"></i> <span>Fleet Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if ($user->can('fleet.view') || $user->can('fleet.create') || $user->can('fleet.edit') || $user->can('fleet.delete'))
                            <li
                                class="treeview {{ Route::is('admin.fleet.type.create') || Route::is('admin.fleet.type.index') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Fleet Type
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('fleet.create'))
                                        <li class="{{ Route::is('admin.fleet.type.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.fleet.type.create') }}"><i
                                                    class="fa fa-circle-o"></i> Add
                                                Fleet</a></li>
                                    @endif
                                    @if ($user->can('fleet.view'))
                                        <li class="{{ Route::is('admin.fleet.type.index') ? 'active' : '' }}"><a
                                                href="{{ route('admin.fleet.type.index') }}"><i
                                                    class="fa fa-circle-o"></i> Fleet
                                                List</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if ($user->can('vehicle.view') || $user->can('vehicle.create') || $user->can('vehicle.edit') || $user->can('vehicle.delete'))
                            <li
                                class="treeview {{ Route::is('admin.fleet.vehicles.create') || Route::is('admin.fleet.vehicles.index') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Vehicles
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('vehicle.create'))
                                        <li class="{{ Route::is('admin.fleet.vehicles.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.fleet.vehicles.create') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Add
                                                Vehicles</a></li>
                                    @endif
                                    @if ($user->can('vehicle.view'))
                                        <li class="{{ Route::is('admin.fleet.vehicles.index') ? 'active' : '' }}"><a
                                                href="{{ route('admin.fleet.vehicles.index') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Vehicles List</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if ($user->can('desti.view') || $user->can('desti.create') || $user->can('desti.edit') || $user->can('desti.delete') || $user->can('route.view') || $user->can('route.create') || $user->can('route.edit') || $user->can('route.delete') || $user->can('schedule.view') || $user->can('schedule.create') || $user->can('schedule.edit') || $user->can('schedule.delete') || $user->can('trip.view') || $user->can('trip.create') || $user->can('trip.edit') || $user->can('trip.delete'))
                <li
                    class="treeview {{ Route::is('admin.trip.dest.create') || Route::is('admin.trip.dest.index') || Route::is('admin.trip.route.create') || Route::is('admin.trip.route.index') || Route::is('admin.trip.schedule.create') || Route::is('admin.trip.schedule.index') || Route::is('admin.trip.create') || Route::is('admin.trip.index') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-link"></i> <span>Trip Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if ($user->can('desti.view') || $user->can('desti.create') || $user->can('desti.edit') || $user->can('desti.delete'))
                            <li
                                class="treeview {{ Route::is('admin.trip.dest.create') || Route::is('admin.trip.dest.index') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Destination
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('desti.create'))
                                        <li class="{{ Route::is('admin.trip.dest.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.dest.create') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Add
                                                Destination</a></li>
                                    @endif
                                    @if ($user->can('desti.view'))
                                        <li class="{{ Route::is('admin.trip.dest.index') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.dest.index') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Destination List</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if ($user->can('route.view') || $user->can('route.create') || $user->can('route.edit') || $user->can('route.delete'))
                            <li
                                class="treeview {{ Route::is('admin.trip.route.create') || Route::is('admin.trip.route.index') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Route
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('route.create'))
                                        <li class="{{ Route::is('admin.trip.route.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.route.create') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Add
                                                Route</a></li>
                                    @endif
                                    @if ($user->can('route.view'))
                                        <li class="{{ Route::is('admin.trip.route.index') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.route.index') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Route
                                                List</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if ($user->can('schedule.view') || $user->can('schedule.create') || $user->can('schedule.edit') || $user->can('schedule.delete'))
                            <li
                                class="treeview {{ Route::is('admin.trip.schedule.create') || Route::is('admin.trip.schedule.index') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Schedules
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('schedule.create'))
                                        <li class="{{ Route::is('admin.trip.schedule.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.schedule.create') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Add Schedule</a></li>
                                    @endif
                                    @if ($user->can('schedule.view'))
                                        <li class="{{ Route::is('admin.trip.schedule.index') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.schedule.index') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Schedule List</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if ($user->can('trip.view') || $user->can('trip.create') || $user->can('trip.edit') || $user->can('trip.delete'))
                            <li
                                class="treeview {{ Route::is('admin.trip.create') || Route::is('admin.trip.index') ? 'active' : '' }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Trip
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if ($user->can('trip.create'))
                                        <li class="{{ Route::is('admin.trip.create') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.create') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Add
                                                Trip</a></li>
                                    @endif
                                    @if ($user->can('trip.view'))
                                        <li class="{{ Route::is('admin.trip.index') ? 'active' : '' }}"><a
                                                href="{{ route('admin.trip.index') }}"><i
                                                    class="fa fa-circle-o"></i>
                                                Trip
                                                List</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if ($user->can('user.view') || $user->can('user.create') || $user->can('user.edit') || $user->can('user.delete') || $user->can('role.view') || $user->can('role.create') || $user->can('role.edit') || $user->can('role.delete'))
                <li
                    class="treeview {{ Route::is('admin.role.all.create') || Route::is('admin.role.all.index') || Route::is('admin.role.create.create') || Route::is('admin.role.create.index') || Route::is('admin.role.all.edit') || Route::is('admin.role.create.edit') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-link"></i> <span>Role Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if ($user->can('user.view'))
                            <li
                                class="{{ Route::is('admin.role.all.index') || Route::is('admin.role.all.create') || Route::is('admin.role.all.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.role.all.index') }}"><i class="fa fa-circle-o"></i> All
                                    Roles</a>
                            </li>
                        @endif
                        @if ($user->can('role.view'))
                            <li
                                class="{{ Route::is('admin.role.create.create') || Route::is('admin.role.create.index') || Route::is('admin.role.create.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.role.create.index') }}"><i class="fa fa-circle-o"></i>
                                    Create
                                    Roles</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
