<div class="sidebar" id="admin-sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('/assets/bwlogo.png') }}" alt="Fuwa Fuwa" class="logo" />
    </div>

    <div class="menu">

        <a href="{{ route('dashboard.index') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>

        <a href="{{ route('assets.index') }}" class="menu-link {{ request()->routeIs('assets.*') ? 'active' : '' }}">
            <i class="fa-solid fa-boxes-stacked"></i> Assets
        </a>

        @if (Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'encoder')
            <a href="{{ route('asset-request.index') }}"
                class="menu-link {{ request()->routeIs('asset-request.*') ? 'active' : '' }}">
                <i class="fa-solid fa-dolly"></i> Asset Request
            </a>
        @endif

        @if (Auth::user()->user_type === 'admin')
            <a href="{{ route('user-management.index') }}"
                class="menu-link {{ request()->routeIs('user-management.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> User Management
            </a>
        @endif

        @if (Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'encoder')
            <a href="{{ route('maintenance-repair.index') }}"
                class="menu-link {{ request()->routeIs('maintenance-repair.*') ? 'active' : '' }}">
                <i class="fa-solid fa-screwdriver-wrench"></i> Maintenance & Repair
            </a>
        @endif

        <a href="{{ route('reports-analytics.index') }}"
            class="menu-link {{ request()->routeIs('reports-analytics.*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-column"></i> Reports & Analytics
        </a>

        @if (Auth::user()->user_type === 'admin')
            <a href="{{ route('system-configuration.index') }}"
                class="menu-link {{ request()->routeIs('system-configuration.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> System Configuration
            </a>
        @endif

    </div>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <strong>{{ Auth::user()->name }}!</strong><br />
                <small style="text-transform: capitalize">
                    {{ Auth::user()->user_type }}
                </small>
            </div>
        </div>

        <i class="fa-solid fa-right-from-bracket logout-btn" id="logoutBtn" data-logout="{{ route('logout') }}">
        </i>
    </div>
</div>
