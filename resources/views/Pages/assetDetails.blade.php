@extends('Layout.app')

@section('content')
    <section id="asset-detail" class="asset-detail-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Asset Management</h2>
            <div class="group-box">

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

                @if (Auth::user()->canAccess('Assets', 'write') &&
                        $item->operational_status !== 'archived' &&
                        Auth::user()->user_type == 'admin')
                    <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#archiveAsset">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                    @include('Components.Modal.AssetDetails.ArchiveAsset')
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

                    @if ($item->operational_status === 'archived')
                        <div class="section-card mb-4">
                            <div class="section-toggle">
                                <!-- asset title header -->
                                <div class="asset-title" onclick="toggleSection(this)">
                                    <i class="fa-solid fa-chevron-down"></i>
                                    <h6 class="mb-0 fw-semibold">Archive Details</h6>
                                </div>
                            </div>

                            <div class="section-body">
                                <div class="row detail-row">
                                    <div class="col-4 label">Delete Reason</div>
                                    <div class="col-8 value">{{ $item->delete_title }}</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Reason Description</div>
                                    <div class="col-8 value">{{ $item->delete_reason }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- asset details -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Asset Details</h6>
                            </div>

                            <!-- edit asset btn -->
                            @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
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
                            @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
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
                    @if ($item->asset_type === 'Physical Asset')
                        <div class="section-card mb-4">
                            <div class="section-toggle">
                                <!-- asset title header -->
                                <div class="asset-title" onclick="toggleSection(this)">
                                    <i class="fa-solid fa-chevron-down"></i>
                                    <h6 class="mb-0 fw-semibold">Assignment & Location</h6>
                                </div>
                                <!-- edi asset btn -->

                                @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
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
                    @endif

                    <!-- purchase information -->
                    <div class="section-card mb-4">
                        <div class="section-toggle">
                            <!-- asset title header -->
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Purchase Information</h6>
                            </div>
                            <!-- edi asset btn -->

                            @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
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
                                    {{ $item->vendor->name ?? 'N/A' }}
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

                                @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
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
                                    $purchaseCost = (float) ($item->purchase_cost ?? 0);
                                    $usefulLife = (int) ($item->useful_life_years ?? 0);
                                    $salvageValue = (float) ($item->salvage_value ?? 0);

                                    $purchaseDate = $item->purchase_date;

                                    $yearsUsed = $purchaseDate ? $purchaseDate->diffInYears(now()) : 0;

                                    // Defaults
                                    $depreciationPerYear = 0;
                                    $depreciationRate = 0;
                                    $totalDepreciation = 0;
                                    $assetValue = $purchaseCost;
                                    $remainingLife = $usefulLife;

                                    // Only calculate if values are valid
                                    if ($purchaseCost > 0 && $usefulLife > 0) {
                                        $depreciationPerYear = ($purchaseCost - $salvageValue) / $usefulLife;

                                        $depreciationRate =
                                            (($purchaseCost - $salvageValue) / $purchaseCost / $usefulLife) * 100;

                                        $totalDepreciation = $depreciationPerYear * $yearsUsed;

                                        $assetValue = max($purchaseCost - $totalDepreciation, $salvageValue);

                                        $remainingLife = max($usefulLife - $yearsUsed, 0);
                                    }
                                @endphp

                                <div class="row detail-row">
                                    <div class="col-4 label">Purchase Year</div>
                                    <div class="col-8 value">
                                        {{ $purchaseDate ? $purchaseDate->year : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Useful Life (Remaining)</div>
                                    <div class="col-8 value">
                                        {{ $usefulLife > 0 ? round($remainingLife) . ' yrs' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Years Used</div>
                                    <div class="col-8 value">
                                        {{ $purchaseDate ? round($yearsUsed) . ' yrs' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Purchase Cost</div>
                                    <div class="col-8 value">
                                        {{ $purchaseCost > 0 ? 'Php ' . number_format($purchaseCost, 2) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Salvage Value</div>
                                    <div class="col-8 value">
                                        {{ $salvageValue > 0 ? 'Php ' . number_format($salvageValue, 2) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Depreciation Rate</div>
                                    <div class="col-8 value">
                                        {{ $purchaseCost > 0 && $usefulLife > 0 ? number_format($depreciationRate, 2) . '% per year' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Accumulated Depreciation</div>
                                    <div class="col-8 value">
                                        {{ $totalDepreciation > 0 ? 'Php ' . number_format($totalDepreciation, 2) : 'Php 0.00' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Current Book Value</div>
                                    <div class="col-8 value">
                                        {{ $purchaseCost > 0 ? 'Php ' . number_format($assetValue, 2) : 'N/A' }}
                                    </div>
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

                            @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
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
                                <div class="col-4 label">
                                    @if ($item->asset_type === 'Digital Asset')
                                        Activation Date
                                    @else
                                        Warranty Start Date
                                    @endif
                                </div>

                                <div class="col-8 value">

                                    {{ $item->warranty_start ? \Carbon\Carbon::parse($item->warranty_start)->format('F d, Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">
                                    @if ($item->asset_type === 'Digital Asset')
                                        Expiration Date
                                    @else
                                        Warranty End Date
                                    @endif
                                </div>

                                <div class="col-8 value">
                                    {{ $item->warranty_end ? \Carbon\Carbon::parse($item->warranty_end)->format('F d, Y') : 'N/A' }}
                                </div>

                            </div>

                            @if ($item->asset_type !== 'Digital Asset')
                                <div class="row detail-row">
                                    <div class="col-4 label">Last Maintenance Schedule</div>
                                    <div class="col-8 value">
                                        {{ $item->last_maintenance ? \Carbon\Carbon::parse($item->last_maintenance)->format('F d, Y') : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-4 label">Next Maintenance Schedule</div>
                                    <div class="col-8 value">
                                        {{ $item->next_maintenance ? \Carbon\Carbon::parse($item->next_maintenance)->format('F d, Y') : 'N/A' }}
                                    </div>
                                </div>
                            @endif
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
                            <div class="asset-title" onclick="toggleSection(this)">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Documents</h6>
                            </div>

                            @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
                                <div class="edit-asset-btn">
                                    <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                        data-bs-target="#addDocumentModal"></i>
                                </div>
                            @endif
                        </div>

                        <div class="section-body">
                            @forelse ($item->documents as $doc)
                                <div class="row detail-row" id="doc-row-{{ $doc->id }}">
                                    <div class="col-4 label">
                                        {{ $doc->name ?? 'Document' }}
                                    </div>

                                    <div class="col-8 value d-flex align-items-center justify-content-between">
                                        @if (!empty($doc->file))
                                            <a href="{{ asset('storage/' . $doc->file) }}" target="_blank">
                                                {{ basename($doc->file) }}
                                            </a>
                                        @else
                                            <span class="text-muted">No file uploaded</span>
                                        @endif

                                        <!-- Delete form -->
                                        <form action="{{ route('assets.deletedocument', $doc->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this document?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn">
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="row detail-row">
                                    <div class="col-12 text-muted">No documents available</div>
                                </div>
                            @endforelse
                        </div>
                        @include('Components.Modal.AssetDetails.AddDocument')
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
    <script src="{{ asset('/Js/AssetDetails/Accordion.js') }}?v={{ time() }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-document').click(function(e) {
                e.preventDefault();

                let docId = $(this).data('id');
                let row = $('#doc-row-' + docId);

                if (!confirm('Are you sure you want to delete this document?')) {
                    return;
                }

                $.ajax({
                    url: '{{ route('assets.deletedocument', ['document' => ':id']) }}'.replace(
                        ':id', docId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            alert(response.message);
                        } else {
                            alert(response.message || 'Failed to delete document.');
                        }
                    },
                    error: function(xhr) {
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script> --}}

@endsection

@push('css')
    <link href="{{ asset('/css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
