@extends('Layout.app')

@section('content')
    <section id="assets" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Asset Management</h2>
            <div class="group-box">

                @if (Auth::user()->canAccess('Assets', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#assetModal">
                        <i class="fa-solid fa-plus"></i>
                        Add New Asset
                    </button>
                @endif

                <x-notification-dropdown />
            </div>
        </div>
        @include('Components/Modal/addAsset')
        <!-- Data Table -->
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
                                <option value="Firewall">Firewall</option>
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
                    <div class="table-responsive" style="max-height: 80vh; overflow-y: auto;">

                        <table class="table table-borderless table-striped  align-middle" id="assetTable">
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
                                @forelse ($items  as $index =>  $item)
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
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><a class="asset-link"
                                                href="{{ url('asset/show/' . $item->asset_tag) }}">{{ $item->asset_tag }}</a>
                                        </td>
                                        <td data-category="{{ $item->asset_category }}">{{ $item->asset_category }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>
                                            {{ ucwords($item->operational_status) }}
                                        </td>
                                        <td
                                            class="{{ $item->compliance_status === 'Compliant' ? 'text-success' : 'text-danger' }}">
                                            {{ $item->compliance_status }}
                                        </td>
                                        <td>{{ $item->purchase_cost }}</td>
                                        <td>
                                            {{ number_format($item->current_value, 2) }}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <i class="fa fa-archive mb-3" style="font-size: 4rem; color: #6c757d;"></i>
                                                <h4 class="mb-2" style="color: #6c757d; font-weight: 500;">
                                                    No Assets
                                                </h4>
                                                <small class="text-muted">
                                                    Add new assets to see them listed here.
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('/Js/Assets/assetFilter.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
