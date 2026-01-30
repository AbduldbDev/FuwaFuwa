@extends('Layout.app')

@section('content')
    <div id="settings" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>System Configuration</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- company information -->
        <div class="company-info my-4">
            <h4 class="mb-1">Company Information</h4>
            <p class="subtitle">Update your company details and branding</p>

            <form id="companyForm" action="{{ route('system-configuration.updateOrCreate') }}" method="POST">
                @csrf
                <!-- company name -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Company Name</label>
                        <input type="text" class="form-control" id="companyName"
                            value="{{ $CompanyProfile->company_name ?? '' }}" required name="company_name" />
                    </div>

                    <!-- brand name -->
                    <div class="col-md-6">
                        <label>Brand Name</label>
                        <input type="text" class="form-control" id="brandName"
                            value="{{ $CompanyProfile->brand_name ?? '' }}" required name="brand_name" />
                    </div>
                </div>

                <!-- contact email -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>Contact Email</label>
                        <input type="email" class="form-control" id="email"
                            value="{{ $CompanyProfile->contact_email ?? '' }}" required name="contact_email" />
                    </div>

                    <!-- contact phone -->
                    <div class="col-md-6">
                        <label>Contact Phone</label>
                        <input type="tel" class="form-control" id="phone"
                            value="{{ $CompanyProfile->contact_phone ?? '' }}" required name="contact_phone" />
                    </div>
                </div>

                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>

        <!-- asset management settings -->
        <div class="company-info my-4">
            <h4 class="mb-1">Asset Management Settings</h4>
            <p class="subtitle">
                Configure asset tracking and depression settings
            </p>

            <!-- asset tag and depreciation -->
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Asset Tag Prefix</label>
                    <input type="text" value="NPB" class="form-control" readonly />
                </div>

                <div class="col-md-6 form-group">
                    <label>Depreciation Method</label>
                    <input type="text" value="Written-Down Value (WDV)" class="form-control" disabled />
                </div>
            </div>

            <!-- auto generate -->
            <div class="setting-row">
                <div class="setting-text">
                    <h4>Auto-generate Asset Tags</h4>
                    <p>Automatically generate asset tags when adding new assets</p>
                </div>
                <label class="switch">
                    <input type="checkbox" checked onclick="this.blur()" />
                    <span class="slider"></span>
                </label>
            </div>

            <!-- warranty alerts -->
            <div class="setting-row">
                <div class="setting-text">
                    <h4>Warranty Expiry Alerts</h4>
                    <p>Send notifications for assets with expiring warranties</p>
                </div>
                <label class="switch">
                    <input type="checkbox" checked onclick="this.blur()" />
                    <span class="slider"></span>
                </label>
            </div>

            <!-- maintenance reminders -->
            <div class="setting-row">
                <div class="setting-text">
                    <h4>Maintenance Reminders</h4>
                    <p>Enable automatic maintenance scheduling reminders</p>
                </div>
                <label class="switch">
                    <input type="checkbox" checked onclick="this.blur()" />
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <!-- notification preference -->
        <div class="company-info my-4">
            <h4 class="mb-1">Notification Preferences</h4>
            <p class="subtitle">
                Configure how you receive system notifications
            </p>

            <!-- email notifications -->
            <div class="setting-row">
                <div class="setting-text">
                    <h4>Email Notifications</h4>
                    <p>Receive important updated via email</p>
                </div>
                <label class="switch">
                    <input type="checkbox" checked onclick="this.blur()" />
                    <span class="slider"></span>
                </label>
            </div>

            <!-- asset assignment alerts -->
            <div class="setting-row">
                <div class="setting-text">
                    <h4>Asset Assignment Alerts</h4>
                    <p>Get notified when assets are assigned or unassigned</p>
                </div>
                <label class="switch">
                    <input type="checkbox" checked onclick="this.blur()" />
                    <span class="slider"></span>
                </label>
            </div>

            <!-- report generation alerts -->
            <div class="setting-row">
                <div class="setting-text">
                    <h4>Report Generation Alerts</h4>
                    <p>Notify when scheduled reports are ready</p>
                </div>
                <label class="switch">
                    <input type="checkbox" checked onclick="this.blur()" />
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <!-- user management settings -->
        <div class="company-info my-4">
            <h4 class="mb-1">User Management Settings</h4>
            <p class="subtitle">Access control and user role configurations</p>

            <!-- admin -->
            <div class="role-header">ADMIN</div>
            <!-- table -->
            <div class="table-responsive mb-5">
                <table class="table permission-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50%">Module</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- modules -->
                        <tr>
                            <td>Dashboard</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none active">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write">Read/Write</button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Assets</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>User Management</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Maintenance & Repair</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read active">Read</button>
                                    <button class="perm-btn write">Read/Write</button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Reports & Analytics</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>System Configuration</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- encoder -->
            <div class="role-header">ENCODER</div>
            <!-- table -->
            <div class="table-responsive mb-5">
                <table class="table permission-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50%">Module</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- modules -->
                        <tr>
                            <td>Dashboard</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none active">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write">Read/Write</button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Assets</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>User Management</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Maintenance & Repair</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read active">Read</button>
                                    <button class="perm-btn write">Read/Write</button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Reports & Analytics</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>System Configuration</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- viewer -->
            <div class="role-header">VIEWER</div>
            <!-- table -->
            <div class="table-responsive mb-5">
                <table class="table permission-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50%">Module</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- modules -->
                        <tr>
                            <td>Dashboard</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none active">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write">Read/Write</button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Assets</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>User Management</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Maintenance & Repair</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read active">Read</button>
                                    <button class="perm-btn write">Read/Write</button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Reports & Analytics</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>System Configuration</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <button class="perm-btn none">None</button>
                                    <button class="perm-btn read">Read</button>
                                    <button class="perm-btn write active">
                                        Read/Write
                                    </button>
                                    <button class="perm-btn custom">Custom</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
