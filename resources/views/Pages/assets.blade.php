@extends('Layout.app')

@section('content')
    <section id="assets" class="content-section">
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
                <i class="fa-regular fa-bell notif-bell"></i>
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
                                <option value="Available">Available</option>
                                <option value="Assigned">Assigned</option>
                                <option value="Under Maintenance">Under Maintenance</option>
                                <option value="Retired">Retired</option>
                            </select>

                            <!-- Compliance Type -->
                            <select class="form-select form-select-sm w-auto shadow-none" id="complianceFilter"
                                style="border-radius: 10px">
                                <option value="all">All Compliance</option>
                                <option value="Licensed">Licensed</option>
                                <option value="Non-Licensed">Non-Licensed</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" id="assetTable">
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
                                        <td data-category="{{ $item->asset_type }}">{{ $item->asset_type }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>Active</td>
                                        <td class="text-danger">{{ $item->compliance_status }}</td>
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
    </section>

    <script src="{{ asset('/js/assetFilter.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
