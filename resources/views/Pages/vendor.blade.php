@extends('Layout.app')

@section('content')
    <div id="vendors" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Vendor Management</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>

                @if (Auth::user()->canAccess('Vendor', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addVendorModal">
                        <i class="fa-solid fa-plus"></i>
                        Add Vendor
                    </button>
                @endif

                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>
        @include('Components/Modal/addVendor')

        <!-- numbers -->
        <div class="row my-4">
            <!-- all vendors -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="all-entity">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <!-- number and label -->
                    <div class="entity-count">
                        <h2>12</h2>
                        <h6>Total Vendors</h6>
                    </div>
                </div>
            </div>

            <!-- active vendor -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="active-entity">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <!-- number and label -->
                    <div class="entity-count">
                        <h2>18</h2>
                        <h6>Active Vendor</h6>
                    </div>
                </div>
            </div>

            <!-- inactive vendor -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="inactive-entity">
                        <i class="fa-solid fa-store-slash"></i>
                    </div>
                    <!-- number and label -->
                    <div class="entity-count">
                        <h2>5</h2>
                        <h6>Inactive Vendor</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- vendors -->
        <div class="entity-container">
            <div class="controls mb-3">
                <h3>Vendor Profiles</h3>

                <!-- filters -->
                <div class="filters">
                    <!-- compliance -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="departmentFilter">
                        <option value="all">All Compliance Status</option>
                        <option value="Compliant">Compliant</option>
                        <option value="Non-Compliant">Non-Compliant</option>
                    </select>

                    <!-- vendor status -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="accountStatusFilter">
                        <option value="all">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="vendor-container">
                <!-- profiles -->
                <div class="vendor-card">

                    <!-- header -->
                    <div class="vendor-header">
                        <div class="vendor-avatar">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div class="vendor-main">
                            <h5 class="vendor-name">Fuwa Fuwa</h5>
                            <span class="vendor-status active-vendor">Active</span>
                        </div>
                        <div class="vendor-actions">
                            <button class="icon-btn" title="Edit Vendor">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="icon-btn" title="Vendor Details">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- body -->
                    <div class="vendor-body">
                        <div class="info-row">
                            <span class="label">Vendor ID</span>
                            <span class="value">VND-00123</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Contact Person</span>
                            <span class="value">Juan Dela Cruz</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Email</span>
                            <span class="value">vendor@email.com</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Phone</span>
                            <span class="value">+63 912 345 6789</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Category</span>
                            <span class="value">Office Equipment</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Last Transaction</span>
                            <span class="value">Jan 20, 2026</span>
                        </div>
                    </div>
                </div>

                <div class="vendor-card">

                    <!-- header -->
                    <div class="vendor-header">
                        <div class="vendor-avatar">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div class="vendor-main">
                            <h5 class="vendor-name">Fuwa Fuwa</h5>
                            <span class="vendor-status inactive-vendor">Inactive</span>
                        </div>
                        <div class="vendor-actions">
                            <button class="icon-btn" title="Edit Vendor">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="icon-btn" title="Vendor Details">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- body -->
                    <div class="vendor-body">
                        <div class="info-row">
                            <span class="label">Vendor ID</span>
                            <span class="value">VND-00123</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Contact Person</span>
                            <span class="value">Juan Dela Cruz</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Email</span>
                            <span class="value">vendor@email.com</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Phone</span>
                            <span class="value">+63 912 345 6789</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Category</span>
                            <span class="value">Office Equipment</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Last Transaction</span>
                            <span class="value">Jan 20, 2026</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
