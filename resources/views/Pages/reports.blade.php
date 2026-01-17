@extends('Layout.app')

@section('content')
    <div id="reports" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Reports & Analytics</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <!-- <button class="add-btn">
                                    <i class="fa-solid fa-plus"></i>
                                    Add
                                  </button> -->
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h6>Total Assets</h6>
                    <h2>122</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h6>Active Users</h6>
                    <h2>183</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h6>Departments</h6>
                    <h2>544</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <h6>Reports Generated</h6>
                    <h2>555</h2>
                </div>
            </div>
        </div>

        <!-- available reports -->
        <div class="report-container">
            <div class="report-control">
                <h3>Available Reports</h3>
                <button class="create-report-btn">Create Custom Report</button>
            </div>

            <div class="report-card">
                <h5>Asset Inventory Reports</h5>
                <i class="fa-solid fa-download"></i>
            </div>
            <div class="report-card">
                <h5>Asset Inventory Reports</h5>
                <i class="fa-solid fa-download"></i>
            </div>
            <div class="report-card">
                <h5>Asset Inventory Reports</h5>
                <i class="fa-solid fa-download"></i>
            </div>
            <div class="report-card">
                <h5>Asset Inventory Reports</h5>
                <i class="fa-solid fa-download"></i>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
