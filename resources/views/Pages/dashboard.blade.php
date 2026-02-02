@extends('Layout.app')

@section('content')
    <section id="dashboard" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Dashboard</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>

                <x-notification-dropdown />
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <x-stat-card icon="fa-solid fa-boxes-stacked" icon-color="#1E40AF" icon-bg="#E0E7FF" title="Total Assets"
                :value="$totalAssets" />

            <x-stat-card icon="fa-solid fa-boxes-packing" icon-color="#166534" icon-bg="#DCFCE7" title="In Stocks"
                :value="$totalonhand" />

            <x-stat-card icon="fa-solid fa-peso-sign" icon-color="#92400E" icon-bg="#FFEDD5" title="Total Cost of Assets"
                :value="'₱' . number_format($totalCost, 2)" />

            <x-stat-card icon="fa-solid fa-chart-simple" icon-color="#6D28D9" icon-bg="#EDE9FE" title="Asset Value"
                :value="'₱' . number_format($depreciationSum, 2)" />

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
                                        <th class="text-center">#</th>
                                        <th>Asset Tag</th>
                                        <th>Category</th>
                                        <th>Model Name</th>
                                        <th>Status</th>
                                        <th>Compliance Type</th>
                                        <th>Purchase Cost</th>
                                        <th>Asset Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td><a class="asset-link"
                                                    href="{{ url('asset/show/' . $item->asset_tag) }}">{{ $item->asset_tag }}</a>
                                            </td>
                                            <td data-category="{{ $item->asset_category }}">{{ $item->asset_category }}</td>
                                            <td>{{ $item->asset_name }}</td>
                                            <td>{{ $item->operational_status }}</td>
                                            <td
                                                class="{{ $item->compliance_status === 'Compliant' ? 'text-success' : 'text-danger' }}">
                                                {{ $item->compliance_status }}
                                            </td>
                                            <td>{{ $item->purchase_cost }}</td>
                                            <td>{{ number_format($item->current_value, 2) }}</td>
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

    <script src="{{ asset('/Js/tablesearch.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('/Js/Assets/assetFilter.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
