<div class="sidebar" id="admin-sidebar">
    <div class="sidebar-header">
        <img src={{ asset('/assets/bwlogo.png') }} alt="Fuwa Fuwa" class="logo" />
    </div>

    <div class="menu">
        <a href="{{ url('/') }}" class="menu-link  {{ request()->is('/') ? 'active' : '' }}" data-target="dashboard">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="{{ route('asset.index') }}" class="menu-link {{ request()->is('asset*') ? 'active' : '' }}"
            data-target="assets">
            <i class="fa-solid fa-boxes-stacked"></i> Assets
        </a>

        @if (Auth::user()->user_type === 'admin')
            <a href="{{ url('/user-management') }}"
                class="menu-link {{ request()->is('user-management*') ? 'active' : '' }}" data-target="users">
                <i class="fa-solid fa-users"></i> User Management
            </a>
        @endif

        @if (Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'encoder')
            <a href="{{ url('/maintenance-repair') }}"
                class="menu-link {{ request()->is('maintenance-repair*') ? 'active' : '' }}" data-target="maintenance">
                <i class="fa-solid fa-screwdriver-wrench"></i> Maintenance & Repair
            </a>
        @endif

        <a href="{{ url('/reports-analytics') }}"
            class="menu-link {{ request()->is('reports-analytics*') ? 'active' : '' }}" data-target="reports">
            <i class="fa-solid fa-chart-column"></i> Reports & Analytics
        </a>

        @if (Auth::user()->user_type === 'admin')
            <a href="{{ url('/system-configuration') }}"
                class="menu-link {{ request()->is('system-configuration*') ? 'active' : '' }}" data-target="settings">
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
                <small style="text-transform: capitalize">{{ Auth::user()->user_type }}</small>
            </div>
        </div>
        <i class="fa-solid fa-right-from-bracket logout-btn" id="logoutBtn" data-logout="{{ route('logout') }}"></i>
        {{-- <button id="logoutBtn" data-logout="{{ route('logout') }}">Logout</button> --}}
    </div>
</div>
