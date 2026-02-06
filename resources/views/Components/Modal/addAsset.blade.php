<div class="modal fade" id="assetModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
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
                    <!-- ===== Asset Category and Type ===== -->
                    <div id="slide1">
                        <p class="form-label">Select Asset Type</p>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="asset-option" onclick="selectCategory('Physical Asset', this)">
                                    <i class="fa-solid fa-box"></i>
                                    <h6>Physical Asset</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="asset-option" onclick="selectCategory('Digital Asset', this)">
                                    <i class="fa-solid fa-laptop-code"></i>
                                    <h6>Digital Asset</h6>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Asset Category</label>
                            <select class="form-select shadow-none" id="assetType" disabled>
                                <option value="">Select asset category first</option>
                            </select>
                        </div>
                    </div>

                    <!-- ===== Basic Information ===== -->
                    <div id="slide2" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-regular fa-user"></i>
                            <h6>Basic Information</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asset Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="asset_name" required />
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

                        <div class="mb-3">
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
                                <option value="IT Department">IT Department</option>
                                <option value="HR Department">HR Department</option>
                                <option value="Finance Department">Finance Department</option>
                                <option value="Operations">Operations</option>
                                <option value="Admin">Admin</option>
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
                            <label class="form-label">Vendor <span class="text-danger">*</span></label>
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
                            <input type="date" class="form-control required-field" name="purchase_date"
                                data-required="true" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Cost <span class="text-danger">*</span></label>
                            <input type="number" class="form-control required-field" data-required="true"
                                name="purchase_cost" />
                        </div>

                        <div id="depreciation-tab">
                            <div class="mb-3">
                                <label class="form-label">Useful Life (Years)</label>
                                <input type="number" class="form-control required-field" name="useful_life_years" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Salvage Value</label>
                                <input type="number" class="form-control required-field" name="salvage_value" />
                            </div>
                        </div>
                    </div>

                    <!-- ===== Maintenance & Audit ===== -->
                    <div id="slide6" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-tools"></i>
                            <h6>Maintenance & Audit</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Compliance Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="compliance_status" data-required="true">
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

                    <!-- ===== Documents ===== -->
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
<script src="{{ asset('/Js/Assets/addAsset.js') }}?v={{ time() }}"></script>
