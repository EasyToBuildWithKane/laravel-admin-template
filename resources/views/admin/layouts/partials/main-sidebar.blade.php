<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <a href="#">ERP Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">EA</a>
        </div>

        {{-- Menu --}}
        <ul class="sidebar-menu">
            {{-- Dashboard --}}
            <li class="menu-header">Dashboard & Reports</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Overview</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.dashboard') }}">Summary</a></li>
                    <li><a class="nav-link" href="#">Analytics</a></li>
                </ul>
            </li>

            {{-- Sales --}}
            <li class="menu-header">Sales Management</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">New Orders</a></li>
                    <li><a class="nav-link" href="#">Order History</a></li>
                </ul>
            </li>

            {{-- Inventory --}}
            <li class="menu-header">Inventory</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-boxes"></i>
                    <span>Products</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">All Products</a></li>
                    <li><a class="nav-link" href="#">Stock Levels</a></li>
                </ul>
            </li>

            {{-- Customers --}}
            <li class="menu-header">Customers</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-users"></i>
                    <span>Customer Management</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">All Customers</a></li>
                    <li><a class="nav-link" href="#">Loyalty Program</a></li>
                </ul>
            </li>

            {{-- Finance --}}
            <li class="menu-header">Finance</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Invoices</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Pending</a></li>
                    <li><a class="nav-link" href="#">Paid</a></li>
                </ul>
            </li>
        </ul>

        {{-- Logout Button --}}
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('admin.logouts') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Logout
            </a>
        </div>
    </aside>
</div>
