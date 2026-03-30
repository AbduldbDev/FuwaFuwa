@extends('Layout.app')

@section('content')
    <section id="asset-detail" class="asset-detail-section">
        <!-- navbar -->
        <div class="navbar mb-4">
            <h2>Asset Management</h2>
            <div class="group-box">

                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#assetModal">
                    <i class="fa-solid fa-plus"></i>
                    <div class="btn-text">Add New Asset</div>
                </button>

                <x-notification-dropdown />
            </div>
        </div>
        @include('Components/Modal/addAsset')

        <!-- Asset Model -->
        <div class="asset-header my-4">
            <div class="asset-upper d-flex justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    @php

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
                        $icon = $item->category->icon ?? 'fa-box';
                    @endphp

                    <div class="asset-icon">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>

                    <!-- Asset Info -->
                    <div class="asset-information">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="fw-semibold">{{ $item->asset_tag }}</h4>
                            <span class="badge {{ $badgeClass }}">
                                {{ $item->operational_status === 'Active' ? 'Assigned' : ucwords($item->operational_status) }}
                            </span>
                        </div>
                        <div class="asset-meta text-muted">
                            <span>{{ $item->asset_model }}</span>
                            <span class="divider">|</span>
                            <span> <i class=" me-1 fa-regular fa-user"></i> {{ $item->users->name }}</span>
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
                <button class="tab" data-tab="history">Update Logs</button>
                <button class="tab" data-tab="maintenancelogs">Maintenance Logs</button>

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
                                    <div class="col-5 label">Delete Reason</div>
                                    <div class="col-7 value">{{ $item->delete_title }}</div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Reason Description</div>
                                    <div class="col-7 value">{{ $item->delete_reason }}</div>
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
                                <div class="col-5 label">Asset Type</div>
                                <div class="col-7 value">{{ $item->asset_type }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Asset Category</div>
                                <div class="col-7 value">{{ $item->asset_category }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Asset Tag</div>
                                <div class="col-7 value">{{ $item->asset_tag }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Asset Model</div>
                                <div class="col-7 value">{{ $item->asset_model }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Operational Status</div>
                                <div class="col-7 value">
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $item->operational_status === 'Active' ? 'Assigned' : ucwords($item->operational_status) }}</span>
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
                            @php
                                function maskSpec($text)
                                {
                                    $lines = preg_split('/\r\n|\r|\n/', $text);
                                    $result = [];
                                    $pendingKey = null;

                                    foreach ($lines as $line) {
                                        $trimmed = trim($line);

                                        // Handle multiline (key: \n value)
                                        if ($pendingKey) {
                                            $value = $trimmed;

                                            if (preg_match('/\bkey\b/i', $pendingKey)) {
                                                $masked =
                                                    strlen($value) > 3
                                                        ? str_repeat('*', strlen($value) - 3) . substr($value, -3)
                                                        : str_repeat('*', strlen($value));

                                                $result[] = $pendingKey . ' ' . $masked;
                                            } else {
                                                $result[] = $pendingKey . ' ' . $value;
                                            }

                                            $pendingKey = null;
                                            continue;
                                        }

                                        // ✅ Only real separators (: ; | =)
                                        if (preg_match('/^(.+?)([:;\|=]+)(.+)$/', $trimmed, $matches)) {
                                            $leftSide = trim($matches[1]);
                                            $separator = $matches[2];
                                            $value = trim($matches[3]);

                                            if (preg_match('/\bkey\b/i', $leftSide)) {
                                                $masked =
                                                    strlen($value) > 3
                                                        ? str_repeat('*', strlen($value) - 3) . substr($value, -3)
                                                        : str_repeat('*', strlen($value));

                                                $result[] = $leftSide . $separator . ' ' . $masked;
                                            } else {
                                                $result[] = $leftSide . $separator . ' ' . $value;
                                            }
                                        }
                                        // Match "key:" only (value next line)
                                        elseif (preg_match('/^(.+?)([:;\|=])$/', $trimmed, $matches)) {
                                            $pendingKey = trim($matches[1]) . $matches[2];
                                        } else {
                                            // ✅ Leave normal sentences untouched
                                            $result[] = $line;
                                        }
                                    }

                                    return implode("\n", $result);
                                }
                            @endphp

                            @if ($item->technical_specifications)
                                <div class="row detail-row">
                                    <div class="col-12 value">
                                        @if (Auth::user()->user_type === 'viewer')
                                            {!! nl2br(e(maskSpec($item->technical_specifications))) !!}
                                        @else
                                            {!! nl2br(e($item->technical_specifications)) !!}
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row detail-row">
                                    <div class="col-12 text-muted">
                                        No technical specifications available.
                                    </div>
                                </div>
                            @endif
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
                                    <div class="col-5 label">Assigned To</div>
                                    <div class="col-7 value">{{ $item->assigned_to ?? 'N/A' }}</div>
                                </div>
                                <div class="row detail-row">
                                    <div class="col-5 label">Department</div>
                                    <div class="col-7 value">{{ $item->department ?? 'N/A' }}</div>
                                </div>
                                <div class="row detail-row">
                                    <div class="col-5 label">Location</div>
                                    <div class="col-7 value">{{ $item->location ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- purchase information -->
                    <div class="section-card mb-3">
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
                                <div class="col-5 label">Vendor</div>
                                <div class="col-7 value">
                                    {{ $item->vendor->name ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Purchase Date</div>
                                <div class="col-7 value">
                                    {{ \Carbon\Carbon::parse($item->purchase_date)->format('F d, Y') }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Purchase Cost</div>
                                <div class="col-7 value">Php {{ number_format($item->purchase_cost, 2) }}
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

                                <div class="row detail-row">
                                    <div class="col-5 label">Purchase Year</div>
                                    <div class="col-7 value">
                                        {{ $item->purchase_date ? $item->purchase_date->year : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Useful Life (Remaining)</div>
                                    <div class="col-7 value">
                                        {{ $item->remaining_life > 0 ? round($item->remaining_life, 0) . ' yrs' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Years Used</div>
                                    <div class="col-7 value">
                                        {{ $item->years_used > 0 ? round($item->years_used, 0) . ' yrs' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Purchase Cost</div>
                                    <div class="col-7 value">
                                        {{ $item->purchase_cost > 0 ? 'Php ' . number_format($item->purchase_cost, 2) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Salvage Value</div>
                                    <div class="col-7 value">
                                        {{ $item->salvage_value > 0 ? 'Php ' . number_format($item->salvage_value, 2) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Depreciation Rate</div>
                                    <div class="col-7 value">
                                        {{ $item->depreciation_rate > 0 ? number_format($item->depreciation_rate, 2) . '% per year' : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Annual Depreciation</div>
                                    <div class="col-7 value">
                                        {{ $item->annual_depreciation > 0 ? 'Php ' . number_format($item->annual_depreciation, 2) : 'Php 0.00' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Current Book Value</div>
                                    <div class="col-7 value">
                                        {{ $item->current_value > 0 ? 'Php ' . number_format($item->current_value, 2) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-5 label">Total Maintenance Cost</div>
                                    <div class="col-7 value">
                                        {{ $item->total_maintenance_cost > 0 ? 'Php ' . number_format($item->total_maintenance_cost, 2) : 'Php 0.00' }}
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endif
                    <!-- pmaintenance & audit -->
                    <div class="section-card mb-3">
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
                                <div class="col-5 label">Under Warranty</div>
                                <div class="col-7 value">{{ $item->warranty_status }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">
                                    @if ($item->asset_type === 'Digital Asset')
                                        Activation Date
                                    @else
                                        Warranty Start Date
                                    @endif
                                </div>

                                <div class="col-7 value">

                                    {{ $item->warranty_start ? \Carbon\Carbon::parse($item->warranty_start)->format('F d, Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">
                                    @if ($item->asset_type === 'Digital Asset')
                                        Expiration Date
                                    @else
                                        Warranty End Date
                                    @endif
                                </div>

                                <div class="col-7 value">
                                    {{ $item->warranty_end ? \Carbon\Carbon::parse($item->warranty_end)->format('F d, Y') : 'N/A' }}
                                </div>

                            </div>

                            @if ($item->asset_type !== 'Digital Asset')
                                <div class="row detail-row">
                                    <div class="col-5 label">Last Maintenance Schedule</div>
                                    <div class="col-7 value">
                                        {{ $item->last_maintenance ? \Carbon\Carbon::parse($item->last_maintenance)->format('F d, Y') : 'N/A' }}
                                    </div>
                                </div>

                                @if ($item->next_maintenance)
                                    <div class="row detail-row">
                                        <div class="col-5 label">Next Maintenance Schedule</div>
                                        <div class="col-7 value">
                                            {{ $item->next_maintenance ? \Carbon\Carbon::parse($item->next_maintenance)->format('F d, Y') : 'N/A' }}
                                        </div>
                                    </div>
                                @endif
                            @endif
                            {{-- <div class="row detail-row">
                                <div class="col-5 label">Useful Life (years)</div>
                                <div class="col-7 value">{{ $item->useful_life_years }} years</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-5 label">Salvage Value</div>
                                <div class="col-7 value">Php {{ number_format($item->salvage_value, 2) }}</div>
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
                                    <div class="col-5 label">
                                        {{ $doc->name ?? 'Document' }}
                                    </div>

                                    <div class="col-7 value d-flex align-items-center justify-content-between">
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

                    @if (Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'encoder')
                        <div class="section-card mb-4">
                            <div class="section-toggle">
                                <div class="asset-title" onclick="toggleSection(this)">
                                    <i class="fa-solid fa-chevron-down"></i>
                                    <h6 class="mb-0 fw-semibold">Remarks</h6>
                                </div>

                                @if (Auth::user()->canAccess('Assets', 'write') && $item->operational_status !== 'archived')
                                    <div class="edit-asset-btn">
                                        <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#updateAssetModal" data-section="remarks"
                                            data-url="{{ route('assets.update', $item->id) }}"
                                            data-asset='@json($item)'
                                            data-users='@json($users)'
                                            data-vendors='@json($vendors)'></i>
                                    </div>
                                @endif
                            </div>

                            <div class="section-body">
                                <div class="mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea name="note" class="form-control" id="" cols="30" rows="5" readonly>{{ $item->note }}</textarea>
                                </div>
                            </div>

                        </div>
                    @endif

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

        <div id="maintenancelogs" class="tab-content">
            <div class="section-card pb-3">
                <div class="history-header d-flex justify-content-between">
                    <h6 class="fw-semibold">Maintenance Logs</h6>
                </div>
                <div class="section-bod">
                    <div class="history-list">
                        @forelse ($maintenance as $item)
                            <div class="maintenance-item mb-3">
                                <div class="maintenance-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->maintenance_id ?? 'N/A' }}</strong>
                                        <span class="text-muted small ms-2">
                                            {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('M d, Y h:iA') : 'N/A' }}
                                        </span>
                                    </div>
                                    <span class="badge bg-{{ $item->status === 'Completed' ? 'success' : 'warning' }}">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                <div class="maintenance-details ms-3 mt-2">
                                    <p><span class="text-muted small">Description:</span>
                                        {{ $item->description ?? 'N/A' }}</p>
                                    <p><span class="text-muted small">Technician:</span> {{ $item->technician ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <span class="text-muted small">Start Date:</span>
                                        {{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('M d, Y') : 'N/A' }}
                                    </p>
                                    <p>
                                        <span class="text-muted small">Completed:</span>
                                        {{ $item->completed_at ? \Carbon\Carbon::parse($item->completed_at)->format('M d, Y ') : 'N/A' }}
                                    </p>

                                    @if ($item->logs && count($item->logs) > 0)
                                        <div class="logs-section mt-3">
                                            <h6 class="text-secondary mb-2">Logs:</h6>
                                            @foreach ($item->logs as $log)
                                                <div class="log-item ps-3 mb-3 border-start border-3 border-warning">

                                                    {{-- Issue Description --}}
                                                    @if ($log->issue_description)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Issue Description:</span>
                                                            {{ $log->issue_description }}
                                                        </p>
                                                    @endif

                                                    {{-- Action Taken --}}
                                                    @if ($log->action_taken)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Action Taken:</span>
                                                            {{ $log->action_taken }}
                                                        </p>
                                                    @endif

                                                    {{-- Parts Replaced --}}
                                                    @if ($log->parts_replaced)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Parts Replaced:</span>
                                                            {{ $log->parts_replaced }}
                                                        </p>
                                                    @endif

                                                    {{-- Cost --}}
                                                    @if ($log->cost)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Cost:</span>
                                                            ₱{{ number_format($log->cost, 2) }}
                                                        </p>
                                                    @endif

                                                    {{-- Start Date --}}
                                                    @if ($log->start_date)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Start Date:</span>
                                                            {{ \Carbon\Carbon::parse($log->start_date)->format('M d, Y') }}
                                                        </p>
                                                    @endif

                                                    {{-- Completion Date --}}
                                                    @if ($log->completion_date)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Completion Date:</span>
                                                            {{ \Carbon\Carbon::parse($log->completion_date)->format('M d, Y') }}
                                                        </p>
                                                    @endif

                                                    {{-- Technician Notes --}}
                                                    @if ($log->technician_notes)
                                                        <p class="mb-1">
                                                            <span class="text-muted small">Technician Notes:</span>
                                                            {{ $log->technician_notes }}
                                                        </p>
                                                    @endif

                                                    {{-- Logged At --}}
                                                    @if ($log->created_at)
                                                        <p class="mb-0 text-muted small">
                                                            Logged At:
                                                            {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y h:iA') }}
                                                        </p>
                                                    @endif

                                                </div>
                                                <hr class="my-2 mt-3">
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>

                        @empty
                            <p class="text-muted">No maintenance records found for this asset.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('Components.Modal.AssetDetails.editAsset')
    <script src="{{ asset('/Js/AssetDetails/Accordion.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('/css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
