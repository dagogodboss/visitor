<div class="col-md-3">
    @foreach($laravelAdminMenus->menus as $section)
    @if($section->items)
    <div class="card">
        <div class="card-header">
            {{ $section->section }}
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-xs-6 my-4 p-1" id="controllers">
                    <ul class="nav flex-column p-2" role="tablist">
                        <li class="menu-head">
                            <span class="name">home</span>
                        </li>
                        @if(auth()->user()->id == 1)
                            <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}"  role="presentation"><a  class="nav-link" href="{{ url('/admin') }}">Dashboard </a></li>
                        @else
                            <li class="nav-item {{ request()->is('employees') ? 'active' : '' }}"  role="presentation"><a  class="nav-link" href="{{ url('/employees') }}">Dashboard </a></li>
                        @endif
                        <li class="menu-head">
                            <span class="name">Peoples</span>
                        </li>
                        @if(auth()->user()->id == 1)
                        <li class="nav-item {{ request()->is('admin/profile') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ route('admin.profile') }}">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('admin/users') ? 'active' : '' }} {{ request()->is('admin/users/*') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ url('admin/users') }}">
                                Users
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('admin/employees') || request()->is('admin/employees/*') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ url('admin/employees') }}">
                                Employees
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('admin/visitors') || request()->is('admin/visitors/*') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ url('admin/visitors') }}">
                                Visitors
                            </a>
                        </li>
                        @else
                            <li class="nav-item {{ request()->is('employees/profile') ? 'active' : '' }}" role="presentation">
                                <a class="nav-link" href="{{ route('employees.profile') }}">
                                    Profile
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('employees/attendance') ? 'active' : '' }}" role="presentation">
                                <a class="nav-link" href="{{ route('employees.attendance') }}">
                                    Attendance
                                </a>
                            </li>
                        @endif
                        <li class="menu-head">
                            <span class="name">Register</span>
                        </li>
                        @if(auth()->user()->id == 1)
                        <li class="nav-item {{ request()->is('admin/pre_register') || request()->is('admin/pre_register/*') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ url('admin/pre_register') }}">
                                Pre-Register
                            </a>
                        </li>
                        @else
                        <li class="nav-item {{ request()->is('employees/pre-register') || request()->is('employees/pre-register/*') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ route('employees.pre-register') }}">
                                Pre-Register
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->id == 1)
                        <li class="menu-head">
                            <span class="name">Administration</span>
                        </li>
                        <li class="nav-item {{ request()->is('admin/settings') || request()->is('admin/settings/*') ? 'active' : '' }}" role="presentation">
                            <a class="nav-link" href="{{ url('admin/settings') }}">
                                Settings
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <br/>
    @endif
    @endforeach
</div>