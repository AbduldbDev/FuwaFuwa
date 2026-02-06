@extends('Layout.app')

@section('content')
    <section id="dashboard" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Dashboard</h2>
            <div class="group-box">

                <x-notification-dropdown />
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- upper -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #1E40AF; background: #E0E7FF;">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <h2>{{ $TotalAssets }}</h2>
                            <h6>Total Assets</h6>
                        </div>
                    </div>

                    <hr>

                    <!-- lower -->
                    <div class="asset-breakdown">
                        <!-- physical -->
                        <div class="asset-item physical">
                            <i class="fa-solid fa-box icon"></i>
                            <div class="total-assets">
                                <span>{{ $TotalPhysicalAsset }}</span>
                                <small>Physical Assets</small>
                            </div>
                        </div>

                        <!-- digital -->
                        <div class="asset-item digital">
                            <i class="fa-solid fa-laptop-code icon"></i>
                            <div class="total-assets">
                                <span>{{ $TotalDigitalAsset }}</span>
                                <small>Digital Assets</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- upper -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #166534; background: #DCFCE7;">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <div>
                            <h2>{{ $TotalInStock }}</h2>
                            <h6>In Stocks</h6>
                        </div>
                    </div>

                    <hr>

                    <!-- lower -->
                    <div class="asset-breakdown">
                        <!-- physical -->
                        <div class="asset-item physical">
                            <i class="fa-solid fa-box icon"></i>
                            <div class="total-assets">
                                <span>{{ $TotalInStockPhysical }}</span>
                                <small>Physical Assets</small>
                            </div>
                        </div>

                        <!-- digital -->
                        <div class="asset-item digital">
                            <i class="fa-solid fa-laptop-code icon"></i>
                            <div class="total-assets">
                                <span>{{ $TotalInStockDigital }}</span>
                                <small>Digital Assets</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- upper -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #92400E; background: #FFEDD5;">
                            <i class="fa-solid fa-peso-sign"></i>
                        </div>
                        <div>
                            <h2>₱{{ number_format($TotalCost, 2) }}</h2>
                            <h6>Total Cost of Assets</h6>
                        </div>
                    </div>

                    <hr>

                    <!-- lower -->
                    <div class="asset-breakdown">
                        <!-- physical -->
                        <div class="asset-item physical">
                            <i class="fa-solid fa-box icon"></i>
                            <div class="total-assets">
                                <span>₱{{ number_format($TotalCostPhysical, 2) }}</span>
                                <small>Physical Assets</small>
                            </div>
                        </div>

                        <!-- digital -->
                        <div class="asset-item digital">
                            <i class="fa-solid fa-laptop-code icon"></i>
                            <div class="total-assets">
                                <span>₱{{ number_format($TotalCostDigital, 2) }}</span>
                                <small>Digital Assets</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <!-- upper -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #6D28D9; background: #EDE9FE;">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>
                        <div>
                            <h2> ₱{{ number_format($TotalPhysicalDepreciationSum + $TotalDigitalDepreciationSum, 2) }}</h2>
                            <h6>Current Book Value</h6>
                        </div>
                    </div>

                    <hr>

                    <!-- lower -->
                    <div class="asset-breakdown">
                        <!-- physical -->
                        <div class="asset-item physical">
                            <i class="fa-solid fa-box icon"></i>
                            <div class="total-assets">
                                <span>₱{{ number_format($TotalPhysicalDepreciationSum, 2) }}</span>
                                <small>Physical Assets</small>
                            </div>
                        </div>

                        <!-- digital -->

                    </div>
                </div>
            </div>

            <!-- Pie Charts -->
            <div class="container mt-4">
                <div class="row g-4 justify-content-center">

                    <!-- Asset Category -->
                    <div class="col-lg-4 col-md-6">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h6>Asset Category</h6>
                                <div class="chart-sub">
                                    <h2>{{ array_sum($AssetCategories) }}</h2>
                                </div>
                            </div>

                            <div class="chart-body">
                                <canvas id="assetChart"></canvas>
                            </div>

                            <div class="asset-breakdown">
                                <!-- physical -->
                                <div class="asset-item physical">
                                    <i class="fa-solid fa-box icon"></i>
                                    <div class="total-assets">
                                        <span>{{ $TotalPhysicalAsset }}</span>
                                        <small>Physical Assets</small>
                                    </div>
                                </div>

                                <!-- digital -->
                                <div class="asset-item digital">
                                    <i class="fa-solid fa-laptop-code icon"></i>
                                    <div class="total-assets">
                                        <span>{{ $TotalDigitalAsset }}</span>
                                        <small>Digital Assets</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance -->
                    <div class="col-lg-4 col-md-6">
                        <div class="chart-card">
                            <div class="chart-header mb-2">
                                <h6>Compliance Status</h6>
                                <div class="chart-sub">
                                    <h2>{{ array_sum($ComplianceStatuses) }}</h2>
                                </div>
                            </div>
                            <div class="chart-body">
                                <canvas id="complianceChart"></canvas>
                                <div class="chart-center-label">
                                    <div class="asset-breakdown">
                                        <!-- compliant -->
                                        <div class="asset-item compliant">
                                            <i class="fa-solid fa-file-circle-check icon"></i>
                                            <div class="total-assets">
                                                <span>{{ number_format($ComplianceStatuses['Compliant'] ?? 0) }}</span>
                                                <small>Compliant</small>
                                            </div>
                                        </div>

                                        <!-- non-compliant -->
                                        <div class="asset-item non-compliant">
                                            <i class="fa-solid fa-file-circle-xmark icon"></i>
                                            <div class="total-assets">
                                                <span>{{ number_format($ComplianceStatuses['Non-Compliant'] ?? 0) }}</span>
                                                <small>Non-Compliant</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="col-lg-4 col-md-6">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h6>User Roles</h6>
                                <div class="chart-sub">
                                    <h2>{{ array_sum($usersByType) }}</h2>
                                </div>
                            </div>
                            <div class="chart-body">
                                <canvas id="usersChart"></canvas>
                            </div>

                            <div class="chart-footer mt-4">
                                <h5>Access Levels</h5>
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
                                        <th>Current Book Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td><a class="asset-link"
                                                    href="{{ url('asset/show/' . $item->asset_tag) }}">{{ $item->asset_tag }}</a>
                                            </td>
                                            <td data-category="{{ $item->asset_category }}">{{ $item->asset_category }}
                                            </td>
                                            <td>
                                                @if ($item->asset_type === 'Physical Asset')
                                                    {{ optional($item->technicalSpecifications->firstWhere('spec_key', 'Asset_Model'))->spec_value ?? 'N/A' }}
                                                @elseif ($item->asset_type === 'Digital Asset')
                                                    {{ optional($item->technicalSpecifications->firstWhere('spec_key', 'License_Name'))->spec_value ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
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
        const assetCategories = @json($AssetCategories);
        const complianceStatuses = @json($ComplianceStatuses);
        const usersByType = @json($usersByType);

        // ASSET CATEGORY — Horizontal Bar
        new Chart(document.getElementById("assetChart"), {
            type: "bar",
            data: {
                labels: Object.keys(assetCategories),
                datasets: [{
                    data: Object.values(assetCategories),
                    backgroundColor: "#7C4DFF",
                    borderRadius: 10,
                    barThickness: 18
                }]
            },
            options: {
                indexAxis: "y",
                maintainAspectRatio: false,
                responsive: true,

                layout: {
                    padding: {
                        right: 40
                    }
                },

                plugins: {
                    legend: {
                        display: false
                    },

                    datalabels: {
                        anchor: "end",
                        align: "right",
                        clamp: true,
                        clip: false,
                        color: "#555",
                        font: {
                            weight: "600",
                            size: 11
                        },
                        formatter: value => value
                    }
                },

                scales: {
                    x: {
                        display: false,
                        suggestedMax: Math.max(...[28, 22, 15, 12, 10, 5, 8, 6]) + 5
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            callback: function(value) {
                                const label = this.getLabelForValue(value);
                                return label.length > 8 ?
                                    label.substring(0, 8) + "…" :
                                    label;
                            }
                        }
                    }
                }
            }
        });


        // COMPLIANCE STATUS — Doughnut
        new Chart(document.getElementById("complianceChart"), {
            type: "doughnut",
            data: {
                labels: Object.keys(complianceStatuses),
                datasets: [{
                    data: Object.values(complianceStatuses),
                    backgroundColor: [
                        "#4CAF50",
                        "#FF5252",
                        "#FF7043",
                        "#FDD835",
                        "#BDBDBD"
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "72%",

                plugins: {
                    legend: {
                        display: false
                    },

                    // ✅ Hover shows ONLY label name
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.label
                        }
                    },

                    // ✅ Numbers inside slices
                    datalabels: {
                        display: true,
                        color: "#fff",
                        font: {
                            weight: "600",
                            size: 12
                        },
                        anchor: "center",
                        align: "center",
                        clamp: true,
                        formatter: value => value
                    }
                }
            }
        });


        // USERS — Vertical Bar
        new Chart(document.getElementById("usersChart"), {
            type: "bar",
            data: {
                labels: Object.keys(usersByType),
                datasets: [{
                    data: Object.values(usersByType),
                    backgroundColor: ["#FF5252", "#FF7043", "#FDD835"],
                    borderRadius: 12,
                    barThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                layout: {
                    padding: {
                        top: 30
                    }
                },

                plugins: {
                    legend: {
                        display: false
                    },

                    datalabels: {
                        anchor: "end",
                        align: "top",
                        clamp: true,
                        clip: false,
                        font: {
                            weight: "600",
                            size: 11
                        },
                        formatter: value => value
                    }
                },

                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: false,
                        suggestedMax: Math.max(...[35, 25, 20, 10]) + 10 // ✅ auto headroom
                    }
                }
            }
        });
    </script>

    <script src="{{ asset('/Js/tablesearch.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('/Js/Assets/assetFilter.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
