<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav mr-3">
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="avatar"
                    src="{{ Auth::user()->photo ? asset('uploads/admin_images/' . Auth::user()->photo) : asset('assets/img/avatar/avatar-1.png') }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    Hello, {{ Auth::user()->name ?? 'Guest' }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile.show') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('admin.password.show') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.logouts') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logouts') }}" method="get" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
