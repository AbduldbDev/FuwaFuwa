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
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Total Request</h5>
                    <h1>{{ $TotalRequests }}</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Total Procured</h5>
                    <h1>{{ $TotalProcured }}</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>Emergency Priority</h5>
                    <h1>{{ $TotalEmergency }}</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h5>On-hand Stocks</h5>
                    <h1>{{ $TotalOnHand }}</h1>
                </div>
            </div>
        </div>

        <!-- overview -->
        <div class="request-container">
            <!-- controls -->
            <div class="request-control">
                <h3 class="mb-3">Requests Overview</h3>
                <i class="fa-solid fa-filter"></i>
            </div>

            <!-- filters -->
            <div class="d-flex gap-2 mb-4">
                <span class="filter-pill active">All</span>
                <span class="filter-pill">For Review</span>
                <span class="filter-pill">Pending Approval</span>
                <span class="filter-pill">In Procurement</span>
                <span class="filter-pill">Procured</span>

                <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter">
                    <option value="All Priority">All Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="emergency">Emergency</option>
                </select>
            </div>

            <!-- requests card -->
            <div class="row ">
                <!-- asset card -->

                @foreach ($items as $item)
                    @php
                        $priorityClass = match ($item->priority) {
                            'low' => 'bg-primary text-white',
                            'medium' => 'bg-success text-white',
                            'high' => 'bg-warning text-dark',
                            'emergency' => 'bg-danger text-white',
                            default => 'bg-secondary text-white',
                        };
                    @endphp

                    <div class="col-lg-4 col-md-6 mb-4 request-card-wrapper">
                        <div class="request-card low">
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
                                            'Software' => 'fa-code',
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
                                            <span class="request-status for-review">{{ $item->status }}</span>
                                            <span
                                                class="priority-badge  {{ $priorityClass }} low">{{ ucfirst($item->priority) }}
                                                Priority</span>
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
                                        {{-- <button class="btn btn-outline-success action-btn">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-outline-danger action-btn">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('Components.Modal.requestAssetDetails')
                @endforeach

            </div>

            <!-- modal -->

        </div>
    </div>

    @include('Components.Modal.requestAsset')
    <script src="{{ asset('/js/assetRequestFilter.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
