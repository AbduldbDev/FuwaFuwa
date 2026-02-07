<div class="modal fade" id="assetModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <!-- modal header -->
            <form action="{{ route('assets.store') }}" method="POST" id="assetForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <i class="fa-solid fa-square-plus me-2"></i>
                    <h5 class="modal-title fw-semibold">ADD NEW ASSET</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>

                <!-- modal body -->
                <div class="modal-body px-4">

                    <!-- ===== Basic Information ===== -->
                    <div id="slide2" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-regular fa-user"></i>
                            <h6>Basic Information</h6>
                        </div>
                        <input type="hidden" name="AssetRequestId" id="AssetRequestId">

                        <div class="mb-3">
                            <label class="form-label">Asset Name <span class="text-danger">*</span></label>
                            <input type="text" id="assetName" class="form-control" name="asset_name" required />
                            <input type="hidden" id="assetQuantity" name="assetQuantity">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asset Type <span class="text-danger">*</span></label>
                            <input type="text" id="summaryCategory" class="form-control" name="asset_type"
                                readonly />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asset Category <span class="text-danger">*</span></label>
                            <input type="text" id="summaryType" class="form-control" name="asset_category"
                                readonly />
                        </div>

                        <div class="mb-3" style="display: none">
                            <label class="form-label">Operational Status <span class="text-danger">*</span></label>
                            <select id="operationalStatus" class="form-select" name="operational_status" required>
                                <option value="">Select status</option>
                            </select>
                        </div>
                    </div>

                    <!-- ===== Technical Specifications ===== -->
                    <div id="slide3" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders"></i>
                            <h6>Technical Specifications</h6>
                        </div>

                        <!-- PC / Laptop -->
                        <div class="tech-group" data-type="PC Laptop">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Processor
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Processor]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RAM
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[RAM]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Storage
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Storage]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Operating System
                                </label>
                                <input type="text" class="form-control required-field"
                                    name="specs[Operating_System]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Serial Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Serial_Number]" />
                            </div>
                        </div>

                        <!-- Router -->
                        <div class="tech-group" data-type="Router">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Network Role
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Network_Role]">
                                    <option value="">Select Network Role</option>
                                    <option value="Core">Core</option>
                                    <option value="Edge (Gateway)">Edge (Gateway)</option>
                                    <option value="Branch / Remote Office">Branch / Remote Office</option>
                                    <option value="Distribution">Distribution</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Firmware Version
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Firmware_Version]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Routing Protocols
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Routing_Protocols]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">WAN / LAN Ports
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[WAN/LAN_Ports]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Throughput Capacity
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Throughout_Capacity]" />
                            </div>
                        </div>

                        <!-- Firewall -->
                        <div class="tech-group" data-type="Firewall">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cabinet Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Cabinet_Type]">
                                    <option value="">Select Cabinet Type</option>
                                    <option>Wall Mount</option>
                                    <option>Free Standing</option>
                                    <option>Outdoor / Rugged</option>
                                    <option>Acoustic (Soundproof)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rack Units
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Rack_Units]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cooling Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Cooling_Type]">
                                    <option value="">Select Cooling Type</option>
                                    <option value="Passive (Vented)">Passive (Vented)</option>
                                    <option value="Active (Fan Kits)">Active (Fan Kits)</option>
                                    <option value="Precision AC">Precision AC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IDS / IPS Support
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[IDS/IPS_Support]">
                                    <option value="">Select IDS/IPS Support</option>
                                    <option value="Enabled">Enabled</option>
                                    <option value="Disabled">Disabled</option>
                                    <option value="Not Supported">Not Supported</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Throughput Capacity
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Throughput_Capacity]" />
                            </div>
                        </div>

                        <!-- Switch -->
                        <div class="tech-group" data-type="Switch">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Number of Ports
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control required-field" data-required="true"
                                    name="specs[Number_of_Ports]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">VLAN Configuration
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[VLAN_Configuration]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Switch Role
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Switch_Role]">
                                    <option value="">Select Switch Role</option>
                                    <option value="Access (End Device)">Access (End Device)</option>
                                    <option value="Distribution">Distribution</option>
                                    <option value="Core">Core</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Port Speed
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Port_Speed]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PoE Support
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[PoE_Support]">
                                    <option value="">Select PoE Support</option>
                                    <option value="No PoE">No PoE</option>
                                    <option value="PoE (802.3af)">PoE (802.3af)</option>
                                    <option value="PoE+ (802.3at)">PoE+ (802.3at)</option>
                                    <option value="UPOE / PoE++ (802.3bt)">UPOE / PoE++ (802.3bt)</option>
                                </select>
                            </div>
                        </div>

                        <!-- License -->
                        <div class="tech-group" data-type="License">
                            <div class="mb-3">
                                <label class="form-label">License Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[License_Name]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">License Edition
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[License_Edition]">
                                    <option value="">Select License Edition</option>
                                    <option value="Basic / Starter">Basic / Starter</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Professional">Professional</option>
                                    <option value="Enterprise">Enterprise</option>
                                    <option value="Ultimate / Premium">Ultimate / Premium</option>
                                    <option value="Academic / Education">Academic / Education</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">License Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[License_Type]">
                                    <option value="">Select License Type</option>
                                    <option value="Volume">Volume</option>
                                    <option value="Individual">Individual</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subscription Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Subscription_Type]">
                                    <option value="">Select Subscription Type</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Annual">Annual</option>
                                    <option value="Annual">Perpetual</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Number of Seats
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control required-field" data-required="true"
                                    name="specs[Number_of_seats]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">License Key
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[License_Key]" />
                            </div>
                        </div>

                        <!-- Modem -->
                        <div class="tech-group" data-type="Modem">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[asset_model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ISP Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[ISP_Name]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Connection Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Connection_Type]">
                                    <option value="">Select Connection Type</option>
                                    <option value="Fiber Optic (GPON)">Fiber Optic (GPON)</option>
                                    <option value="DSL (ADSL / VDSL)">DSL (ADSL / VDSL)</option>
                                    <option value="Cable (DOCSIS)">Cable (DOCSIS)</option>
                                    <option value="Satellite">Satellite</option>
                                    <option value="LTE / 5G Wireless">LTE / 5G Wireless</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Speed Rating
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Speed_Rating]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Serial Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Serial_Number]" />
                            </div>
                        </div>

                        <!-- Communication Cabinet -->
                        <div class="tech-group" data-type="Communication Cabinet">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[asset_model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cabinet Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[cabinet_type]">
                                    <option value="">Select Cabinet Type</option>
                                    <option value="Wall Mount">Wall Mount</option>
                                    <option value="Free Standing">Free Standing</option>
                                    <option value="Outdoor / Rugged">Outdoor / Rugged</option>
                                    <option value="Acoustic (Soundproof)">Acoustic (Soundproof)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rack Units
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[rack_units]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cooling Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[cooling_type]">
                                    <option value="">Select Cooling Type</option>
                                    <option value="Passive (Vented)">Passive (Vented)</option>
                                    <option value="Active (Fan Kits)">Active (Fan Kits)</option>
                                    <option value="Precision AC">Precision AC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Power Capacity (Amps / Watts)
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Power_Capacity]" />
                            </div>
                        </div>

                        <!-- Server Cabinet -->
                        <div class="tech-group" data-type="Server Cabinet">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[asset_model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rack Units
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[rack_units]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cooling System
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[cooling_system]">
                                    <option value="">Select Cooling System</option>
                                    <option value="Perforated Doors (Airflow)">Perforated Doors (Airflow)</option>
                                    <option value="In-Row Cooling">In-Row Cooling</option>
                                    <option value="Rear Door Heat Exchanger">Rear Door Heat Exchanger</option>
                                    <option value="Liquid Cooled">Liquid Cooled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PDU Details
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[PDU_Details]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Weight Capacity
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Weight_Capacity]" />
                            </div>
                        </div>
                    </div>

                    <!-- ===== Assignment & Location ===== -->
                    <div id="slide4" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <h6>Assignment & Location</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assigned To</label>
                            <input type="text" class="form-control required-field" name="assigned_to" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department">
                                <option value="">Select department</option>
                                <option>IT Department</option>
                                <option>HR Department</option>
                                <option>Finance Department</option>
                                <option>Operations</option>
                                <option>Admin</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location">
                                <option value="">Select location</option>
                                <option>Main Office</option>
                                <option>Warehouse</option>
                            </select>
                        </div>
                    </div>

                    <!-- ===== Purchase Information ===== -->
                    <div id="slide5" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <h6>Purchase Information</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <select class="form-select" name="vendor_id" onchange="handleVendorChange(this)">
                                <option value="">Select vendor</option>
                                @foreach ($vendors as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <option value="__add_vendor__"> Add New Vendor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control required-field" data-required="true"
                                name="purchase_date" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Cost <span class="text-danger">*</span></label>
                            <input type="number" class="form-control required-field" data-required="true"
                                name="purchase_cost" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Useful Life (Years)</label>
                            <input type="number" class="form-control required-field" name="useful_life_years" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salvage Value</label>
                            <input type="number" class="form-control required-field" name="salvage_value" />
                        </div>
                    </div>

                    <!-- ===== Maintenance & Audit ===== -->
                    <div id="slide6" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-tools"></i>
                            <h6>Maintenance & Audit</h6>
                        </div>
 
                        <div class="mb-3" style="display: none">
                            <label class="form-label">Compliance Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="compliance_status">
                                <option value="">Select status</option>
                                <option>Compliant</option>
                                <option>Non-Compliant</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><span id="warranty_start_date">Warranty Start Date</span> <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control required-field" name="warranty_start"
                                data-required="true" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><span id="warranty_end_date">Warranty End Date</span> <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control required-field" name="warranty_end"
                                data-required="true" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" id="last_schedule_maintenance">Last Scheduled
                                Maintenance </label>
                            <input type="date" class="form-control required-field" name="last_maintenance" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" id="next_schedule_maintenance">Next Schedule
                                Maintenance </label>
                            <input type="date" class="form-control required-field" name="next_maintenance" />
                        </div>
                    </div>

                    <div id="slide7" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file"></i>
                            <h6>Documents</h6>
                        </div>

                        <div class="row align-items-end">
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">
                                    Document Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="docName">
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label">
                                    Attach File <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control" id="docFile">
                            </div>

                            <button type="button" class="col-lg-4 mb-3 h-100 p-2 btn  btn-sm save-btn "
                                onclick="addDocument()">
                                + Add Document
                            </button>

                        </div>

                        <div class="mb-5 table-responsive">
                            <table class="table align-middle mb-0 doc-table">
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Attached File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="docTableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn btn-secondary" onclick="prevSlide()">
                        Back
                    </button>
                    <button type="button" class="next-btn" onclick="nextSlide()">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleVendorChange(select) {
        if (select.value === '__add_vendor__') {
            window.location.href = "/vendors";
        }
    }

    let selectedCategory = "";
    let selectedType = "";
    let currentSlide = 2;

    function addDocument() {
        const name = document.getElementById("docName").value;
        const fileInput = document.getElementById("docFile");

        if (!name || !fileInput.files.length) {
            alert("Please complete all document fields.");
            return;
        }

        const file = fileInput.files[0];
        const table = document.getElementById("docTableBody");

        // Generate a unique identifier for this document row
        const docId =
            "doc_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9);

        const row = document.createElement("tr");
        row.setAttribute("data-doc-id", docId);
        row.innerHTML = `
        <td>${name}</td>
        <td>
            <span class="file-name">${file.name}</span>
            <input type="hidden" name="documents[name][]" value="${name}">
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeDocument('${docId}')">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    `;

        table.appendChild(row);

        const fileClone = fileInput.cloneNode(true);
        fileClone.name = "documents[file][]";
        fileClone.id = "";
        fileClone.style.display = "none";
        fileClone.removeAttribute("onchange");

        document.getElementById("assetForm").appendChild(fileClone);
        fileInput.value = "";
        document.getElementById("docName").value = "";
    }

    // Optional: Add remove document function
    function removeDocument(docId) {
        const row = document.querySelector(`tr[data-doc-id="${docId}"]`);
        if (row) {
            row.remove();
        }
    }

    const assetTypes = {
        "Physical Asset": [
            "PC",
            "Laptop",
            "Router",
            "Firewall",
            "Switch",
            "Modem",
            "Communication Cabinet",
            "Server Cabinet",
        ],
        "Digital Asset": ["License"],
    };

    const operationalStatusOptions = {
        "Physical Asset": ["Active", "In Stock", "Under Maintenance"],
        "Digital Asset": ["Active", "Inactive", "Expired"],
    };

    // ===============================
    // ASSET TYPES INFO DISPLAY
    // ===============================
    function displayAssetTypesInfo() {
        const container = document.getElementById('assetTypesInfo');
        if (!container) return;

        container.innerHTML = '';

        // Create title
        const title = document.createElement('h6');
        title.className = 'mb-3';
        title.style.fontSize = '14px';
        title.style.fontWeight = '600';
        title.style.color = '#495057';
        title.textContent = 'Available Asset Types & Categories:';
        container.appendChild(title);

        // Add asset types list
        for (const [type, categories] of Object.entries(assetTypes)) {
            const typeDiv = document.createElement('div');
            typeDiv.className = 'asset-type-item';

            const typeName = document.createElement('strong');
            typeName.textContent = type + ': ';
            typeDiv.appendChild(typeName);

            const categoriesList = document.createElement('span');
            categoriesList.textContent = categories.join(', ');
            typeDiv.appendChild(categoriesList);

            container.appendChild(typeDiv);
        }

        // Add operational status info
        const statusDiv = document.createElement('div');
        statusDiv.className = 'status-options';

        const statusTitle = document.createElement('h6');
        statusTitle.textContent = 'Operational Status Options:';
        statusDiv.appendChild(statusTitle);

        for (const [type, statuses] of Object.entries(operationalStatusOptions)) {
            const statusItem = document.createElement('div');
            statusItem.className = 'ms-2 mt-2';

            const typeSpan = document.createElement('span');
            typeSpan.style.fontStyle = 'italic';
            typeSpan.textContent = type + ': ';
            statusItem.appendChild(typeSpan);

            const statusSpan = document.createElement('span');
            statusSpan.textContent = statuses.join(', ');
            statusItem.appendChild(statusSpan);

            statusDiv.appendChild(statusItem);
        }

        container.appendChild(statusDiv);
    }

    // ===============================
    // POPULATE OPERATIONAL STATUS
    // ===============================
    function populateOperationalStatus() {
        const statusSelect = document.getElementById("operationalStatus");
        if (!statusSelect) return;

        statusSelect.innerHTML = '<option value="">Select status</option>';

        if (selectedCategory && operationalStatusOptions[selectedCategory]) {
            operationalStatusOptions[selectedCategory].forEach((status) => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = status;
                statusSelect.appendChild(option);
            });
        } else {
            const allStatuses = [...new Set(Object.values(operationalStatusOptions).flat())];
            allStatuses.forEach((status) => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = status;
                statusSelect.appendChild(option);
            });
        }
    }

    // ===============================
    // TECHNICAL SPECIFICATIONS
    // ===============================
    // Update the showTechnicalFields() function to populate asset name into appropriate fields
    function showTechnicalFields() {
        // Hide all tech groups first
        document.querySelectorAll(".tech-group").forEach((group) => {
            group.style.display = "none";
            // Disable all fields in hidden groups
            group.querySelectorAll("input, select, textarea").forEach((input) => {
                input.disabled = true;
            });
        });

        // Determine which tech group to show
        let targetType = selectedType;
        if (selectedType === "PC" || selectedType === "Laptop") {
            targetType = "PC Laptop";
        }

        const techGroup = document.querySelector(`.tech-group[data-type="${targetType}"]`);
        if (techGroup) {
            techGroup.style.display = "block";
            // Enable all fields in visible group
            techGroup.querySelectorAll("input, select, textarea").forEach((input) => {
                input.disabled = false;
            });
        }
    }


    function populateAssetNameToField(assetName) {
        if (!assetName) return;

        // For Physical Assets: populate into Asset_Model field
        if (selectedCategory === 'Physical Asset') {
            const assetModelFields = document.querySelectorAll(
                'input[name="specs[Asset_Model]"], input[name="specs[asset_model]"]');
            assetModelFields.forEach(field => {
                if (field && !field.value && field.closest('.tech-group').style.display !== 'none') {
                    field.value = assetName;
                }
            });
        }
        // For Digital Assets (License): populate into License_Name field
        else if (selectedCategory === 'Digital Asset') {
            const licenseNameField = document.querySelector('input[name="specs[License_Name]"]');
            if (licenseNameField && !licenseNameField.value && licenseNameField.closest('.tech-group').style.display !==
                'none') {
                licenseNameField.value = assetName;
            }
        }
    }

    // ===============================
    // VALIDATION FUNCTIONS
    // ===============================
    function showError(field, message) {
        const existingError = field.nextElementSibling;
        if (existingError && existingError.classList.contains('error-message')) {
            existingError.remove();
        }

        const errorMsg = document.createElement('div');
        errorMsg.className = 'error-message';
        errorMsg.textContent = message;
        field.parentNode.insertBefore(errorMsg, field.nextSibling);
    }

    function validateCurrentSlide() {
        const currentSlideElement = document.getElementById(`slide${currentSlide}`);
        if (!currentSlideElement) return false;

        let isValid = true;

        currentSlideElement.querySelectorAll('[data-required="true"], [required]').forEach(field => {
            field.classList.remove('error');
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        });

        if (currentSlide === 2) {
            const assetName = document.querySelector('#slide2 input[name="asset_name"]');
            const operationalStatus = document.querySelector('#slide2 select[name="operational_status"]');

            if (!assetName.value.trim()) {
                assetName.classList.add('error');
                showError(assetName, 'Asset Name is required');
                isValid = false;
                assetName.focus();
            }

            return isValid;
        }

        if (currentSlide === 3) {
            // Validate technical fields (including Asset_Model or License_Name)
            if (selectedType && selectedCategory) {
                let targetType = selectedType;
                if (selectedType === "PC" || selectedType === "Laptop") {
                    targetType = "PC Laptop";
                }

                const techGroup = document.querySelector(`.tech-group[data-type="${targetType}"]`);
                if (techGroup) {
                    const visibleRequiredFields = techGroup.querySelectorAll('[data-required="true"]:not([disabled])');

                    for (const field of visibleRequiredFields) {
                        let value = field.tagName === 'SELECT' ? field.value : field.value.trim();

                        if (!value) {
                            field.classList.add('error');
                            showError(field, 'This field is required');
                            isValid = false;
                            if (!document.querySelector('.error')) {
                                field.focus();
                            }
                        }
                    }
                }
            }

            return isValid;
        }

        if (currentSlide === 4) return true;

        if ([5, 6].includes(currentSlide)) {
            const requiredFields = currentSlideElement.querySelectorAll('[data-required="true"]:not([disabled])');

            for (const field of requiredFields) {
                let value = field.tagName === 'SELECT' ? field.value : field.value.trim();

                if (!value) {
                    field.classList.add('error');
                    showError(field, 'This field is required');
                    isValid = false;
                    if (!document.querySelector('.error:focus')) {
                        field.focus();
                    }
                }
            }

            return isValid;
        }

        return true;
    }

    // ===============================
    // SLIDE NAVIGATION
    // ===============================
    function showSlide(slideNumber) {
        document.querySelectorAll('[id^="slide"]').forEach((slide) => {
            const slideId = parseInt(slide.id.replace('slide', ''));
            slide.style.display = slideId === slideNumber ? "block" : "none";
        });

        if (slideNumber === 3) showTechnicalFields();

        currentSlide = slideNumber;

        const nextButton = document.querySelector('.next-btn');
        if (nextButton) {
            if (slideNumber === 7) {
                nextButton.textContent = 'Submit';
                nextButton.classList.add('submit-btn');
                nextButton.classList.remove('next-btn');
            } else {
                nextButton.textContent = 'Next';
                nextButton.classList.add('next-btn');
                nextButton.classList.remove('submit-btn');
            }
        }
    }

    function handleSlide5Extras() {
        const depreciationTab = document.getElementById("depreciation-tab");
        if (!depreciationTab) return;

        if (selectedType === "License") {
            depreciationTab.style.display = "none";
        } else {
            depreciationTab.style.display = ""; // show normally
        }
    }

    function handleSlide6Extras() {
        if (currentSlide !== 6) return;

        const slide6 = document.getElementById("slide6");
        if (!slide6) return;

        const warrantyStartText = slide6.querySelector("#warranty_start_date");
        const warrantyEndText = slide6.querySelector("#warranty_end_date");
        const lastMaintenanceDiv = slide6
            .querySelector("#last_schedule_maintenance")
            ?.closest(".mb-3");

        const nextMaintenanceDiv = slide6
            .querySelector("#next_schedule_maintenance")
            ?.closest(".mb-3");
        if (selectedType === "License") {
            if (warrantyStartText) {
                warrantyStartText.textContent = "Activation Date";
            }

            if (warrantyEndText) {
                warrantyEndText.textContent = "Expiration Date";
            }

            if (lastMaintenanceDiv) lastMaintenanceDiv.remove();
            if (nextMaintenanceDiv) nextMaintenanceDiv.remove();
        } else {
            if (warrantyStartText) {
                warrantyStartText.textContent = "Warranty Start Date";
            }

            if (warrantyEndText) {
                warrantyEndText.textContent = "Warranty End Date";
            }
        }
    }


    /* ===============================
           SLIDE NAVIGATION
        =============================== */
    function nextSlide() {
        // Validate current slide
        if (!validateCurrentSlide()) return;

        switch (currentSlide) {
            case 1:
                selectedType = document.getElementById("assetType").value;
                document.getElementById("summaryCategory").value = selectedCategory;
                document.getElementById("summaryType").value = selectedType;

                console.log("Type", selectedType);
                console.log("selectedCategory", selectedCategory);

                populateOperationalStatus();
                showSlide(2);
                break;

            case 2:
                showSlide(3);
                showTechnicalFields();

                // Get asset name from data attribute and populate appropriate field
                const button = document.querySelector('[data-bs-toggle="modal"][data-bs-target="#assetModal"]');
                if (button) {
                    const assetName = button.getAttribute('data-asset-name') || '';
                    populateAssetNameToField(assetName);
                }
                break;

            case 3:
                if (selectedType !== "License") {
                    showSlide(4);
                } else {
                    showSlide(5);
                    handleSlide5Extras();
                }
                break;

            case 4:
                showSlide(5);
                handleSlide5Extras();
                break;

            case 5:
                showSlide(6);
                handleSlide6Extras();
                break;

            case 6:
                showSlide(7);
                break;

            case 7:
                // Disable hidden tech-group inputs
                document.querySelectorAll(".tech-group").forEach((group) => {
                    if (
                        group.style.display === "none" ||
                        group.style.display === ""
                    ) {
                        group
                            .querySelectorAll("input, select, textarea")
                            .forEach((el) => (el.disabled = true));
                    }
                });

                document.querySelector("#assetModal form").submit();
                break;
        }
    }

    function prevSlide() {
        let prev = currentSlide - 1;

        // Skip slide 4 if type is not License
        if (prev === 4 && selectedType == "License") {
            prev = 3;
        }

        if (prev < 2) return; // prevent going before first slide

        // Remove error styles
        const currentSlideElement = document.getElementById(`slide${currentSlide}`);
        currentSlideElement.querySelectorAll(".error").forEach((field) => {
            field.classList.remove("error");
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains("error-message")) {
                errorMsg.remove();
            }
        });

        showSlide(prev);

        if (prev === 3) showTechnicalFields();
    }

    // ===============================
    // RESET MODAL
    // ===============================
    function resetAssetModal() {
        selectedCategory = "";
        selectedType = "";
        currentSlide = 2;

        document.querySelectorAll('[id^="slide"]').forEach((slide) => {
            const slideId = parseInt(slide.id.replace('slide', ''));
            slide.style.display = slideId === 2 ? "block" : "none";
        });

        document.querySelectorAll("#assetModal input, #assetModal select, #assetModal textarea").forEach((el) => {
            el.classList.remove('error');
            el.disabled = false;

            if (el.type === "checkbox" || el.type === "radio") {
                el.checked = false;
            } else if (!el.readOnly) {
                el.value = "";
            }

            const errorMsg = el.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        });

        document.getElementById('summaryCategory').value = '';
        document.getElementById('summaryType').value = '';

        const statusSelect = document.getElementById('operationalStatus');
        if (statusSelect) {
            statusSelect.innerHTML = '<option value="">Select status</option>';
            const allStatuses = [...new Set(Object.values(operationalStatusOptions).flat())];
            allStatuses.forEach((status) => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = status;
                statusSelect.appendChild(option);
            });
        }

        displayAssetTypesInfo();

        document.querySelectorAll(".tech-group").forEach((group) => {
            group.style.display = "none";
        });

        document.querySelectorAll('#slide3 input, #slide3 select, #slide3 textarea, ' +
            '#slide4 input, #slide4 select, #slide4 textarea, ' +
            '#slide5 input, #slide5 select, #slide5 textarea, ' +
            '#slide6 input, #slide6 select, #slide6 textarea, ' +
            '#slide7 input, #slide7 select, #slide7 textarea').forEach(el => {
            el.disabled = true;
        });

        const nextButton = document.querySelector('.next-btn, .submit-btn');
        if (nextButton) {
            nextButton.textContent = 'Next';
            nextButton.className = 'next-btn';
        }
    }


    // ===============================
    // INITIALIZATION
    // ===============================
    document.addEventListener('DOMContentLoaded', function() {
        const assetModal = document.getElementById('assetModal');

        if (assetModal) {
            // Initial display of asset types info
            displayAssetTypesInfo();

            // Event listener for modal show
            assetModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                if (button) {
                    const assetType = button.getAttribute('data-asset-type') || '';
                    const assetCategory = button.getAttribute('data-asset-category') || '';
                    const assetQuantity = button.getAttribute('data-quantity') || '';
                    const requestID = button.getAttribute('data-request-id') || '';

                    selectedCategory = assetType;
                    selectedType = assetCategory;

                    const summaryCategory = document.getElementById('summaryCategory');
                    const summaryType = document.getElementById('summaryType');
                    const assetQuantityInput = document.getElementById('assetQuantity');
                    const requestIDInput = document.getElementById('AssetRequestId');

                    if (summaryCategory) summaryCategory.value = assetType;
                    if (summaryType) summaryType.value = assetCategory;
                    if (assetQuantityInput) assetQuantityInput.value = assetQuantity;
                    if (requestIDInput) requestIDInput.value = requestID;

                    populateOperationalStatus();
                    displayAssetTypesInfo();
                }
            });

            // Event listener for modal hidden
            assetModal.addEventListener("hidden.bs.modal", resetAssetModal);

            // Initialize slide
            showSlide(2);
        }


        // Real-time validation
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('error')) {
                const value = e.target.tagName === 'SELECT' ? e.target.value : e.target.value.trim();
                if (value) {
                    e.target.classList.remove('error');
                    const errorMsg = e.target.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('error-message')) {
                        errorMsg.remove();
                    }
                }
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.tagName === 'SELECT' && e.target.classList.contains('error')) {
                if (e.target.value) {
                    e.target.classList.remove('error');
                    const errorMsg = e.target.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('error-message')) {
                        errorMsg.remove();
                    }
                }
            }
        });
    });
</script>
