<div class="sidebar" id="admin-sidebar">

    <div class="sidebar-header">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="logo">
            <img src="{{ asset('/assets/bwlogo.png') }}" alt="Fuwa Fuwa" class="logo" />
        </div>
    </div>

    <div class="menu">

        {{-- OPERATIONS --}}
        @php
            $showOperations =
                Auth::user()->canAccess('Dashboard', 'read') ||
                Auth::user()->canAccess('Assets', 'read') ||
                Auth::user()->canAccess('Asset Request', 'read') ||
                Auth::user()->canAccess('Maintenance', 'read');
        @endphp

        @if ($showOperations)
            <div class="menu-section">OPERATIONS</div>

            @if (Auth::user()->canAccess('Dashboard', 'read'))
                <a href="{{ route('dashboard.index') }}"
                    class="menu-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                </a>
            @endif

            @if (Auth::user()->canAccess('Assets', 'read'))
                <a href="{{ route('assets.index') }}"
                    class="menu-link {{ request()->routeIs('assets.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i> <span>Assets</span>
                </a>
            @endif

            @if (Auth::user()->canAccess('Asset Request', 'read'))
                <a href="{{ route('asset-request.index') }}"
                    class="menu-link {{ request()->routeIs('asset-request.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-dolly"></i> <span>Asset Request</span>
                </a>
            @endif

            @if (Auth::user()->canAccess('Asset Archive', 'read'))
                <a href="{{ route('assets-archive.index') }}"
                    class="menu-link {{ request()->routeIs('assets-archive.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-trash"></i> <span>Asset Archive</span>
                </a>
            @endif

            @if (Auth::user()->canAccess('Maintenance', 'read'))
                <a href="{{ route('maintenance-repair.index') }}"
                    class="menu-link {{ request()->routeIs('maintenance-repair.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-screwdriver-wrench"></i> <span>Maintenance & Repair</span>
                </a>
            @endif
        @endif

        {{-- ADMINISTRATION --}}
        @php
            $showAdmin = Auth::user()->canAccess('User', 'read') || Auth::user()->canAccess('Vendor', 'read');
        @endphp

        @if ($showAdmin)
            <div class="menu-section">ADMINISTRATION</div>

            @if (Auth::user()->canAccess('User', 'read'))
                <a href="{{ route('user-management.index') }}"
                    class="menu-link {{ request()->routeIs('user-management.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> <span>User Management</span>
                </a>
            @endif

            @if (Auth::user()->canAccess('Vendor', 'read'))
                <a href="{{ route('vendors.index') }}"
                    class="menu-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}" data-target="vendors">
                    <i class="fa-solid fa-shop"></i> <span>Vendor Management</span>
                </a>
            @endif
        @endif

        {{-- INSIGHTS --}}
        @php
            $showInsights = Auth::user()->canAccess('Reports', 'read');
        @endphp

        @if ($showInsights)
            <div class="menu-section">INSIGHTS</div>

            @if (Auth::user()->canAccess('Reports', 'read'))
                <a href="{{ route('reports-analytics.index') }}"
                    class="menu-link {{ request()->routeIs('reports-analytics.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-column"></i> <span>Reports</span>
                </a>
            @endif
        @endif

        {{-- SYSTEM --}}
        @if (Auth::user()->canAccess('System', 'read'))
            <div class="menu-section">SYSTEM</div>

            <a href="{{ route('system-configuration.index') }}"
                class="menu-link {{ request()->routeIs('system-configuration.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> <span>System Configuration</span>
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
{{-- <div class="sidebar-overlay" id="sidebarOverlay"></div> --}}

<script>
    const sidebar = document.getElementById("admin-sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");

    // Function to check if we're on mobile
    function isMobile() {
        return window.innerWidth <= 768; // Adjust breakpoint as needed
    }

    // Set initial state based on screen size
    function setInitialSidebarState() {
        if (isMobile()) {
            // Start collapsed on mobile
            sidebar.classList.add("collapsed");
            sidebar.classList.remove("expanded");
        } else {
            // Start expanded on desktop
            sidebar.classList.add("expanded");
            sidebar.classList.remove("collapsed");
        }
    }

    // Toggle sidebar when button is clicked
    toggleBtn.addEventListener("click", (e) => {
        e.stopPropagation();

        if (sidebar.classList.contains("expanded")) {
            sidebar.classList.remove("expanded");
            sidebar.classList.add("collapsed");
        } else {
            sidebar.classList.remove("collapsed");
            sidebar.classList.add("expanded");
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener("resize", () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            setInitialSidebarState();
        }, 250);
    });

    // Initialize sidebar
    setInitialSidebarState();
</script>
