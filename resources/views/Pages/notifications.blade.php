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

                <x-notification-dropdown />
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
                        <option value="Assets">Asset</option>
                        <option value="Asset Request">Asset Request</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="User">Users</option>
                        <option value="Vendor">Vendors</option>
                        <option value="Reports">Reports</option>
                        <option value="System">System</option>
                    </select>
                </div>
            </div>

            <div class="notifs mt-3">
                <!-- notif 1 -->
                @foreach ($items as $item)
                    <a class="notif-row {{ is_null($item->read_at) ? 'unread' : 'read' }}" role="button" tabindex="0"
                        style="text-decoration: none" href="{{ route('notifications.read', $item->id) }}"
                        data-read="{{ is_null($item->read_at) ? 'unread' : 'read' }}" data-module="{{ $item->module }}"
                        data-created="{{ $item->created_at->toIsoString() }}">

                        <div class="notif-left">
                            <div class="notif-box">
                                <i
                                    class="@switch($item->type)
                                @case('info') fa-solid fa-circle-info  @break
                                @case('warning') fa-solid fa-triangle-exclamation  @break
                                @case('danger') fa-solid fa-circle-exclamation @break
                                @case('success') fa-solid fa-circle-check @break
                                @default fa-solid fa-bell @endswitch">
                                </i>
                            </div>

                            <div class="notif-text">
                                <div class="notif-title">{{ $item->title }}</div>
                                <div class="notif-desc">
                                    {{ $item->message }}
                                </div>
                            </div>
                        </div>

                        <div class="notif-right">
                            <span
                                class="notif-time">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(['short' => true, 'parts' => 1]) }}</span>
                            <span class="notif-dot"></span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifRows = document.querySelectorAll('.notif-row');
            const filterPills = document.querySelectorAll('.filter-pill');
            const typeSelect = document.getElementById('notificationType');
            const timeSelect = document.getElementById('timeRangeFilter');

            let currentFilter = 'all'; // all, read, unread
            let currentType = 'all'; // module type
            let currentTime = 'today'; // today, 7days, 30days

            // Read/Unread filter
            filterPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    filterPills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.textContent.toLowerCase();
                    filterNotifications();
                });
            });

            // Type filter
            typeSelect.addEventListener('change', function() {
                currentType = this.value.toLowerCase();
                filterNotifications();
            });

            // Time range filter
            timeSelect.addEventListener('change', function() {
                currentTime = this.value;
                filterNotifications();
            });

            function filterNotifications() {
                const now = new Date();

                notifRows.forEach(row => {
                    const readStatus = row.dataset.read;
                    const moduleType = row.dataset.module.toLowerCase();
                    const notifDate = new Date(row.dataset.created); // parse ISO string

                    // Read/unread match
                    const filterMatch = (currentFilter === 'all' || readStatus === currentFilter);

                    // Type match
                    const typeMatch = (currentType === 'notification type'.toLowerCase() || currentType ===
                        moduleType);

                    // Time match
                    let timeMatch = true;
                    const diffDays = (now - notifDate) / (1000 * 60 * 60 * 24); // difference in days

                    switch (currentTime) {
                        case 'today':
                            timeMatch = diffDays < 1;
                            break;
                        case '7days':
                            timeMatch = diffDays <= 7;
                            break;
                        case '30days':
                            timeMatch = diffDays <= 30;
                            break;
                        default:
                            timeMatch = true;
                    }

                    // Show/hide row
                    row.style.display = (filterMatch && typeMatch && timeMatch) ? '' : 'none';
                });
            }
        });
    </script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
