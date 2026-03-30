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
            '#slide2 input[name="asset_model"]',
        );
        const operationalStatus = document.querySelector(
            '#slide2 select[name="operational_status"]',
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
        // Technical Specifications - only validate visible fields
        const visibleTechGroup = document.querySelector(
            '.tech-group[style*="display: block"], .tech-group[style*="display:block"]',
        );
        if (!visibleTechGroup) {
            alert("Please select an asset type first.");
            return false;
        }

        // Get only visible required fields
        const visibleRequiredFields = visibleTechGroup.querySelectorAll(
            '[data-required="true"]:not([disabled])',
        );

        for (const field of visibleRequiredFields) {
            let value =
                field.tagName === "SELECT" ? field.value : field.value.trim();

            if (!value) {
                field.classList.add("error");
                showError(field, "This field is required");
                isValid = false;
                if (!document.querySelector(".error")) {
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
            showTechnicalFields();
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
    if (prev === 3) showTechnicalFields();

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

    // Show technical fields if on slide 3
    if (slideNumber === 3) {
        showTechnicalFields();
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

    const techGroup = document.querySelector(
        `.tech-group[data-type="${targetType}"]`,
    );
    if (techGroup) {
        techGroup.style.display = "block";
        // Enable all fields in visible group
        techGroup
            .querySelectorAll("input, select, textarea")
            .forEach((input) => {
                input.disabled = false;
            });
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
        } else {
        }
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
document.addEventListener("input", function (e) {
    if (e.target.classList.contains("error")) {
        const value =
            e.target.tagName === "SELECT"
                ? e.target.value
                : e.target.value.trim();
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
document.addEventListener("change", function (e) {
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
