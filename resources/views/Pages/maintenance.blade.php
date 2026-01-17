@extends('Layout.app')

@section('content')
    <div id="maintenance" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Maintenance & Repair</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <button class="add-btn">
                    <i class="fa-solid fa-plus"></i>
                    Schedule Maintenance
                </button>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <!-- total maintenance -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="total-maintenance">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                    <!-- number and label -->
                    <div class="maintenance-count">
                        <h2>18</h2>
                        <h6>Total Maintenance</h6>
                    </div>
                </div>
            </div>

            <!-- in progress -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="in-progress">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <!-- number and label -->
                    <div class="maintenance-count">
                        <h2>5</h2>
                        <h6>In Progress</h6>
                    </div>
                </div>
            </div>

            <!-- completed -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="completed">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <!-- number and label -->
                    <div class="maintenance-count">
                        <h2>10</h2>
                        <h6>Completed</h6>
                    </div>
                </div>
            </div>

            <!-- high priority -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="high-priority">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <!-- number and label -->
                    <div class="maintenance-count">
                        <h2>3</h2>
                        <h6>High Priority</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="container">
                <div class="table-container">
                    <!-- seach, filter & pagination -->
                    <div class="controls">
                        <div class="searfil">
                            <!-- search -->
                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search assets..." />
                            </div>

                            <!-- filter -->
                            <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter"
                                style="border-radius: 5px">
                                <option value="all">All Assets</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Desktop">Desktop</option>
                                <option value="Server">Server</option>
                                <option value="Network Switch">Network Switch</option>
                                <option value="Firewall">Firewall</option>
                                <option value="Software License">Software License</option>
                            </select>
                        </div>

                        <!-- pagination -->
                        <div class="pagination" id="pagination"></div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" id="assetTable">
                            <thead class="border-bottom">
                                <tr>
                                    <th>Asset Name</th>
                                    <th>Asset Tag</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Scheduled Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span>HP LaserJet Pro</span></td>
                                    <td>NPB-PR-001</td>
                                    <td>Repair</td>
                                    <td><span class="pill priority-high">High</span></td>
                                    <td>Jun 1, 2025</td>
                                    <td>
                                        <span class="pill status-progress">In Progress</span>
                                    </td>
                                    <td><a href="#" class="view-link">View</a></td>
                                </tr>

                                <tr>
                                    <td><span>Dell OptiPlex 7090</span></td>
                                    <td>NPB-DT-003</td>
                                    <td>Preventive</td>
                                    <td>
                                        <span class="pill priority-medium">Medium</span>
                                    </td>
                                    <td>Jun 3, 2025</td>
                                    <td>
                                        <span class="pill status-scheduled">Scheduled</span>
                                    </td>
                                    <td><a href="#" class="view-link">View</a></td>
                                </tr>

                                <tr>
                                    <td><span>Cisco Catalyst 9300</span></td>
                                    <td>NPB-NET-001</td>
                                    <td>Inspection</td>
                                    <td><span class="pill priority-low">Low</span></td>
                                    <td>Jun 5, 2025</td>
                                    <td>
                                        <span class="pill status-scheduled">Scheduled</span>
                                    </td>
                                    <td><a href="#" class="view-link">View</a></td>
                                </tr>

                                <tr>
                                    <td><span>MacBook Pro 14"</span></td>
                                    <td>NPB-LT-005</td>
                                    <td>Repair</td>
                                    <td><span class="pill priority-high">High</span></td>
                                    <td>May 28, 2025</td>
                                    <td>
                                        <span class="pill status-completed">Completed</span>
                                    </td>
                                    <td><a href="#" class="view-link">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
