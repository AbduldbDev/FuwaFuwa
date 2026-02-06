@extends('Layout.app')

@section('content')
    <div id="asset-request" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Asset Request</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                @if (Auth::user()->canAccess('Asset Request', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#requestAsset">
                        <i class="fa-solid fa-plus"></i>
                        Request Asset
                    </button>
                @endif

                <x-notification-dropdown />
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <x-stat-card icon="fa-solid fa-file-circle-plus" icon-color="#1E40AF" icon-bg="#E0E7FF"
                title="Total For Release" :value="$TotalRequests" />

            <x-stat-card icon="fa-solid fa-cart-flatbed" icon-color="#166534" icon-bg="#DCFCE7" title="Total Procured"
                :value="$TotalProcured" />

            <x-stat-card icon="fa-solid fa-boxes-packing" icon-color="#6D28D9" icon-bg="#EDE9FE"
                title="In Stocks (Digital Assets)" :value="$TotalOnHandDigital" />

            <x-stat-card icon="fa-solid fa-boxes-packing" icon-color="#6D28D9" icon-bg="#EDE9FE"
                title="In Stocks (Physical Assets)" :value="$TotalOnHandPhysical" />
        </div>

        <!-- overview -->
        <div class="request-container">
            <!-- controls -->
            <div class="request-control">
                <h3 class="mb-3">Requests Overview</h3>

            </div>

            <!-- filters -->
            <div class="d-flex gap-2 mb-4">
                @php
                    $counts = $RequestStatusCounts ?? [];
                    $total = array_sum($counts);
                @endphp

                <div class="d-flex gap-2 mb-4">

                    <span class="filter-pill all active" data-status="all">
                        All <strong>({{ $total }})</strong>
                    </span>

                    <span class="filter-pill for-review" data-status="for review">
                        For Review <strong>({{ $counts['For Review'] ?? 0 }})</strong>
                    </span>

                    <span class="filter-pill in-progress" data-status="in progress">
                        In Progress <strong>({{ $counts['In Progress'] ?? 0 }})</strong>
                    </span>

                    <span class="filter-pill for-procurement" data-status="for procurement">
                        For Procurement <strong>({{ $counts['For Procurement'] ?? 0 }})</strong>
                    </span>

                    <span class="filter-pill for-release" data-status="for release">
                        For Release <strong>({{ $counts['For Release'] ?? 0 }})</strong>
                    </span>

                    <span class="filter-pill closed" data-status="closed">
                        Closed <strong>({{ $counts['Closed'] ?? 0 }})</strong>
                    </span>

                </div>

            </div>

            <!-- requests card -->
            <div class="row ">
                <!-- asset card -->

                @foreach ($items as $item)
                    @php

                        $CardClass = match ($item->status) {
                            'For Review' => 'for-review',
                            'In Progress' => 'pending-approval',
                            'In Procurement' => 'in-procurement',
                            'For Procurement' => 'procured',
                            'For Release' => 'procured',
                            'Closed' => 'procured',
                            default => 'for-review',
                        };
                    @endphp

                    <div class="col-lg-4 col-md-6 mb-4 request-card-wrapper" data-status="{{ strtolower($item->status) }}">
                        <div class="request-card {{ $CardClass }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- asset-info -->
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

                                        $icon = $icons[$item->asset_category] ?? 'fa-box';
                                    @endphp
                                    <div class="asset-icon">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $item->asset_type }} - {{ $item->model }}</h6>
                                        <small class="text-muted">{{ $item->request_id }}</small>

                                        <div class="mt-1">
                                            <span class="priority-badge low">{{ $item->status }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- time and buttons -->
                                <div class="d-flex flex-column align-items-end gap-3">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(['short' => true, 'parts' => 1]) }}
                                    </small>

                                    <!-- action buttons -->
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary action-btn" data-bs-toggle="modal"
                                            data-bs-target="#requestDetailsModal{{ $item->id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('Components.Modal.requestAssetDetails')
                @endforeach
            </div>
        </div>
    </div>

    @include('Components.Modal.requestAsset')
    @include('Components.Modal.addRequestAsset')
    <script src="{{ asset('/Js/Assets/assetRequestFilter.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
