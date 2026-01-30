@extends('Layout.app')

@section('content')
    <div id="notifications" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Notifications</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>

                <div class="notif-icon" id="notifToggle">
                    <i class="fa-regular fa-bell notif-bell"></i>
                    <span class="notif-badge">3</span>
                </div>
            </div>
        </div>

        <!-- notification panel -->
        <div class="notif-panel" id="notifPanel">
            <div class="notif-header">
                <span>Notifications</span>
                <small class="text-muted">3 new</small>
            </div>

            <div class="notif-list">
                <div class="notif-item unread">
                    <i class="fa-solid fa-circle-info"></i>
                    <div>
                        <p>New asset request submitted</p>
                        <small>2 minutes ago</small>
                    </div>
                </div>

                <div class="notif-item unread">
                    <i class="fa-solid fa-check"></i>
                    <div>
                        <p>Request approved</p>
                        <small>10 minutes ago</small>
                    </div>
                </div>

                <div class="notif-item">
                    <i class="fa-solid fa-box"></i>
                    <div>
                        <p>Inventory updated</p>
                        <small>Yesterday</small>
                    </div>
                </div>
            </div>

            <div class="notif-footer">
                <a href="#">View all notifications</a>
            </div>
        </div>

        <!-- notifications -->
        <div class="notif-container my-4">
            <!-- filters -->
            <div class="controls">
                <div class="d-flex gap-2">
                    <span class="filter-pill active">All</span>
                    <span class="filter-pill">Read</span>
                    <span class="filter-pill">Unread</span>
                </div>

                <div class="filters">
                    <select class="form-select form-select-sm w-auto shadow-none" id="timeRangeFilter">
                        <option value="today">Today</option>
                        <option value="7days">Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
                    </select>

                    <select class="form-select form-select-sm w-auto shadow-none" id="notificationType">
                        <option value="Notification type">Notification Type</option>
                        <option value="Asset notifs">Asset</option>
                        <option value="Asset req notifs">Asset Request</option>
                        <option value="Maintenance notifs">Maintenance</option>
                        <option value="User notif">Users</option>
                        <option value="Vendor notif">Vendors</option>
                    </select>
                </div>
            </div>

            <div class="notifs mt-3">
                <!-- notif 1 -->
                <div class="notif-row unread" role="button" tabindex="0">
                    <div class="notif-left">
                        <div class="notif-box">
                            <i class="fa-solid fa-coins"></i>
                        </div>

                        <div class="notif-text">
                            <div class="notif-title">New User Added</div>
                            <div class="notif-desc">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Laborum voluptate architecto aut non esse excepturi
                                deserunt voluptates nobis, fugit incidunt velit.
                                Laboriosam, dolorem tempore reprehenderit quo inventore
                                aut eveniet repudiandae.
                            </div>
                        </div>
                    </div>

                    <div class="notif-right">
                        <span class="notif-time">24m ago</span>
                        <span class="notif-dot"></span>
                    </div>
                </div>

                <!-- notif 2 -->
                <div class="notif-row read" role="button" tabindex="0">
                    <div class="notif-left">
                        <div class="notif-box">
                            <i class="fa-solid fa-coins"></i>
                        </div>

                        <div class="notif-text">
                            <div class="notif-title">New User Added</div>
                            <div class="notif-desc">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Laborum voluptate architecto aut non esse excepturi
                                deserunt voluptates nobis, fugit incidunt velit.
                                Laboriosam, dolorem tempore reprehenderit quo inventore
                                aut eveniet repudiandae.
                            </div>
                        </div>
                    </div>

                    <div class="notif-right">
                        <span class="notif-time">24m ago</span>
                        <span class="notif-dot"></span>
                    </div>
                </div>

                <!-- notif 3 -->
                <div class="notif-row read" role="button" tabindex="0">
                    <div class="notif-left">
                        <div class="notif-box">
                            <i class="fa-solid fa-coins"></i>
                        </div>

                        <div class="notif-text">
                            <div class="notif-title">New User Added</div>
                            <div class="notif-desc">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Laborum voluptate architecto aut non esse excepturi
                                deserunt voluptates nobis, fugit incidunt velit.
                                Laboriosam, dolorem tempore reprehenderit quo inventore
                                aut eveniet repudiandae.
                            </div>
                        </div>
                    </div>

                    <div class="notif-right">
                        <span class="notif-time">24m ago</span>
                        <span class="notif-dot"></span>
                    </div>
                </div>

                <!-- notif 4 -->
                <div class="notif-row read" role="button" tabindex="0">
                    <div class="notif-left">
                        <div class="notif-box">
                            <i class="fa-solid fa-coins"></i>
                        </div>

                        <div class="notif-text">
                            <div class="notif-title">New User Added</div>
                            <div class="notif-desc">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Laborum voluptate architecto aut non esse excepturi
                                deserunt voluptates nobis, fugit incidunt velit.
                                Laboriosam, dolorem tempore reprehenderit quo inventore
                                aut eveniet repudiandae.
                            </div>
                        </div>
                    </div>

                    <div class="notif-right">
                        <span class="notif-time">24m ago</span>
                        <span class="notif-dot"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
