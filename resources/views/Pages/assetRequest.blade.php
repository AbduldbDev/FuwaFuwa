@extends('Layout.app')

@section('content')
    <div id="asset-request" class="content-section">
        <!-- navbar -->
        <div class="navbar mb-4">
            <h2>Asset Request</h2>
            <div class="group-box">

                @if (Auth::user()->canAccess('Asset Request', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#requestAsset">
                        <i class="fa-solid fa-plus"></i>
                        <div class="btn-text">Request Asset</div>
                    </button>
                @endif

                <x-notification-dropdown />
            </div>
        </div>

        <!-- numbers -->
        <div class="row mb-2">
            <x-stat-card icon="fa-solid fa-file-circle-plus" icon-color="#1E40AF" icon-bg="#E0E7FF" title="Total Request"
                :value="$TotalRequests" />

            <x-stat-card icon="fa-solid fa-paper-plane" icon-color="#166534" icon-bg="#DCFCE7" title="Total For Release"
                :value="$TotalProcured" />

            <x-stat-card icon="fa-solid fa-laptop-code" icon-color="#6D28D9" icon-bg="#EDE9FE"
                title="In Stocks (Digital Assets)" :value="$TotalOnHandDigital" />

            <x-stat-card icon="fa-solid fa-boxes-packing" icon-color="#6D28D9" icon-bg="#EDE9FE"
                title="In Stocks (Physical Assets)" :value="$TotalOnHandPhysical" />
        </div>

        <!-- overview -->
        <div class="request-container ">

            <div class="request-control d-flex mb-3">
                <h3 class="mb-0">Requests Overview</h3>

                <input type="text" id="requestSearch" class="form-control w-25" placeholder="Search request...">
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
                            'For Procurement' => 'in-procurement',
                            'For Release' => 'procured',
                            'Closed' => 'closed',
                            default => 'for-review',
                        };
                    @endphp

                    <div class="col-12 col-md-12 col-xl-4 mb-4 request-card-wrapper"
                        data-status="{{ strtolower($item->status) }}"
                        data-search="{{ strtolower($item->asset_type . ' ' . $item->model . ' ' . $item->request_id . ' ' . $item->status) }}">
                        <div class="request-card {{ $CardClass }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- asset-info -->
                                <div class="d-flex align-items-center gap-3">
                                    @php

                                        $priorityClass = match ($item->priority) {
                                            'low' => 'bg-primary text-white',
                                            'medium' => 'bg-success text-white',
                                            'high' => 'bg-warning text-dark',
                                            'emergency' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };

                                        $icon = $item->category->icon ?? 'fa-box';
                                    @endphp
                                    <div class="asset-icon">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                    <div class="request-info">
                                        <h6>{{ $item->asset_type }} - {{ $item->model }}</h6>
                                        <small class="text-muted">{{ $item->request_id }}</small>

                                        <div class="mobile-view">
                                            <span class="priority-badge low">{{ $item->status }}</span>
                                            <span
                                                class="priority-badge  {{ $priorityClass }} low">{{ ucfirst($item->priority) }}
                                                Priority</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- time and buttons -->
                                <div class="d-flex flex-column align-items-end gap-2">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(['short' => true, 'parts' => 1]) }}
                                    </small>

                                    <!-- action buttons -->
                                    <div class="d-flex gap-2">
                                        <!-- View -->
                                        <button class="btn btn-outline-primary action-btn" data-bs-toggle="modal"
                                            data-bs-target="#requestDetailsModal{{ $item->id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        @if ($item->status == 'For Review' && Auth::user()->id == $item->user_id)
                                            <a class="btn btn-outline-warning action-btn">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <button class="btn btn-outline-danger action-btn delete-asset-btn"
                                                data-url="{{ route('asset-request.delete', $item->id) }}"
                                                data-name="{{ $item->asset_name }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('Components.Modal.AssetRequest.requestAssetDetails')
                @endforeach
            </div>
        </div>
    </div>

    @include('Components.Modal.AssetRequest.requestAsset')
    @include('Components.Modal.AssetRequest.addRequestAsset')
    @include('Components.Modal.AssetRequest.assignAsset')
    <script src="{{ asset('/Js/Assets/assetRequestFilter.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('/Js/SweetAlert/DeleteRequest.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
