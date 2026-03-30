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

                        <div class="row mb-2">
                            <div class="col-12 col-md-6 mb-2">
                                <div class="asset-option" onclick="selectCategory('Physical Asset', this)">
                                    <i class="fa-solid fa-box"></i>
                                    <h6>Physical Asset</h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
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
                            <label class="form-label">Asset Model <span class="text-danger">*</span></label>
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
                    <div id="slide5" style="display: none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-tools"></i>
                            <h6>Maintenance & Audit</h6>
                        </div>

                        <div class="mb-3" style="display: none">
                            <label class="form-label">Compliance Status <span class="text-danger">*</span></label>
                            <select class="form-select">
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
                    <button type="button" class="back-btn" onclick="prevSlide()">
                        Back
                    </button>
                    <button type="button" class="next-btn" onclick="nextSlide()">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    let selectedCategory = "";
    let selectedType = "";
    let currentSlide = 1;

    function handleVendorChange(select) {
        if (select.value === "__add_vendor__") {
            window.location.href = "/vendors";
        }
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

    const assetTypes = @json(
        $categories->groupBy('type')->map(function ($group) {
            return $group->pluck('name')->toArray();
        }));

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

        // Special handling for each slide
        if (currentSlide === 1) {
            return validateSlide1();
        }

        if (currentSlide === 2) {
            // Basic Information slide
            const assetName = document.querySelector(
                '#slide2 input[name="asset_name"]',
            );
            const operationalStatus = document.querySelector(
                '#slide2 select[name="operational_status"]',
            );

            if (!assetName.value.trim()) {
                assetName.classList.add("error");
                showError(assetName, "Asset model is required");
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
        // Don't check currentSlide here - let it run whenever called
        const slide5 = document.getElementById("slide5"); // Note: this is for Maintenance & Audit (slide 5)
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
            case 1: // Asset Category and Type
                selectedType = document.getElementById("assetType").value;
                document.getElementById("summaryCategory").value = selectedCategory;
                document.getElementById("summaryType").value = selectedType;

                populateOperationalStatus();
                showSlide(2);
                break;

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
                showSlide(6); // Documents

                break;

            case 6: // Documents
                if (!validateDocuments()) return;
                showSlide(7); // Assignment & Location
                break;

            case 7: // Assignment & Location (final slide)
                // Disable hidden tech-group inputs before submission

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
        // Handle going back from Basic Information (slide 2) to Category/Type (slide 1)
        else if (currentSlide === 2) {
            prev = 1;
        }

        if (prev < 1) return; // prevent going before first slide

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

        // Show technical fields when going back to slide 3

        // Handle special cases when going back to certain slides
        if (prev === 5) handleSlide5Extras();
        if (prev === 6) handleSlide6Extras();
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


        if (slideNumber === 4) {
            handleSlide5Extras();
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
        currentSlide = 1;

        // Hide all slides except slide 1
        document.querySelectorAll('[id^="slide"]').forEach((slide, index) => {
            slide.style.display = index === 0 ? "block" : "none";
        });

        // Reset asset options
        document
            .querySelectorAll(".asset-option")
            .forEach((opt) => opt.classList.remove("active"));

        const assetTypeSelect = document.getElementById("assetType");
        assetTypeSelect.disabled = true;
        assetTypeSelect.innerHTML =
            '<option value="">Select Asset Type First</option>';

        const operationalStatus = document.getElementById("operationalStatus");
        if (operationalStatus)
            operationalStatus.innerHTML = '<option value="">Select Status</option>';

        // Reset all inputs and remove error styles
        document
            .querySelectorAll(
                "#assetModal input, #assetModal select, #assetModal textarea",
            )
            .forEach((el) => {
                el.classList.remove("error");
                el.disabled = false; // Enable all fields first

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

        // Reset department field state
        const departmentSelect = document.getElementById("departmentdropdown");
        if (departmentSelect) {
            departmentSelect.value = "";
            departmentSelect.disabled = false;
            departmentSelect.style.backgroundColor = "";
            departmentSelect.style.cursor = "";
        }

        // Reset assigned to select
        const assignedToSelect = document.getElementById("assignedTo");
        if (assignedToSelect) {
            assignedToSelect.value = "";
        }

        // Hide all technical spec groups
        document.querySelectorAll(".tech-group").forEach((group) => {
            group.style.display = "none";
        });

        // Disable all fields except in slide 1
        document
            .querySelectorAll(
                "#slide2 input, #slide2 select, #slide2 textarea, " +
                "#slide3 input, #slide3 select, #slide3 textarea, " +
                "#slide4 input, #slide4 select, #slide4 textarea, " +
                "#slide5 input, #slide5 select, #slide5 textarea, " +
                "#slide6 input, #slide5 select, #slide5 textarea, " +
                "#slide7 input, #slide6 select, #slide6 textarea",
            )
            .forEach((el) => {
                el.disabled = true;
            });

        // Reset button text
        const nextButton = document.querySelector(".next-btn, .submit-btn");
        if (nextButton) {
            nextButton.textContent = "Next";
            nextButton.className = "next-btn";
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
