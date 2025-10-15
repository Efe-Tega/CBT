<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt=""
                    class="avatar-md rounded-circle" />
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ Auth::user()->name }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="index.html" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                @auth('teacher')
                    <li>
                        <a href="{{ route('management.questions') }}" class="waves-effect">
                            <i class="ri-question-line"></i>
                            <span>Questions</span>
                        </a>
                    </li>
                @endauth

                <li>
                    <a href="{{ route('management.classes') }}" class="waves-effect">
                        <i class="mdi mdi-school"></i>
                        <span>Class Management</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('management.subjects') }}" class="waves-effect">
                        <i class="mdi mdi-school"></i>
                        <span>Subject Management</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-line"></i>
                        <span>Student Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('management.performance') }}">Academic Performance</a></li>
                        <li><a href="{{ route('management.enrollment') }}">Student Enrollment</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('management.settings') }}" class="waves-effect">
                        <i class="ri-settings-5-line"></i>
                        <span>Settings</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
