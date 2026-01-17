@extends('Layout.app')

@section('content')
    <section id="dashboard" class="content-section active">
        <!-- navbar -->
        <div class="navbar">
            <h2>Dashboard</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Total Assets</h5>
                    <h1>{{ $totalAssets }}</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>On Hand Stocks</h5>
                    <h1>0</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Total Cost of Assets</h5>
                    <h1>0</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Asset Value</h5>
                    <h1>0</h1>
                </div>
            </div>

            <!-- Pie Charts -->
            <div class="container mt-4">
                <div class="row g-4 justify-content-center">
                    <!-- assets -->
                    <div class="col-lg-4 col-md-6">
                        <div class="chart-card">
                            <div class="chart-wrapper">
                                <canvas id="assetChart"></canvas>
                                <div class="chart-label">Asset Category</div>
                            </div>
                        </div>
                    </div>

                    <!-- compliance -->
                    <div class="col-lg-4 col-md-6">
                        <div class="chart-card">
                            <div class="chart-wrapper">
                                <canvas id="complianceChart"></canvas>
                                <div class="chart-label">Compliance Status</div>
                            </div>
                        </div>
                    </div>

                    <!-- users -->
                    <div class="col-lg-4 col-md-6">
                        <div class="chart-card">
                            <div class="chart-wrapper">
                                <canvas id="usersChart"></canvas>
                                <div class="chart-label">Users</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="container mt-4">
                <div class="table-container">
                    <!-- Search & Filter -->
                    <div class="controls">
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search assets..." />
                        </div>

                        <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter"
                            style="border-radius: 10px">
                            <option value="all">All Assets</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Server">Server</option>
                            <option value="Network Switch">Network Switch</option>
                            <option value="Firewall">Firewall</option>
                            <option value="Software License">Software License</option>
                        </select>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" id="assetTable">
                            <thead class="border-bottom">
                                <tr>
                                    <th></th>
                                    <th>Asset ID</th>
                                    <th>Category</th>
                                    <th>Model</th>
                                    <th>Status</th>
                                    <th>Compliance Type</th>
                                    <th>Purchase Cost</th>
                                    <th>Asset Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td><a class="asset-link">{{ $item->asset_tag }}</a></td>
                                        <td data-category="Laptop">{{ $item->asset_category }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>Active</td>
                                        <td class="text-danger">{{ $item->compliance_status }}</td>
                                        <td>{{ $item->purchase_cost }}</td>
                                        <td>{{ $item->location }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const options = {
            type: "doughnut",
            options: {
                cutout: "70%",
                plugins: {
                    legend: {
                        display: false
                    },
                },
            },
        };

        new Chart(document.getElementById("assetChart"), {
            ...options,
            data: {
                datasets: [{
                    data: [28, 22, 15, 12, 10, 5],
                    backgroundColor: [
                        "#5B8DEF",
                        "#7C4DFF",
                        "#F062F2",
                        "#FF5252",
                        "#FF9800",
                        "#FDD835",
                    ],
                }, ],
            },
        });

        new Chart(document.getElementById("complianceChart"), {
            ...options,
            data: {
                datasets: [{
                    data: [40, 30, 15, 10, 5],
                    backgroundColor: [
                        "#F062F2",
                        "#FF5252",
                        "#FF7043",
                        "#FDD835",
                        "#42A5F5",
                    ],
                }, ],
            },
        });

        new Chart(document.getElementById("usersChart"), {
            ...options,
            data: {
                datasets: [{
                    data: [35, 25, 20, 10],
                    backgroundColor: ["#FF5252", "#FF7043", "#FDD835", "#4DD0E1"],
                }, ],
            },
        });
    </script>
    <script src="{{ asset('/js/tablesearch.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
