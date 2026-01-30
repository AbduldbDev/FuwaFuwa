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
                    <h1>{{ $totalonhand }}</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Total Cost of Assets</h5>
                    <h1>₱{{ number_format($totalCost, 2) }}</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Asset Value</h5>
                    <h1>₱{{ number_format($depreciationSum, 2) }}</h1>
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
            <div class="row">
                <div class="container mt-4">
                    <div class="table-container">
                        <!-- seach, filter & pagination -->
                        <div class="controls">

                            <!-- search -->
                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search assets..." />
                            </div>

                            <div class="filters">
                                <!-- category -->
                                <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter">
                                    <option value="all">All Categories</option>
                                    <option value="PC">PC</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Router">Router</option>
                                    <option value="Switch">Switch</option>
                                    <option value="Modem">Modem</option>
                                    <option value="Communication Cabinet">Communication Cabinet</option>
                                    <option value="Server Cabinet">Server Cabinet</option>
                                    <option value="License">License</option>
                                    <option value="Software">Software</option>
                                </select>

                                <!-- Status -->
                                <select class="form-select form-select-sm w-auto shadow-none" id="statusFilter"
                                    style="border-radius: 10px">
                                    <option value="all">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="In Stock">In Stock</option>
                                    <option value="Under Maintenance">Under Maintenance</option>
                                    <option value="Retired">Retired</option>
                                </select>

                                <!-- Compliance Type -->
                                <select class="form-select form-select-sm w-auto shadow-none" id="complianceFilter"
                                    style="border-radius: 10px">
                                    <option value="all">All Compliance</option>
                                    <option value="Compliant">Compliant</option>
                                    <option value="Non-Compliant">Non-Compliant</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped align-middle" id="assetTable">
                                <thead class="border-bottom">
                                    <tr>
                                        <th></th>
                                        <th>Asset ID</th>
                                        <th>Category</th>
                                        <th>Model Name</th>
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
                                            <td><a class="asset-link"
                                                    href="{{ url('asset/show/' . $item->asset_tag) }}">{{ $item->asset_tag }}</a>
                                            </td>
                                            <td data-category="{{ $item->asset_category }}">{{ $item->asset_category }}</td>
                                            <td>{{ $item->asset_name }}</td>
                                            <td>Active</td>
                                            <td
                                                class="{{ $item->compliance_status === 'Compliant' ? 'text-success' : 'text-danger' }}">
                                                {{ $item->compliance_status }}
                                            </td>
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

        </div>
    </section>

    <script>
        const assetData = @json(array_values($assetCategories));
        const assetLabels = @json(array_keys($assetCategories));

        const complianceData = @json(array_values($complianceStatuses));
        const complianceLabels = @json(array_keys($complianceStatuses));

        const usersData = @json(array_values($usersByType));
        const usersLabels = @json(array_keys($usersByType));

        const options = {
            type: "doughnut",
            options: {
                cutout: "70%",
                plugins: {
                    legend: {
                        display: false
                    }
                },
            },
        };

        new Chart(document.getElementById("assetChart"), {
            ...options,
            data: {
                labels: assetLabels,
                datasets: [{
                    data: assetData,
                    backgroundColor: [
                        "#5B8DEF", "#7C4DFF", "#F062F2", "#FF5252", "#FF9800", "#FDD835"
                    ]
                }]
            }

        });

        new Chart(document.getElementById("complianceChart"), {
            ...options,
            data: {
                labels: complianceLabels,
                datasets: [{
                    data: complianceData,
                    backgroundColor: [
                        "#F062F2", "#FF5252", "#FF7043", "#FDD835", "#42A5F5"
                    ]
                }]
            }
        });

        new Chart(document.getElementById("usersChart"), {
            ...options,
            data: {
                labels: usersLabels,
                datasets: [{
                    data: usersData,
                    backgroundColor: [
                        "#FF5252", "#FF7043", "#FDD835", "#4DD0E1", "#5B8DEF"
                    ]
                }]
            }
        });
    </script>

    <script src="{{ asset('/js/tablesearch.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
