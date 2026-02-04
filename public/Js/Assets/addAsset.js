let selectedCategory = "";
let selectedType = "";
let currentSlide = 1;

// function handleVendorChange(select) {
//     if (select.value === "__add_vendor__") {
//         window.location.href = "/vendors";
//     }
// }
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
            showError(assetName, "Asset Name is required");
            isValid = false;
            assetName.focus();
        }

        if (!operationalStatus.value) {
            operationalStatus.classList.add("error");
            showError(operationalStatus, "Operational Status is required");
            isValid = false;
            if (isValid) operationalStatus.focus();
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
        // Assignment & Location - no required fields
        return true;
    }

    if (currentSlide === 5) {
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

    if (currentSlide === 6) {
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
    if (currentSlide !== 6) return;

    const slide6 = document.getElementById("slide6");
    if (!slide6) return;

    const warrantyStartText = slide6.querySelector("#warranty_start_date");
    const warrantyEndText = slide6.querySelector("#warranty_end_date");
    const lastMaintenanceDiv = slide6
        .querySelector("#last_schedule_maintenance")
        ?.closest(".mb-3");

    if (selectedType === "License") {
        if (warrantyStartText) {
            warrantyStartText.textContent = "Activation Date";
        }

        if (warrantyEndText) {
            warrantyEndText.textContent = "Expiration Date";
        }

        if (lastMaintenanceDiv) lastMaintenanceDiv.remove();
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

    if (prev === 3) showTechnicalFields();
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
    const nextButton = document.querySelector(".next-btn");
    if (slideNumber === 6) {
        nextButton.textContent = "Submit";
        nextButton.classList.add("submit-btn");
        nextButton.classList.remove("next-btn");
    } else {
        nextButton.textContent = "Next";
        nextButton.classList.add("next-btn");
        nextButton.classList.remove("submit-btn");
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
