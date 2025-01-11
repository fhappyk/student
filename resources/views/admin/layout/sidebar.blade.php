
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.invite.student') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Invite Students</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.create.student') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Create Students</span></a>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Students</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.student') }}">All Students</a>
                        <a class="collapse-item" href="{{ route('admin.pending.student') }}">Pending Students</a>
                        <a class="collapse-item" href="{{ route('admin.active.student') }}">Active Students</a>
                        <a class="collapse-item" href="{{ route('admin.inactive.student') }}">InActive Students</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.trashed') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Trashed Students</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.field.setting') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Fields Settings</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
                   aria-expanded="true" aria-controls="collapseSettings">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <div id="collapseSettings" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.setting.email') }}">SMTP Configs</a>
                        <a class="collapse-item" href="{{ route('admin.setting.twilio') }}">Twilio Configs</a>
                        <a class="collapse-item" href="{{ route('admin.setting.email-templates') }}">Email Templates</a>
{{--                        <a class="collapse-item" href="{{ route('admin.inactive.student') }}">SMS Templates</a>--}}
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dropdown.setting') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Speciality Data</span></a>
            </li>


            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.setting') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Settings</span></a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->
