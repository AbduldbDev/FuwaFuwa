<div class="modal fade" id="assetModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered sta">
        <div class="modal-content">
            <!-- modal header -->
            <form action="{{ route('assets.store') }}" method="POST" id="assetForm">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title w-100 text-center fw-semibold">
                        ADD NEW ASSET
                    </h3>
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
                        <h4 class="mb-3">Basic Information</h4>

                        <div class="mb-3">
                            <label class="form-label">Asset Name</label>
                            <input type="text" class="form-control" name="asset_name" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asset Type</label>
                            <input type="text" id="summaryCategory" class="form-control" name="asset_type"
                                readonly />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asset Category</label>
                            <input type="text" id="summaryType" class="form-control" name="asset_category"
                                readonly />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Operational Status</label>
                            <select id="operationalStatus" class="form-select" name="operational_status" required>
                                <option value="">Select status</option>
                            </select>
                        </div>
                    </div>

                    <!-- ===== Technical Specifications ===== -->
                    <div id="slide3" style="display: none">
                        <h4 class="mb-3">Technical Specifications</h4>

                        <!-- PC / Laptop -->
                        <div class="tech-group" data-type="PC Laptop">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Processor
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Processor]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RAM
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[RAM]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Storage
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Storage]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Operating System
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Operating_System]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">MAC Address
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[MAC_Address]" />
                            </div>
                        </div>

                        <!-- Router -->
                        <div class="tech-group" data-type="Router">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Network Role
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Firmware_Version]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Routing Protocols
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Routing_Protocols]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">WAN / LAN Ports
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[WAN/LAN_Ports]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Throughput Capacity
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Throughout_Capacity]" />
                            </div>
                        </div>

                        <!-- Firewall -->
                        <div class="tech-group" data-type="Firewall">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cabinet Type
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Rack_Units]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cooling Type
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Throughput_Capacity]" />
                            </div>
                        </div>

                        <!-- Switch -->
                        <div class="tech-group" data-type="Switch">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Asset_Model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Number of Ports
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="number" class="form-control required-field" data-required="true"
                                    name="specs[Number_of_Ports]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">VLAN Configuration
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[VLAN_Configuration]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Switch Role
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Port_Speed]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PoE Support
                                    <span class="required-text">* Required</span>
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

                        <!-- Software -->
                        <div class="tech-group" data-type="Software">
                            <div class="mb-3">
                                <label class="form-label">Software Version
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Software_Version]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hosting Location
                                    <span class="required-text">* Required</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[Hosting_Location]">
                                    <option value="">Select Hosting Location</option>
                                    <option>On-premise</option>
                                    <option>Cloud (SaaS)</option>
                                    <option>Hybrid</option>
                                    <option>Private Cloud</option>
                                </select>
                            </div>
                        </div>

                        <!-- License -->
                        <div class="tech-group" data-type="License">
                            <div class="mb-3">
                                <label class="form-label">License SKU
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[License_SKU]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">License Edition
                                    <span class="required-text">* Required</span>
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
                                <label class="form-label">Cost per License
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Cost_per_License]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">License Type
                                    <span class="required-text">* Required</span>
                                </label>
                                <select class="form-select required-field" data-required="true"
                                    name="specs[License_Type]">
                                    <option value="">Select License Type</option>
                                    <option value="Volume">Volume</option>
                                    <option value="Individual">Individual</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Number of Seats
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="number" class="form-control required-field" data-required="true"
                                    name="specs[Number_of_seats]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">License Key
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[License_Key]" />
                            </div>
                        </div>

                        <!-- Modem -->
                        <div class="tech-group" data-type="Modem">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[asset_model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ISP Name
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[ISP_Name]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Connection Type
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Speed_Rating]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">MAC Address
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[MAC_Address]" />
                            </div>
                        </div>

                        <!-- Communication Cabinet -->
                        <div class="tech-group" data-type="Communication Cabinet">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[asset_model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cabinet Type
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[rack_units]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cooling Type
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Power_Capacity]" />
                            </div>
                        </div>

                        <!-- Server Cabinet -->
                        <div class="tech-group" data-type="Server Cabinet">
                            <div class="mb-3">
                                <label class="form-label">Asset Model
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[asset_model]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rack Units
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[rack_units]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cooling System
                                    <span class="required-text">* Required</span>
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
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[PDU_Details]" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Weight Capacity
                                    <span class="required-text">* Required</span>
                                </label>
                                <input type="text" class="form-control required-field" data-required="true"
                                    name="specs[Weight_Capacity]" />
                            </div>
                        </div>
                    </div>

                    <!-- ===== Assignment & Location ===== -->
                    <div id="slide4" style="display: none">
                        <h4 class="mb-3">Assignment & Location</h4>

                        <div class="mb-3">
                            <label class="form-label">Assigned To</label>
                            <select class="form-control" name="assigned_to">
                                <option value="">Select Employee</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
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
                                <option>Branch Office</option>
                                <option>Warehouse</option>
                                <option>Data Center</option>
                                <option>Remote</option>
                            </select>
                        </div>
                    </div>

                    <!-- ===== Purchase Information ===== -->
                    <div id="slide5" style="display: none">
                        <h4 class="mb-3">Purchase Information</h4>

                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <select class="form-select" name="vendor">
                                <option value="">Select vendor</option>
                                <option>Vendor A</option>
                                <option>Vendor B</option>
                                <option>Vendor C</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" class="form-control required-field" data-required="true"
                                name="purchase_date" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Cost</label>
                            <input type="number" class="form-control required-field" data-required="true"
                                name="purchase_cost" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Useful Life (Years)</label>
                            <input type="number" class="form-control required-field" data-required="true"
                                name="useful_life_years" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salvage Value</label>
                            <input type="number" class="form-control required-field" data-required="true"
                                name="salvage_value" />
                        </div>
                    </div>

                    <!-- ===== Maintenance & Audit ===== -->
                    <div id="slide6" style="display: none">
                        <h4 class="mb-3">Maintenance & Audit</h4>

                        <div class="mb-3">
                            <label class="form-label">Compliance Status</label>
                            <select class="form-select" name="compliance_status">
                                <option value="">Select status</option>
                                <option>Compliant</option>
                                <option>Non-Compliant</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Warranty Start Date</label>
                            <input type="date" class="form-control required-field" data-required="true"
                                name="warranty_start" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Warranty End Date</label>
                            <input type="date" class="form-control required-field" data-required="true"
                                name="warranty_end" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Next Scheduled Maintenance</label>
                            <input type="date" class="form-control required-field" data-required="true"
                                name="next_maintenance" />
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

