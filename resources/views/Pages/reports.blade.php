@extends('Layout.app')

@section('content')
    <div id="reports" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Reports & Analytics</h2>
            <div class="group-box">
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#customReport">
                    <i class="fa-solid fa-plus"></i>
                    Custom Report
                </button>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #1E40AF; background: #E0E7FF;">
                            <i class="fas fa-file-circle-check"></i>
                        </div>
                        <div>
                            <h2>20</h2>
                            <h6>Reports Generate This Month</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #6D28D9; background: #EDE9FE;">
                            <i class="fas fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h2>Jan. 31, 2026</h2>
                            <h6>Last Generated Report</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #166534; background: #DCFCE7;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h2>6</h2>
                            <h6>Scheduled Monthly Reports</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #92400E; background: #FFEDD5;">
                            <i class="fas fa-sliders"></i>
                        </div>
                        <div>
                            <h2>12,091,209</h2>
                            <h6>Custom Reports Created</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- available reports -->
        <div class="report-container">
            <!-- header -->
            <div class="report-control">
                <h3>Available Reports</h3>

                <!-- filters -->
                <div class="filters">
                    <!-- time range filter -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="timeRangeFilter">
                        <option value="today">All Reports</option>
                        <option value="7days">Custom Reports</option>
                        <option value="30days">Scheduled Reports</option>
                    </select>

                    <!-- asset status -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="Active">Active</option>
                        <option value="In Use">In Use</option>
                        <option value="Under Maintenance">
                            Under Maintenance
                        </option>
                    </select>

                    <div class="date-range-filter">
                        <label>Date Range</label>
                        <input type="month">
                    </div>
                </div>

            </div>

            @foreach ($reports as $item)
                <div class="report-card mb-1">
                    <div class="report-info">
                        <!-- icon -->
                        <div class="report-icon">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>

                        <!-- report name and date -->
                        <div>
                            <h5>{{ $item->name }}</h5>
                            <p>Generated {{ $item->created_at->format('M d, Y') }} • Excel</p>
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="report-actions">
                        @if ($item->file_path)
                            <a href="{{ route('reports-analytics.download', $item->id) }}" class="download btn btn-sm btn-primary">
                                <i class="fa fa-download"></i> Download
                            </a>
                        @else
                            <button class="download btn btn-sm btn-secondary" disabled>
                                <i class="fa fa-download"></i> Not Available
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>

        <!-- create custom reports -->
        <div class="modal fade" id="customReport" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content add-user-modal">
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">
                            <i class="fa-solid fa-file-circle-plus me-2"></i>
                            Create Custom Report
                        </h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body px-4">
                        <!-- report information -->
                        <section>
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <i class="fa-regular fa-file-lines"></i>
                                <h6>Report Information</h6>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">
                                        Report Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" />
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">
                                        Detailed Purpose <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" rows="4" placeholder="Enter detailed purpose..." required></textarea>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label text-muted">
                                        Start Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" required />
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label text-muted">
                                        End Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Report Type</label>
                                    <select class="form-select" id="reportType">
                                        <option value="" disabled selected>Select report type</option>
                                        <option value="assets-checklist">Assets</option>
                                        <option value="request-checklist">Asset Requests</option>
                                        <option value="archive-checklist">Asset Archive</option>
                                        <option value="maintenance-checklist">Asset Maintenance</option>
                                        <option value="user-checklist">User Management</option>
                                        <option value="vendor-checklist">Vendor Management</option>
                                    </select>
                                </div>

                                <!-- ASSET CHECKLISTS -->
                                <div class="checklist-wrapper" id="assets-checklist">
                                    <div class="row">

                                        <!-- Asset Detail -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Asset Details</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Asset Type</label>
                                                <label><input type="checkbox" class="child-check"> Asset Category</label>
                                                <label><input type="checkbox" class="child-check"> Asset Tag</label>
                                                <label><input type="checkbox" class="child-check"> Asset Name</label>
                                                <label><input type="checkbox" class="child-check"> Technical
                                                    Specifications</label>
                                            </div>
                                        </div>

                                        <!-- Operational Status -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Operational Status</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Active</label>
                                                <label><input type="checkbox" class="child-check"> In Stock</label>
                                                <label><input type="checkbox" class="child-check"> Under
                                                    Maintenance</label>
                                                <label><input type="checkbox" class="child-check"> Retired</label>
                                            </div>
                                        </div>

                                        <!-- Compliance Status -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Compliance Status</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Compliant</label>
                                                <label><input type="checkbox" class="child-check"> Non-compliant</label>
                                            </div>
                                        </div>

                                        <!-- Assignment and Location -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Assignment and Location</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Assigned User</label>
                                                <label><input type="checkbox" class="child-check"> Department</label>
                                                <label><input type="checkbox" class="child-check"> Location</label>
                                            </div>
                                        </div>

                                        <!-- Purchase Information -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Purchase Information</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Purchase Request
                                                    ID</label>
                                                <label><input type="checkbox" class="child-check"> Vendor</label>
                                                <label><input type="checkbox" class="child-check"> Purchase Date</label>
                                                <label><input type="checkbox" class="child-check"> Purchase Cost</label>
                                            </div>
                                        </div>

                                        <!-- Depreciation Insights -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Depreciation Insights</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Purchase Year</label>
                                                <label><input type="checkbox" class="child-check"> Useful Life
                                                    (remaining)</label>
                                                <label><input type="checkbox" class="child-check"> Years Used</label>
                                                <label><input type="checkbox" class="child-check"> Salvage Value</label>
                                                <label><input type="checkbox" class="child-check"> Depreciation
                                                    Rate</label>
                                                <label><input type="checkbox" class="child-check"> Accumulated
                                                    Depreciation</label>
                                                <label><input type="checkbox" class="child-check"> Asset Value</label>
                                            </div>
                                        </div>

                                        <!-- Maintenance and Audit -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Maintenance and Audit</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Maintenance
                                                    Type</label>
                                                <label><input type="checkbox" class="child-check"> Warranty Start
                                                    Date</label>
                                                <label><input type="checkbox" class="child-check"> Warranty End
                                                    Date</label>
                                                <label><input type="checkbox" class="child-check"> Last Maintenance
                                                    Date</label>
                                                <label><input type="checkbox" class="child-check"> License Activation
                                                    Date</label>
                                                <label><input type="checkbox" class="child-check"> License Expiration
                                                    Date</label>
                                                <label><input type="checkbox" class="child-check"> Assigned
                                                    Technician</label>
                                                <label><input type="checkbox" class="child-check"> Maintenance
                                                    Frequency</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- ASSET REQUEST CHECKLISTS -->
                                <div class="checklist-wrapper" id="request-checklist">
                                    <div class="row">

                                        <!-- Requester Information -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Requester Information</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Requested by</label>
                                                <label><input type="checkbox" class="child-check"> Department</label>
                                            </div>
                                        </div>

                                        <!-- Asset Specification -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Asset Specification</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Asset Type</label>
                                                <label><input type="checkbox" class="child-check"> Asset Category</label>
                                                <label><input type="checkbox" class="child-check"> Quantity</label>
                                                <label><input type="checkbox" class="child-check"> Model</label>
                                            </div>
                                        </div>

                                        <!-- Justification -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Justification</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Reason for
                                                    Request</label>
                                                <label><input type="checkbox" class="child-check"> Detailed
                                                    Purpose</label>
                                            </div>
                                        </div>

                                        <!-- Asset Request Status -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Asset Request Status</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> For Review</label>
                                                <label><input type="checkbox" class="child-check"> In Progress</label>
                                                <label><input type="checkbox" class="child-check"> For Procurement</label>
                                                <label><input type="checkbox" class="child-check"> For Release</label>
                                                <label><input type="checkbox" class="child-check"> Closed</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ASSET ARCHIVE CHECKLISTS -->
                                <div class="checklist-wrapper" id="archive-checklist">
                                    <div class="row">

                                        <!-- Archived Details -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Archived Details</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Asset Tag</label>
                                                <label><input type="checkbox" class="child-check"> Status</label>
                                                <label><input type="checkbox" class="child-check"> Reason for
                                                    Archival</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ASSET MAINTENANCE CHECKLISTS -->
                                <div class="checklist-wrapper" id="maintenance-checklist">
                                    <div class="row">

                                        <!-- Maintenance Information -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Maintenance Information</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Maintenance
                                                    Type</label>
                                                <label><input type="checkbox" class="child-check"> Reported By</label>
                                                <label><input type="checkbox" class="child-check"> Department</label>
                                                <label><input type="checkbox" class="child-check"> Detailed
                                                    Description</label>
                                                <label><input type="checkbox" class="child-check"> Attach Document</label>
                                                <label><input type="checkbox" class="child-check"> Asset/s</label>
                                                <label><input type="checkbox" class="child-check"> Issue/Task
                                                    Description</label>
                                                <label><input type="checkbox" class="child-check"> Assigned
                                                    Technician</label>
                                                <label><input type="checkbox" class="child-check"> Scheduled Date</label>
                                                <label><input type="checkbox" class="child-check"> Maintenance
                                                    Frequency</label>
                                            </div>
                                        </div>

                                        <!-- Activity Feed -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Maintenance Information</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Action Taken</label>
                                                <label><input type="checkbox" class="child-check"> Part/s Replaced</label>
                                                <label><input type="checkbox" class="child-check"> Technician
                                                    Notes</label>
                                                <label><input type="checkbox" class="child-check"> Start Date</label>
                                                <label><input type="checkbox" class="child-check"> Completion Date</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- USER MANAGEMENT CHECKLISTS -->
                                <div class="checklist-wrapper" id="user-checklist">
                                    <div class="row">

                                        <!-- User Details -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>User Details</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Employee ID</label>
                                                <label><input type="checkbox" class="child-check"> Department</label>
                                                <label><input type="checkbox" class="child-check"> User Role</label>
                                                <label><input type="checkbox" class="child-check"> Full Name</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- VENDOR MANAGEMENT CHECKLISTS -->
                                <div class="checklist-wrapper" id="vendor-checklist">
                                    <div class="row">

                                        <!-- Vendor Details -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Vendor Details</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Vendor Name</label>
                                                <label><input type="checkbox" class="child-check"> Contact Person</label>
                                                <label><input type="checkbox" class="child-check"> Contact Email</label>
                                                <label><input type="checkbox" class="child-check"> Contact Number</label>
                                                <label><input type="checkbox" class="child-check"> Category</label>
                                                <label><input type="checkbox" class="child-check"> Status</label>
                                            </div>
                                        </div>

                                        <!-- Compliance Document/s -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Compliance Document/s</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Document Name</label>
                                                <label><input type="checkbox" class="child-check"> Attached File</label>
                                                <label><input type="checkbox" class="child-check"> Expiration Date</label>
                                            </div>
                                        </div>

                                        <!-- Purchase History Log -->
                                        <div class="col-md-6 mb-3">
                                            <div class="checklist-header">
                                                <label class="header-check">
                                                    <input type="checkbox" class="check-all">
                                                    <span>Purchase History Log</span>
                                                </label>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>

                                            <div class="checklist-items">
                                                <label><input type="checkbox" class="child-check"> Asset Tag</label>
                                                <label><input type="checkbox" class="child-check"> Asset Name</label>
                                                <label><input type="checkbox" class="child-check"> Quantity</label>
                                                <label><input type="checkbox" class="child-check"> Cost</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>

                    </div>

                    <!-- modal footer -->
                    <div class="modal-footer d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <label style="font-size: 12px;">File</label>
                            <select class="form-select" style="font-size: 12px;">
                                <option value="pdf">Portable Document Format (PDF)</option>
                                <option value="xlsx">Microsoft Excel Workbook (XLSX)</option>
                                <option value="csv">Comma-Separated Values (CSV)</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-success px-4">
                                Submit
                            </button>
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
