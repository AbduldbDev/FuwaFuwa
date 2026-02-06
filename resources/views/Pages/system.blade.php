@extends('Layout.app')

@section('content')
    <div id="settings" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>System Configuration</h2>
            <div class="group-box">

                <x-notification-dropdown />
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
            <form id="companyForm" action="{{ route('system-configuration.saveSettings') }}" method="POST">
                @csrf

                <h4 class="mb-1">Asset Management Settings</h4>
                <p class="subtitle">
                    Configure asset tracking and notification settings
                </p>

                <!-- asset tag and depreciation -->
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Physical Tag Prefix</label>
                        <input type="text" value="{{ $settings->physical_tag_prefix ?? '' }}" class="form-control"
                            name="physical_tag_prefix" />
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Digital Tag Prefix</label>
                        <input type="text" value="{{ $settings->digital_tag_prefix ?? '' }}" class="form-control"
                            name="digital_tag_prefix" />
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h4>Warranty Expiry Alerts</h4>
                        <p>Send notifications for assets with expiring warranties</p>
                    </div>
                    <label class="switch">
                        <input type="hidden" name="warranty_expiry_alerts" value="0">
                        <input type="checkbox" name="warranty_expiry_alerts" value="1"
                            {{ old('warranty_expiry_alerts', $settings->warranty_expiry_alerts ?? 0) ? 'checked' : '' }}
                            onclick="this.blur()">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h4>Maintenance Reminders</h4>
                        <p>Enable automatic maintenance scheduling reminders</p>
                    </div>
                    <label class="switch">
                        <input type="hidden" name="maintenance_reminders" value="0">
                        <input type="checkbox" name="maintenance_reminders" value="1"
                            {{ old('maintenance_reminders', $settings->maintenance_reminders ?? 0) ? 'checked' : '' }}
                            onclick="this.blur()">
                        <span class="slider"></span>
                    </label>

                </div>

                <div class="setting-row">
                    <div class="setting-text">
                        <h4>Asset Assignment Alerts</h4>
                        <p>Get notified when assets are assigned or unassigned</p>
                    </div>
                    <label class="switch">
                        <input type="hidden" name="asset_assignment_alerts" value="0">
                        <input type="checkbox" name="asset_assignment_alerts" value="1"
                            {{ old('asset_assignment_alerts', $settings->asset_assignment_alerts ?? 0) ? 'checked' : '' }}
                            onclick="this.blur()">
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
                        <input type="hidden" name="report_generation" value="0">
                        <input type="checkbox" name="report_generation" value="1"
                            {{ old('report_generation', $settings->report_generation ?? 0) ? 'checked' : '' }}
                            onclick="this.blur()">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="text-end">
                    <button type="submit" class=" mt-4 save-btn">Save Configuration</button>
                </div>
            </form>
        </div>

        <!-- user management settings -->
        <div class="company-info my-4">
            <h4 class="mb-1">User Management Settings</h4>
            <p class="subtitle">Access control and user role configurations</p>

            <form action="{{ route('system-configuration.saveRole') }}" method="POST">
                @csrf

                @foreach ($roles as $role)
                    <div class="role-header text-uppercase">{{ $role }}</div>
                    <div class="table-responsive mb-5">
                        <table class="table permission-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50%">Module</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                    @php
                                        $savedAccess = $permissions[$role][$module] ?? 'none';
                                    @endphp
                                    <tr>
                                        <td>{{ $module }}</td>
                                        <td>
                                            <div class="btn-group gap-2">
                                                @foreach ($accessTypes as $key => $label)
                                                    <input type="radio"
                                                        id="{{ $role }}_{{ $module }}_{{ $key }}"
                                                        name="permissions[{{ $role }}][{{ $module }}]"
                                                        value="{{ $key }}"
                                                        @if ($savedAccess === $key) checked @endif
                                                        style="display:none;">
                                                    <label class="perm-btn {{ $key }}"
                                                        for="{{ $role }}_{{ $module }}_{{ $key }}">
                                                        {{ $label }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class="text-end">
                    <button type="submit" class=" save-btn">Save Permissions</button>
                </div>
            </form>
        </div>

        <script>
            document.querySelectorAll('.btn-group').forEach(group => {
                const checkedInput = group.querySelector('input:checked');
                if (checkedInput) {
                    const label = group.querySelector(`label[for="${checkedInput.id}"]`);
                    label.classList.add('active');
                }
            });

            document.querySelectorAll('.perm-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const parent = btn.closest('.btn-group');
                    parent.querySelectorAll('.perm-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                });
            });
        </script>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
