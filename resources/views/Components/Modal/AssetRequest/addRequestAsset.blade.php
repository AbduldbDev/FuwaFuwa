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
                            <label class="form-label">Asset Model <span class="text-danger">*</span></label>
                            <input type="text" id="assetName" class="form-control" name="asset_model" required />
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

                        <div class="tech-group">
                            <div class="mb-3">
                                <label class="form-label">Asset Specifications
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea type="text" rows="10" class="form-control required-field" name="technical_specifications"></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- ===== Purchase Information ===== -->
                    <div id="slide4" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <h6>Purchase Information</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <select class="form-select searchable-select" name="vendor_id"
                                onchange="handleVendorChange(this)">
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
                    <div id="slide5" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-tools"></i>
                            <h6>Maintenance & Audit</h6>
                        </div>

                        <div class="mb-3" style="display: none">
                            <label class="form-label">Compliance Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="warranty_status">
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

                    <div id="slide6" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file"></i>
                            <h6>Documents</h6>
                        </div>

                        <div class="row align-items-end">
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">
                                    Document Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="docName" required
                                    data-required="true">
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label">
                                    Attach File <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control" id="docFile" required
                                    data-required="true">
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

                    <!-- ===== Assignment & Location ===== -->
                    <div id="slide7" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <h6>Assignment & Location</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assigned To</label>
                            <select class="form-control searchable-select" name="assigned_to" id="assignedTo"
                                onchange="handleAssignedToChange(this)">
                                <option value="">Select Employee</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}" data-department="{{ $user->department }}">
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select searchable-select" name="department" id="departmentdropdown">
                                <option selected disabled>Choose department</option>
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <select class="form-select searchable-select" name="location">
                                <option value="">Select location</option>
                                <option>Main Office</option>
                                <option>Warehouse</option>
                            </select>
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
    let currentSlide = 2; // Starting from slide 2
    let select2Initialized = false;

    function initializeSelect2() {
        // Check if Select2 is available
        if (typeof $.fn.select2 === 'undefined') {
            console.error('Select2 not loaded');
            return;
        }

        // Destroy any existing Select2 instances first
        $('.searchable-select').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });

        // Initialize Select2 for all searchable selects
        $('.searchable-select').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#assetModal'),
            placeholder: function() {
                return $(this).data('placeholder') || 'Select option';
            },
            allowClear: true,
            // Custom template for selection to apply styles
            templateSelection: function(state) {
                if (!state.id) { // placeholder
                    return state.text;
                }
                return $('<span style="color: #000;"></span>').text(state.text);
            },
            // Custom template for dropdown options
            templateResult: function(state) {
                if (!state.id) return state.text;
                return $('<span style="color: #000;"></span>').text(state.text);
            }
        });

        // Apply styling to Select2 elements
        // Apply default styling (no border)
        $('.searchable-select').each(function() {
            const $select2 = $(this).next('.select2-container');
            $select2.find('.select2-selection').css({
                'background-color': '#efefef',
                'border': '1px solid #d1d1d1', // neutral border
                'color': 'black',
                'height': '38px',
                'line-height': '36px',
                'box-shadow': 'none',
                'outline': 'none',
                'transition': 'border-color 0.2s' // smooth border change
            });

            // Add focus/blur events to change border only on focus
            $select2.find('.select2-selection').on('focus click', function() {
                $(this).css('border-color', '#f0ab4b');
            }).on('blur', function() {
                $(this).css('border-color', 'transparent');
            });
        });

        select2Initialized = true;
    }

    // Reinitialize Select2 when modal is shown
    $('#assetModal').on('shown.bs.modal', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });

    // Also initialize when modal is about to be shown (for populating data)
    $('#assetModal').on('show.bs.modal', function() {
        setTimeout(function() {
            initializeSelect2();
        }, 50);
    });

    // Function to populate modal with data from button
    function populateModalFromButton(button) {
        if (!button) return;

        // Get data attributes
        const assetType = button.getAttribute('data-asset-type');
        const assetCategory = button.getAttribute('data-asset-category');
        const assetName = button.getAttribute('data-asset-name');
        const quantity = button.getAttribute('data-quantity');
        const cost = button.getAttribute('data-cost');
        const requestId = button.getAttribute('data-request-id');

        // Set values in the form
        const summaryCategory = document.getElementById("summaryCategory");
        const summaryType = document.getElementById("summaryType");
        const assetNameField = document.getElementById("assetName");
        const assetQuantityField = document.getElementById("assetQuantity");
        const purchaseCostField = document.querySelector('input[name="purchase_cost"]');
        const assetRequestIdField = document.getElementById("AssetRequestId");

        if (summaryCategory) summaryCategory.value = assetType || '';
        if (summaryType) summaryType.value = assetCategory || '';
        if (assetNameField) assetNameField.value = assetName || '';
        if (assetQuantityField) assetQuantityField.value = quantity || '';
        if (purchaseCostField) purchaseCostField.value = cost || '';
        if (assetRequestIdField) assetRequestIdField.value = requestId || '';

        // Set selected category and type for technical specs
        selectedCategory = assetType || '';
        selectedType = assetCategory || '';
    }

    function addDocument() {
        const name = document.getElementById("docName");
        const fileInput = document.getElementById("docFile");

        if (!name || !fileInput || !name.value || !fileInput.files.length) {
            alert("Please complete all document fields.");
            return;
        }

        const file = fileInput.files[0];
        const table = document.getElementById("docTableBody");

        if (!table) return;

        // Generate a unique identifier for this document row
        const docId = "doc_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9);

        const row = document.createElement("tr");
        row.setAttribute("data-doc-id", docId);
        row.innerHTML = `
            <td>${name.value}</td>
            <td>
                <span class="file-name">${file.name}</span>
                <input type="hidden" name="documents[name][]" value="${name.value}">
                <input type="hidden" name="documents[file_name][]" value="${file.name}">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeDocument('${docId}')">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        `;

        table.appendChild(row);

        // Store file data
        const fileData = new FormData();
        fileData.append('file', file);
        fileData.append('docId', docId);
        fileData.append('name', name.value);

        // You might want to store this in a global array or send to server
        if (!window.documentFiles) {
            window.documentFiles = [];
        }
        window.documentFiles.push({
            id: docId,
            name: name.value,
            file: file
        });

        fileInput.value = "";
        name.value = "";
    }

    // Remove document function
    function removeDocument(docId) {
        const row = document.querySelector(`tr[data-doc-id="${docId}"]`);
        if (row) {
            row.remove();
        }

        // Remove from stored files
        if (window.documentFiles) {
            window.documentFiles = window.documentFiles.filter(doc => doc.id !== docId);
        }
    }

    function validateDocuments() {
        const docTableBody = document.getElementById("docTableBody");
        const docName = document.getElementById("docName");
        const docFile = document.getElementById("docFile");

        // Clear previous errors
        [docName, docFile].forEach((field) => {
            if (field) {
                field.classList.remove("error");
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains("error-message")) {
                    errorMsg.remove();
                }
            }
        });

        // Check if at least one document is added
        if (!docTableBody || docTableBody.children.length === 0) {
            if (docName) {
                showError(docName, "Please add at least one document");
                docName.classList.add("error");
                docName.focus();
            }
            return false;
        }

        return true;
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
        "Physical Asset": ["Active", "In Stock", "Under Maintenance", "Retired"],
        "Digital Asset": ["Active", "Inactive", "Expired"],
    };

    /* ===============================
           VALIDATION FUNCTIONS
        =============================== */
    function validateCurrentSlide() {
        const currentSlideElement = document.getElementById(`slide${currentSlide}`);
        if (!currentSlideElement) return true;

        let isValid = true;

        // Remove previous error styles from ALL fields in current slide
        currentSlideElement
            .querySelectorAll('[data-required="true"], [required]')
            .forEach((field) => {
                field.classList.remove("error");
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains("error-message")) {
                    errorMsg.remove();
                }
            });

        if (currentSlide === 2) {
            // Basic Information slide
            const assetName = document.querySelector('#slide2 input[name="asset_model"]');

            if (!assetName || !assetName.value.trim()) {
                if (assetName) {
                    assetName.classList.add("error");
                    showError(assetName, "Asset Model is required");
                }
                isValid = false;
                if (assetName) assetName.focus();
            }

            return isValid;
        }

        if (currentSlide === 3 || currentSlide === 4 || currentSlide === 5) {
            // Validate all required fields
            const requiredFields = currentSlideElement.querySelectorAll(
                '[data-required="true"]:not([disabled])',
            );

            for (const field of requiredFields) {
                let value = field.tagName === "SELECT" ? field.value : field.value.trim();

                if (!value) {
                    field.classList.add("error");
                    showError(field, "This field is required");
                    isValid = false;
                    if (!document.querySelector(".error:focus")) {
                        field.focus();
                    }
                }
            }

            return isValid;
        }

        if (currentSlide === 6) {
            // Documents validation
            return validateDocuments();
        }

        if (currentSlide === 7) {
            // Assignment & Location - no required fields (optional)
            return true;
        }

        return true;
    }

    function showError(field, message) {
        if (!field) return;

        // Remove existing error message
        const existingError = field.nextElementSibling;
        if (existingError && existingError.classList.contains("error-message")) {
            existingError.remove();
        }

        // Add new error message
        const errorMsg = document.createElement("div");
        errorMsg.className = "error-message";
        errorMsg.style.color = "#dc3545";
        errorMsg.style.fontSize = "12px";
        errorMsg.style.marginTop = "4px";
        errorMsg.textContent = message;
        field.parentNode.insertBefore(errorMsg, field.nextSibling);
    }

    function handleSlide5Extras() {
        const depreciationTab = document.getElementById("depreciation-tab");
        if (!depreciationTab) return;

        if (selectedType === "License") {
            depreciationTab.style.display = "none";
        } else {
            depreciationTab.style.display = "block";
        }
    }

    function handleSlide6Extras() {
        const warrantyStartText = document.getElementById("warranty_start_date");
        const warrantyEndText = document.getElementById("warranty_end_date");
        const lastMaintenanceDiv = document.getElementById("last_schedule_maintenance")?.closest(".mb-3");
        const nextMaintenanceDiv = document.getElementById("next_schedule_maintenance")?.closest(".mb-3");

        if (selectedType === "License") {
            // Change labels for License
            if (warrantyStartText) warrantyStartText.textContent = "Activation Date";
            if (warrantyEndText) warrantyEndText.textContent = "Expiration Date";
            if (lastMaintenanceDiv) lastMaintenanceDiv.style.display = "none";
            if (nextMaintenanceDiv) nextMaintenanceDiv.style.display = "none";
        } else {
            // Reset to default labels for non-License
            if (warrantyStartText) warrantyStartText.textContent = "Warranty Start Date";
            if (warrantyEndText) warrantyEndText.textContent = "Warranty End Date";
            if (lastMaintenanceDiv) lastMaintenanceDiv.style.display = "block";
            if (nextMaintenanceDiv) nextMaintenanceDiv.style.display = "block";
        }
    }

    /* ===============================
           SLIDE NAVIGATION
        =============================== */
    function nextSlide() {
        // Validate current slide
        if (!validateCurrentSlide()) return;

        switch (currentSlide) {
            case 2: // Basic Information
                showSlide(3);
                break;
            case 3: // Technical Specifications
                showSlide(4);
                handleSlide5Extras();
                break;
            case 4: // Purchase Information
                showSlide(5);
                handleSlide6Extras();
                break;
            case 5: // Maintenance & Audit
                showSlide(6);
                break;
            case 6: // Documents
                if (!validateDocuments()) return;
                showSlide(7);
                break;
            case 7: // Assignment & Location (final slide)
                document.querySelector("#assetModal form").submit();
                break;
        }
    }

    function prevSlide() {
        let prev = currentSlide - 1;
        if (prev < 2) return;

        // Remove error styles
        const currentSlideElement = document.getElementById(`slide${currentSlide}`);
        if (currentSlideElement) {
            currentSlideElement.querySelectorAll(".error").forEach((field) => {
                field.classList.remove("error");
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains("error-message")) {
                    errorMsg.remove();
                }
            });
        }

        showSlide(prev);

        // Handle special cases when going back to certain slides
        if (prev === 5) handleSlide6Extras();
    }

    /* ===============================
           SHOW/HIDE SLIDES
        =============================== */
    function showSlide(slideNumber) {
        // Hide all slides
        document.querySelectorAll('[id^="slide"]').forEach((slide) => {
            slide.style.display = "none";
        });

        // Show the requested slide
        const slideToShow = document.getElementById(`slide${slideNumber}`);
        if (slideToShow) {
            slideToShow.style.display = "block";
        }

        if (slideNumber === 5) {
            handleSlide6Extras();
        }

        currentSlide = slideNumber;

        const nextButton = document.querySelector(".next-btn, .submit-btn");
        if (nextButton) {
            if (slideNumber === 7) {
                nextButton.textContent = "Submit";
                nextButton.className = "submit-btn";
            } else {
                nextButton.textContent = "Next";
                nextButton.className = "next-btn";
            }
        }

        // Reinitialize Select2 after showing slide
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    }

    function handleAssignedToChange(select) {
        const departmentSelect = document.getElementById("departmentdropdown");
        if (!departmentSelect || !select) return;

        const selectedOption = select.options[select.selectedIndex];

        if (select.value && selectedOption && selectedOption.dataset.department) {
            const employeeDepartment = selectedOption.dataset.department;
            departmentSelect.value = employeeDepartment;
            departmentSelect.disabled = true;
            departmentSelect.style.backgroundColor = "#e9ecef";
            departmentSelect.style.cursor = "not-allowed";

            // Update Select2 if initialized
            if ($(departmentSelect).hasClass('select2-hidden-accessible')) {
                $(departmentSelect).val(employeeDepartment).trigger('change');
            }
        } else {
            departmentSelect.value = "";
            departmentSelect.disabled = false;
            departmentSelect.style.backgroundColor = "";
            departmentSelect.style.cursor = "";

            // Update Select2 if initialized
            if ($(departmentSelect).hasClass('select2-hidden-accessible')) {
                $(departmentSelect).val("").trigger('change');
            }
        }
    }

    /* ===============================
           RESET MODAL
        =============================== */
    function resetAssetModal() {
        selectedCategory = "";
        selectedType = "";
        currentSlide = 2;

        // Hide all slides except slide 2
        document.querySelectorAll('[id^="slide"]').forEach((slide) => {
            slide.style.display = "none";
        });

        // Show slide 2
        const slide2 = document.getElementById("slide2");
        if (slide2) slide2.style.display = "block";

        // Reset all inputs and remove error styles
        document.querySelectorAll("#assetModal input, #assetModal select, #assetModal textarea").forEach((el) => {
            el.classList.remove("error");
            el.disabled = false;

            if (el.type !== "checkbox" && el.type !== "radio") {
                el.value = "";
            } else if (el.type === "checkbox" || el.type === "radio") {
                el.checked = false;
            }

            // Remove error messages
            const errorMsg = el.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains("error-message")) {
                errorMsg.remove();
            }
        });

        // Clear document table
        const docTableBody = document.getElementById("docTableBody");
        if (docTableBody) docTableBody.innerHTML = "";

        // Clear stored files
        window.documentFiles = [];

        // Reset button text
        const nextButton = document.querySelector(".next-btn, .submit-btn");
        if (nextButton) {
            nextButton.textContent = "Next";
            nextButton.className = "next-btn";
        }

        // Reset department dropdown
        const departmentSelect = document.getElementById("departmentdropdown");
        if (departmentSelect) {
            departmentSelect.disabled = false;
            departmentSelect.style.backgroundColor = "";
            departmentSelect.style.cursor = "";
        }
    }

    /* ===============================
           BOOTSTRAP MODAL EVENT HANDLER
        =============================== */
    const assetModal = document.getElementById("assetModal");
    if (assetModal) {
        // When modal is about to be shown
        assetModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            populateModalFromButton(button);
        });

        // When modal is hidden
        assetModal.addEventListener("hidden.bs.modal", resetAssetModal);
    }

    // Initialize first slide correctly - show slide 2
    document.addEventListener("DOMContentLoaded", function() {
        showSlide(2);
    });

    // Add real-time validation to remove error styles when user starts typing
    document.addEventListener("input", function(e) {
        if (e.target.classList && e.target.classList.contains("error")) {
            const value = e.target.tagName === "SELECT" ? e.target.value : e.target.value.trim();
            if (value) {
                e.target.classList.remove("error");
                const errorMsg = e.target.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains("error-message")) {
                    errorMsg.remove();
                }
            }
        }
    });

    // Also validate on change for select elements
    document.addEventListener("change", function(e) {
        if (e.target.tagName === "SELECT" && e.target.classList && e.target.classList.contains("error")) {
            if (e.target.value) {
                e.target.classList.remove("error");
                const errorMsg = e.target.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains("error-message")) {
                    errorMsg.remove();
                }
            }
        }
    });
</script>