<style>
    .required-field.error {
        border: 1px solid #dc3545 !important;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
    }

    .required-text {
        color: #dc3545;
        font-size: 0.75rem;
        font-weight: normal;
        margin-left: 0.25rem;
    }
</style>

<script>
    let selectedCategory = "";
    let selectedType = "";
    let currentSlide = 1;

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
        "Digital Asset": ["License", "Software"],
    };

    const operationalStatusOptions = {
        "Physical Asset": ["Active", "In Stock", "Under Maintenance", "Retired"],
        "Digital Asset": ["Active", "Inactive", "Expired"],
    };

    /* ===============================
       CATEGORY & TYPE SELECTION
    =============================== */
    function selectCategory(category, element) {
        selectedCategory = category;

        document.querySelectorAll(".asset-option").forEach((opt) =>
            opt.classList.remove("active")
        );
        element.classList.add("active");

        const assetTypeSelect = document.getElementById("assetType");
        assetTypeSelect.disabled = false;
        assetTypeSelect.innerHTML = '<option value="">Select Category</option>';

        assetTypes[category].forEach((type) => {
            const option = document.createElement("option");
            option.value = type;
            option.textContent = type;
            assetTypeSelect.appendChild(option);
        });
    }

    function populateOperationalStatus() {
        const statusSelect = document.getElementById("operationalStatus");
        statusSelect.innerHTML = '<option value="">Select Status</option>';

        operationalStatusOptions[selectedCategory].forEach((status) => {
            const option = document.createElement("option");
            option.value = status;
            option.textContent = status;
            statusSelect.appendChild(option);
        });
    }

    /* ===============================
       VALIDATION FUNCTIONS
    =============================== */
    function validateCurrentSlide() {
        const currentSlideElement = document.getElementById(`slide${currentSlide}`);
        let isValid = true;

        // Remove previous error styles from ALL fields in current slide
        currentSlideElement.querySelectorAll('[data-required="true"], [required]').forEach(field => {
            field.classList.remove('error');
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        });

        // Special handling for each slide
        if (currentSlide === 1) {
            return validateSlide1();
        }

        if (currentSlide === 2) {
            // Basic Information slide
            const assetName = document.querySelector('#slide2 input[name="asset_name"]');
            const operationalStatus = document.querySelector('#slide2 select[name="operational_status"]');

            if (!assetName.value.trim()) {
                assetName.classList.add('error');
                showError(assetName, 'Asset Name is required');
                isValid = false;
                assetName.focus();
            }

            if (!operationalStatus.value) {
                operationalStatus.classList.add('error');
                showError(operationalStatus, 'Operational Status is required');
                isValid = false;
                if (isValid) operationalStatus.focus();
            }

            return isValid;
        }

        if (currentSlide === 3) {
            // Technical Specifications - only validate visible fields
            const visibleTechGroup = document.querySelector(
                '.tech-group[style*="display: block"], .tech-group[style*="display:block"]');
            if (!visibleTechGroup) {
                alert("Please select an asset type first.");
                return false;
            }

            // Get only visible required fields
            const visibleRequiredFields = visibleTechGroup.querySelectorAll('[data-required="true"]:not([disabled])');

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

            return isValid;
        }

        if (currentSlide === 4) {
            // Assignment & Location - no required fields
            return true;
        }

        if (currentSlide === 5) {
            // Purchase Information - validate all required fields
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

        if (currentSlide === 6) {
            // Maintenance & Audit - validate all required fields
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

    function showError(field, message) {
        // Remove existing error message
        const existingError = field.nextElementSibling;
        if (existingError && existingError.classList.contains('error-message')) {
            existingError.remove();
        }

        // Add new error message
        const errorMsg = document.createElement('div');
        errorMsg.className = 'error-message';
        errorMsg.textContent = message;
        field.parentNode.insertBefore(errorMsg, field.nextSibling);
    }

    function validateSlide1() {
        const type = document.getElementById("assetType").value;

        if (!selectedCategory) {
            alert("Please select an Asset Type (Physical or Digital).");
            return false;
        }

        if (!type) {
            alert("Please select an Asset Category.");
            return false;
        }

        return true;
    }

    /* ===============================
       SLIDE NAVIGATION
    =============================== */
    function nextSlide() {
        // Validate current slide
        if (!validateCurrentSlide()) {
            return;
        }

        // Navigation logic
        if (currentSlide === 1) {
            const type = document.getElementById("assetType").value;
            selectedType = type;
            document.getElementById("summaryCategory").value = selectedCategory;
            document.getElementById("summaryType").value = selectedType;
            populateOperationalStatus();

            showSlide(2);
            return;
        }

        if (currentSlide === 2) {
            showSlide(3);
            showTechnicalFields();
            return;
        }

        if (currentSlide === 3) {
            showSlide(4);
            return;
        }

        if (currentSlide === 4) {
            showSlide(5);
            return;
        }

        if (currentSlide === 5) {
            showSlide(6);
            return;
        }

        if (currentSlide === 6) {
            // Disable only hidden tech-group inputs
            document.querySelectorAll(".tech-group").forEach(group => {
                if (group.style.display === "none" || group.style.display === "") {
                    group.querySelectorAll("input, select, textarea").forEach(el => {
                        el.disabled = true;
                    });
                }
            });

            // Submit the form
            document.querySelector("#assetModal form").submit();
        }
    }

    function prevSlide() {
        if (currentSlide > 1) {
            // Remove error styles when going back
            const currentSlideElement = document.getElementById(`slide${currentSlide}`);
            currentSlideElement.querySelectorAll('.error').forEach(field => {
                field.classList.remove('error');
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            });

            showSlide(currentSlide - 1);
            if (currentSlide - 1 === 3) showTechnicalFields();
        }
    }

    /* ===============================
       SHOW/HIDE SLIDES
    =============================== */
    function showSlide(slideNumber) {
        document.querySelectorAll('[id^="slide"]').forEach((slide, index) => {
            slide.style.display = index + 1 === slideNumber ? "block" : "none";
        });

        // Only show the correct technical spec inputs
        if (slideNumber === 3) showTechnicalFields();

        currentSlide = slideNumber;

        // Update button text on last slide
        const nextButton = document.querySelector('.next-btn');
        if (slideNumber === 6) {
            nextButton.textContent = 'Submit';
            nextButton.classList.add('submit-btn');
            nextButton.classList.remove('next-btn');
        } else {
            nextButton.textContent = 'Next';
            nextButton.classList.add('next-btn');
            nextButton.classList.remove('submit-btn');
        }
    }

    /* ===============================
       TECHNICAL SPECIFICATIONS
    =============================== */
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

    /* ===============================
       RESET MODAL
    =============================== */
    function resetAssetModal() {
        selectedCategory = "";
        selectedType = "";
        currentSlide = 1;

        // Hide all slides except slide 1
        document.querySelectorAll('[id^="slide"]').forEach((slide, index) => {
            slide.style.display = index === 0 ? "block" : "none";
        });

        // Reset asset options
        document.querySelectorAll(".asset-option").forEach((opt) =>
            opt.classList.remove("active")
        );

        const assetTypeSelect = document.getElementById("assetType");
        assetTypeSelect.disabled = true;
        assetTypeSelect.innerHTML = '<option value="">Select Asset Type First</option>';

        const operationalStatus = document.getElementById("operationalStatus");
        if (operationalStatus) operationalStatus.innerHTML = '<option value="">Select Status</option>';

        // Reset all inputs and remove error styles
        document.querySelectorAll("#assetModal input, #assetModal select, #assetModal textarea").forEach((el) => {
            el.classList.remove('error');
            el.disabled = false; // Enable all fields first

            if (el.type === "checkbox" || el.type === "radio") {
                el.checked = false;
            } else {
                el.value = "";
            }

            // Remove error messages
            const errorMsg = el.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        });

        // Hide all technical spec groups
        document.querySelectorAll(".tech-group").forEach((group) => {
            group.style.display = "none";
        });

        // Disable all fields except in slide 1
        document.querySelectorAll('#slide2 input, #slide2 select, #slide2 textarea, ' +
            '#slide3 input, #slide3 select, #slide3 textarea, ' +
            '#slide4 input, #slide4 select, #slide4 textarea, ' +
            '#slide5 input, #slide5 select, #slide5 textarea, ' +
            '#slide6 input, #slide6 select, #slide6 textarea').forEach(el => {
            el.disabled = true;
        });

        // Reset button text
        const nextButton = document.querySelector('.next-btn, .submit-btn');
        if (nextButton) {
            nextButton.textContent = 'Next';
            nextButton.className = 'next-btn';
        }
    }

    /* ===============================
       BOOTSTRAP MODAL EVENT
    =============================== */
    const assetModal = document.getElementById("assetModal");
    if (assetModal) {
        assetModal.addEventListener("hidden.bs.modal", resetAssetModal);
    }

    // Initialize first slide correctly
    showSlide(1);

    // Add real-time validation to remove error styles when user starts typing
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

    // Also validate on change for select elements
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
</script>
