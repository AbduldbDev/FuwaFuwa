@extends('Layout.app')

@section('content')
    <section id="asset-detail" class="asset-detail-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Asset Management</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#assetModal">
                    <i class="fa-solid fa-plus"></i>
                    Add New Asset
                </button>

                <x-notification-dropdown />
            </div>
        </div>
        @include('Components/Modal/addAsset')

        <!-- asset name -->
        <div class="asset-header my-4">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    @php
                        $icons = [
                            'PC' => 'fa-desktop',
                            'Laptop' => 'fa-laptop',
                            'Router' => 'fa-wifi',
                            'Firewall' => 'fa-shield-halved',
                            'Switch' => 'fa-network-wired',
                            'Modem' => 'fa-signal',
                            'Communication Cabinet' => 'fa-server',
                            'Server Cabinet' => 'fa-server',
                            'License' => 'fa-key',
                        ];
                        $statusColors = [
                            'Active' => 'bg-success',
                            'Inactive' => 'bg-secondary',
                            'In Stock' => 'bg-primary',
                            'Under Maintenance' => 'bg-warning',
                            'Retired' => 'bg-dark',
                            'Expired' => 'bg-danger',
                            'archived' => 'bg-danger',
                        ];

                        $badgeClass = $statusColors[$item->operational_status] ?? 'bg-light text-dark';
                        $icon = $icons[$item->asset_category] ?? 'fa-box';
                    @endphp

                    <div class="asset-icon">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>

                    <!-- Asset Info -->
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-1 fw-semibold">{{ $item->asset_tag }}</h4>
                            <span class="badge {{ $badgeClass }}">{{ ucwords($item->operational_status) }}</span>
                        </div>

                        <div class="asset-meta text-muted">
                            <span>{{ $item->asset_name }}</span>
                            <span class="divider">|</span>
                            <span> <i class="fa-regular fa-user"></i> {{ $item->users->name }}</span>
                            <span class="divider">|</span>
                            <span>{{ $item->asset_id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delete Icon -->

                @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
                    <button class="delete-btn" data-url="{{ route('assets.delete', $item->id) }}">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                @endif
            </div>

            <div class="date-details text-muted">
                <p><strong> Created Date: </strong> {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y - h:i A') }}
                </p>
                <p><strong> Last Update: </strong> {{ \Carbon\Carbon::parse($item->updated_at)->format('M d, Y - h:i A') }}
                </p>
            </div>
        </div>

        <!-- asset tabs -->
        <div class="tabs-wrapper mb-4">
            <div class="tabs">
                <button class="tab active" data-tab="overview">Overview</button>
                <button class="tab" data-tab="history">History</button>
                <span class="tab-indicator"></span>
            </div>
        </div>

        <!-- overview tab -->
        <div id="overview" class="tab-content active">
            <div class="row g-4">
                <!-- left side -->
                <div class="col-lg-8">

                    <!-- asset details -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Asset Details</h6>
                            </div>

                            <!-- edit asset btn -->
                            @if (Auth::user()->canAccess('Assets', 'write'))
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#updateAssetModal" data-section="asset-details"
                                        data-url="{{ route('assets.update', $item->id) }}"
                                        data-asset='@json($item)' data-users='@json($users)'
                                        data-vendors='@json($vendors)'></i>
                                </div>
                            @endif

                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Type</div>
                                <div class="col-8 value">{{ $item->asset_type }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Category</div>
                                <div class="col-8 value">{{ $item->asset_category }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Tag</div>
                                <div class="col-8 value">{{ $item->asset_tag }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Name</div>
                                <div class="col-8 value">{{ $item->asset_name }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Operational Status</div>
                                <div class="col-8 value">
                                    <span
                                        class="badge {{ $badgeClass }}">{{ ucwords($item->operational_status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- technical specification -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Technical Specification</h6>
                            </div>
                            <!-- edi asset btn -->
                            @if (Auth::user()->canAccess('Assets', 'write'))
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#updateAssetModal" data-section="technical-specs"
                                        data-url="{{ route('assets.update', $item->id) }}"
                                        data-asset='@json($item)' data-users='@json($users)'
                                        data-vendors='@json($vendors)'></i>
                                </div>
                            @endif
                        </div>

                        <div class="section-body">
                            @forelse ($item->technicalSpecifications as $spec)
                                <div class="row detail-row">
                                    <div class="col-4 label">
                                        {{ ucwords(str_replace('_', ' ', $spec->spec_key)) }}
                                    </div>
                                    <div class="col-8 value">{{ $spec->spec_value }}</div>
                                </div>
                            @empty
                                <div class="row detail-row">
                                    <div class="col-12 text-muted">No technical specifications available.</div>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- assignment and location -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Assignment & Location</h6>
                            </div>
                            <!-- edi asset btn -->

                            @if (Auth::user()->canAccess('Assets', 'write'))
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#updateAssetModal" data-section="assignment-location"
                                        data-url="{{ route('assets.update', $item->id) }}"
                                        data-asset='@json($item)'
                                        data-users='@json($users)'
                                        data-vendors='@json($vendors)'></i>
                                </div>
                            @endif
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Assigned To</div>
                                <div class="col-8 value">{{ $item->assigned_to ?? 'N/A' }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Department</div>
                                <div class="col-8 value">{{ $item->department ?? 'N/A' }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Location</div>
                                <div class="col-8 value">{{ $item->location ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- purchase information -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Purchase Information</h6>
                            </div>
                            <!-- edi asset btn -->

                            @if (Auth::user()->canAccess('Assets', 'write'))
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#updateAssetModal" data-section="purchase-info"
                                        data-url="{{ route('assets.update', $item->id) }}"
                                        data-asset='@json($item)'
                                        data-users='@json($users)'
                                        data-vendors='@json($vendors)'></i>
                                </div>
                            @endif
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Vendor</div>
                                <div class="col-8 value">
                                    {{ $item->vendor }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Purchase Date</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->purchase_date)->format('F d, Y') }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Purchase Cost</div>
                                <div class="col-8 value">Php {{ number_format($item->purchase_cost, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($item->asset_type === 'Physical Asset')
                        <div class="section-card mb-4">
                            <div class="section-toggle">
                                <!-- asset title header -->
                                <div class="asset-title" onclick="toggleSection(this)">
                                    <i class="fa-solid fa-chevron-down"></i>
                                    <h6 class="mb-0 fw-semibold">Depreciation Insights</h6>
                                </div>
                                <!-- edi asset btn -->

                                @if (Auth::user()->canAccess('Assets', 'write'))
                                    <div class="edit-asset-btn">
                                        <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#updateAssetModal" data-section="depreciation-insights"
                                            data-url="{{ route('assets.update', $item->id) }}"
                                            data-asset='@json($item)'
                                            data-users='@json($users)'
                                            data-vendors='@json($vendors)'></i>
                                    </div>
                                @endif
                            </div>

                            <div class="section-body">

                                @php
                                    $purchaseCost = $item->purchase_cost;
                                    $usefulLife = $item->useful_life_years;
                                    $salvageValue = $item->salvage_value;

                                    $purchaseYear = $item->purchase_date->year;
                                    $yearsUsed = $item->purchase_date->diffInYears(now());
                                    $depreciationPerYear = ($purchaseCost - $salvageValue) / $usefulLife;
                                    $depreciationRate =
                                        (($purchaseCost - $salvageValue) / $purchaseCost / $usefulLife) * 100;

                                    $totalDepreciation = $depreciationPerYear * $yearsUsed;
                                    $assetValue = max($purchaseCost - $totalDepreciation, $salvageValue);
                                    $remainingLife = max($usefulLife - $yearsUsed, 0);
                                @endphp

                                <div class="row detail-row">
                                    <div class="col-4 label">Purchase Year</div>
                                    <div class="col-8 value">{{ $purchaseYear }}</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Useful Life (Remaining)</div>
                                    <div class="col-8 value">{{ round($remainingLife) }} yrs </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Years Used</div>
                                    <div class="col-8 value">{{ round($yearsUsed) }} yrs</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Purchase Cost</div>
                                    <div class="col-8 value">Php {{ number_format($purchaseCost, 2) }}</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Salvage Value</div>
                                    <div class="col-8 value">Php {{ number_format($salvageValue, 2) }}</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Depreciation Rate</div>
                                    <div class="col-8 value">{{ number_format($depreciationRate, 2) }}% per year</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Total Depreciation</div>
                                    <div class="col-8 value">Php {{ number_format($totalDepreciation, 2) }}</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Asset Value</div>
                                    <div class="col-8 value">Php {{ number_format($assetValue, 2) }}</div>
                                </div>

                            </div>

                        </div>
                    @endif
                    <!-- pmaintenance & audit -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Maintenance & Audit</h6>
                            </div>
                            <!-- edi asset btn -->

                            @if (Auth::user()->canAccess('Assets', 'write'))
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#updateAssetModal" data-section="maintenance-audit"
                                        data-url="{{ route('assets.update', $item->id) }}"
                                        data-asset='@json($item)'
                                        data-users='@json($users)'
                                        data-vendors='@json($vendors)'></i>
                                </div>
                            @endif
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Compliance Status</div>
                                <div class="col-8 value">{{ $item->compliance_status }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Warranty Start Date</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->warranty_start)->format('F d, Y') }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Warranty End Date</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->warranty_end)->format('F d, Y') }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Last Maintenance Schedule</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->next_maintenance)->format('F d, Y') }}</div>
                            </div>
                            {{-- <div class="row detail-row">
                                <div class="col-4 label">Useful Life (years)</div>
                                <div class="col-8 value">{{ $item->useful_life_years }} years</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Salvage Value</div>
                                <div class="col-8 value">Php {{ number_format($item->salvage_value, 2) }}</div>
                            </div> --}}
                        </div>
                    </div>

                    <!-- documents -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Documents</h6>
                            </div>

                            <!-- edi asset btn -->
                            @if (Auth::user()->canAccess('Assets', 'write'))
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#updateAssetModal" data-section="documents"
                                        data-url="{{ route('assets.update', $item->id) }}"
                                        data-asset='@json($item)'
                                        data-users='@json($users)'
                                        data-vendors='@json($vendors)'></i>
                                </div>
                            @endif
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Contract</div>
                                <div class="col-8 value">
                                    @if ($item->contract)
                                        <a href="{{ $item->contract }}" target="_blank">
                                            {{ str_replace('/storage/AssetDocuments/', '', $item->contract) }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Purchase Order</div>
                                <div class="col-8 value">
                                    @if ($item->purchase_order)
                                        <a href="{{ $item->purchase_order }}" target="_blank">
                                            {{ str_replace('/storage/AssetDocuments/', '', $item->purchase_order) }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- right side -->
                <div class="col-lg-4">
                    <div class="section-card">
                        <div class="history-header d-flex justify-content-between">
                            <h6 class="mb-0 fw-semibold">Recent History</h6>
                            <a href="#" class="see-all">See All</a>
                        </div>

                        <div class="card-body history-list">
                            @foreach ($AssetLogs->take(5) as $item)
                                <div class="history-item">
                                    <strong>{{ $item->user->name }}</strong> {{ ucfirst($item->action) }}
                                    {{ ucfirst(str_replace('_', ' ', $item->field_name)) }}
                                    <small>
                                        @if (!is_null($item->old_value))
                                            {{ $item->old_value }} → {{ $item->new_value }}
                                        @else
                                            {{ $item->new_value }}
                                        @endif
                                    </small>
                                    <span
                                        class="date">{{ \Carbon\Carbon::parse($item->warranty_end)->format('F d, Y h:iA') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- history tab -->
        <div id="history" class="tab-content">
            <div class="section-card pb-3">
                <div class="history-header d-flex justify-content-between">
                    <h6 class="fw-semibold ">Full Asset History</h6>
                </div>
                <div class="section-body">
                    <div class="history-list">
                        @foreach ($AssetLogs as $item)
                            <div class="history-item border-bottom pb-2">
                                <strong>{{ $item->user->name }}</strong> {{ ucfirst($item->action) }}
                                {{ ucfirst(str_replace('_', ' ', $item->field_name)) }}
                                <small>
                                    @if (!is_null($item->old_value))
                                        {{ $item->old_value }} → {{ $item->new_value }}
                                    @else
                                        {{ $item->new_value }}
                                    @endif
                                </small>
                                <span
                                    class="date">{{ \Carbon\Carbon::parse($item->warranty_end)->format('F d, Y h:iA') }}
                                </span>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('Components/Modal/updateAsset')
    <script src="{{ asset('/Js/AssetDetails/Accordion.js') }}"></script>
    <script src="{{ asset('/Js/SweetAlert/ArchiveAlert.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('/css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
