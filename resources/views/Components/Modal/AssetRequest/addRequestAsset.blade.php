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
                            <select class="form-control" name="assigned_to" id="assignedTo"
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
                            <select class="form-select" name="department" id="departmentdropdown">
                                <option selected disabled>Choose department</option>
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
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

    // Function to populate modal with data from button
    function populateModalFromButton(button) {
        // Get data attributes
        const assetType = button.getAttribute('data-asset-type');
        const assetCategory = button.getAttribute('data-asset-category');
        const assetName = button.getAttribute('data-asset-name');
        const quantity = button.getAttribute('data-quantity');
        const cost = button.getAttribute('data-cost');
        const requestId = button.getAttribute('data-request-id');

        // Set values in the form
        document.getElementById("summaryCategory").value = assetType || '';
        document.getElementById("summaryType").value = assetCategory || '';
        document.getElementById("assetName").value = assetName || '';
        document.getElementById("assetQuantity").value = quantity || '';
        document.querySelector('input[name="purchase_cost"]').value = cost || '';
        document.getElementById("AssetRequestId").value = requestId || '';

        // Set selected category and type for technical specs
        selectedCategory = assetType || '';
        selectedType = assetCategory || '';

    }

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
        const docId = "doc_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9);

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

    function validateDocuments() {
        const docTableBody = document.getElementById("docTableBody");
        const docName = document.getElementById("docName");
        const docFile = document.getElementById("docFile");

        // Clear previous errors
        [docName, docFile].forEach((field) => {
            field.classList.remove("error");
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains("error-message")) {
                errorMsg.remove();
            }
        });

        // Check if at least one document is added
        if (!docTableBody || docTableBody.children.length === 0) {
            showError(docName, "Please add at least one document");
            docName.classList.add("error");
            docName.focus();
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
           CATEGORY & TYPE SELECTION
        =============================== */
    function selectCategory(category, element) {
        selectedCategory = category;

        document
            .querySelectorAll(".asset-option")
            .forEach((opt) => opt.classList.remove("active"));
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
            const assetName = document.querySelector(
                '#slide2 input[name="asset_model"]',
            );

            if (!assetName.value.trim()) {
                assetName.classList.add("error");
                showError(assetName, "Asset Model is required");
                isValid = false;
                assetName.focus();
            }

            return isValid;
        }

        if (currentSlide === 3) {
            // Purchase Information - validate all required fields
            const requiredFields = currentSlideElement.querySelectorAll(
                '[data-required="true"]:not([disabled])',
            );

            for (const field of requiredFields) {
                let value =
                    field.tagName === "SELECT" ? field.value : field.value.trim();

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

        if (currentSlide === 4) {
            // Purchase Information - validate all required fields
            const requiredFields = currentSlideElement.querySelectorAll(
                '[data-required="true"]:not([disabled])',
            );

            for (const field of requiredFields) {
                let value =
                    field.tagName === "SELECT" ? field.value : field.value.trim();

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

        if (currentSlide === 5) {
            // Maintenance & Audit - validate all required fields
            const requiredFields = currentSlideElement.querySelectorAll(
                '[data-required="true"]:not([disabled])',
            );

            for (const field of requiredFields) {
                let value =
                    field.tagName === "SELECT" ? field.value : field.value.trim();

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
        // Remove existing error message
        const existingError = field.nextElementSibling;
        if (existingError && existingError.classList.contains("error-message")) {
            existingError.remove();
        }

        // Add new error message
        const errorMsg = document.createElement("div");
        errorMsg.className = "error-message";
        errorMsg.textContent = message;
        field.parentNode.insertBefore(errorMsg, field.nextSibling);
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
        const slide5 = document.getElementById("slide5");
        if (!slide5) return;

        const warrantyStartText = document.getElementById("warranty_start_date");
        const warrantyEndText = document.getElementById("warranty_end_date");
        const lastMaintenanceDiv = document
            .getElementById("last_schedule_maintenance")
            ?.closest(".mb-3");
        const nextMaintenanceDiv = document
            .getElementById("next_schedule_maintenance")
            ?.closest(".mb-3");

        if (selectedType === "License") {
            // Change labels for License
            if (warrantyStartText) {
                warrantyStartText.textContent = "Activation Date";
            }

            if (warrantyEndText) {
                warrantyEndText.textContent = "Expiration Date";
            }

            // Hide maintenance fields for License
            if (lastMaintenanceDiv) lastMaintenanceDiv.style.display = "none";
            if (nextMaintenanceDiv) nextMaintenanceDiv.style.display = "none";
        } else {
            // Reset to default labels for non-License
            if (warrantyStartText) {
                warrantyStartText.textContent = "Warranty Start Date";
            }

            if (warrantyEndText) {
                warrantyEndText.textContent = "Warranty End Date";
            }

            // Show maintenance fields for non-License
            if (lastMaintenanceDiv) lastMaintenanceDiv.style.display = "";
            if (nextMaintenanceDiv) nextMaintenanceDiv.style.display = "";
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
                showSlide(4); // Purchase Information
                handleSlide5Extras();
                break;

            case 4: // Purchase Information
                showSlide(5); // Maintenance & Audit
                handleSlide6Extras();
                break;


            case 5: // Maintenance & Audit
                showSlide(6);
                break;

            case 6: // Documents
                if (!validateDocuments()) return;
                showSlide(7); // Assignment & Location
                break;

            case 7: // Assignment & Location (final slide)

                document.querySelector("#assetModal form").submit();
                break;
        }
    }

    function prevSlide() {
        let prev = currentSlide - 1;

        // Handle going back from Assignment & Location (slide 7) to Documents (slide 6)
        if (currentSlide === 7) {
            prev = 6;
        }
        // Handle going back from Documents (slide 6) to Maintenance & Audit (slide 5)
        else if (currentSlide === 6) {
            prev = 5;
        }
        // Handle going back from Maintenance & Audit (slide 5) to Purchase Information (slide 4)
        else if (currentSlide === 5) {
            prev = 4;
        }
        // Handle going back from Purchase Information (slide 4) to Technical Specifications (slide 3)
        else if (currentSlide === 4) {
            prev = 3;
        }
        // Handle going back from Technical Specifications (slide 3) to Basic Information (slide 2)
        else if (currentSlide === 3) {
            prev = 2;
        }
        // Can't go back from Basic Information (slide 2) since there's no slide 1

        if (prev < 2) return; // prevent going before slide 2

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

        // Show technical fields if on slide 3
        if (slideNumber === 3) {

        }

        if (slideNumber === 4) {
            // No need for handleSlide5Extras in this modal
        }

        if (slideNumber === 5) {
            handleSlide6Extras();
        }

        currentSlide = slideNumber;

        const nextButton = document.querySelector(".next-btn, .submit-btn");
        if (nextButton) {
            if (slideNumber === 7) {
                // Assignment & Location is the last slide
                nextButton.textContent = "Submit";
                nextButton.className = "submit-btn";
            } else {
                nextButton.textContent = "Next";
                nextButton.className = "next-btn";
            }
        }
    }


    function handleAssignedToChange(select) {
        const departmentSelect = document.getElementById("departmentdropdown");
        const selectedOption = select.options[select.selectedIndex];

        if (select.value && selectedOption.dataset.department) {
            // Get the department from the selected employee's data attribute
            const employeeDepartment = selectedOption.dataset.department;

            // Auto-fill department from selected employee
            departmentSelect.value = employeeDepartment;

            // Check if the value was set successfully
            if (departmentSelect.value === employeeDepartment) {
                // Make it readonly and style it
                departmentSelect.disabled = true;
                departmentSelect.style.backgroundColor = "#e9ecef";
                departmentSelect.style.cursor = "not-allowed";
            } else {}
        } else {
            // Clear department if no employee selected
            departmentSelect.value = "";
            departmentSelect.disabled = false;
            departmentSelect.style.backgroundColor = "";
            departmentSelect.style.cursor = "";
        }
    }

    /* ===============================
           RESET MODAL
        =============================== */
    function resetAssetModal() {
        selectedCategory = "";
        selectedType = "";
        currentSlide = 2; // Reset to slide 2 instead of 1

        // Hide all slides except slide 2
        document.querySelectorAll('[id^="slide"]').forEach((slide) => {
            slide.style.display = "none";
        });

        // Show slide 2
        const slide2 = document.getElementById("slide2");
        if (slide2) {
            slide2.style.display = "block";
        }

        // Reset asset options if they exist
        const assetOptions = document.querySelectorAll(".asset-option");
        if (assetOptions.length > 0) {
            assetOptions.forEach((opt) => opt.classList.remove("active"));
        }

        const assetTypeSelect = document.getElementById("assetType");
        if (assetTypeSelect) {
            assetTypeSelect.disabled = true;
            assetTypeSelect.innerHTML = '<option value="">Select Asset Type First</option>';
        }

        const operationalStatus = document.getElementById("operationalStatus");
        if (operationalStatus) {
            operationalStatus.innerHTML = '<option value="">Select Status</option>';
        }

        // Reset all inputs and remove error styles
        document
            .querySelectorAll(
                "#assetModal input, #assetModal select, #assetModal textarea",
            )
            .forEach((el) => {
                el.classList.remove("error");
                el.disabled = false;

                if (el.type === "checkbox" || el.type === "radio") {
                    el.checked = false;
                } else {
                    el.value = "";
                }

                // Remove error messages
                const errorMsg = el.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains("error-message")) {
                    errorMsg.remove();
                }
            });

        // Hide all technical spec groups
        document.querySelectorAll(".tech-group").forEach((group) => {
            group.style.display = "none";
        });

        // Disable fields in slides beyond slide 2
        for (let i = 3; i <= 7; i++) {
            document.querySelectorAll(`#slide${i} input, #slide${i} select, #slide${i} textarea`)
                .forEach((el) => {
                    el.disabled = true;
                });
        }

        // Reset button text
        const nextButton = document.querySelector(".next-btn, .submit-btn");
        if (nextButton) {
            nextButton.textContent = "Next";
            nextButton.className = "next-btn";
        }
    }

    /* ===============================
           BOOTSTRAP MODAL EVENT HANDLER
        =============================== */
    const assetModal = document.getElementById("assetModal");
    if (assetModal) {
        // When modal is about to be shown
        assetModal.addEventListener('show.bs.modal', function(event) {
            // Get the button that triggered the modal
            const button = event.relatedTarget;

            // Populate modal with data from button
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
        if (e.target.classList.contains("error")) {
            const value =
                e.target.tagName === "SELECT" ?
                e.target.value :
                e.target.value.trim();
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
        if (e.target.tagName === "SELECT" && e.target.classList.contains("error")) {
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
