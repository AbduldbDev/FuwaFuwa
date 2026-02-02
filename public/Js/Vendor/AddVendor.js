/* =========================
    ADD COMPLIANCE DOCUMENT
========================== */
function addDocument() {
    const name = document.getElementById("docName").value;
    const fileInput = document.getElementById("docFile");
    const expiry = document.getElementById("docExpiry").value;

    if (!name || !fileInput.files.length || !expiry) {
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
            <input type="hidden" name="documents[expiry][]" value="${expiry}">
            <!-- We'll handle the file differently -->
        </td>
        <td>${expiry}</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeDocument('${docId}')">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    `;

    table.appendChild(row);

    // Create a new file input for this specific file
    // We need to clone the file input to keep the file in the form submission
    const fileClone = fileInput.cloneNode(true);
    fileClone.name = "documents[file][]";
    fileClone.id = "";
    fileClone.style.display = "none";
    fileClone.removeAttribute("onchange"); // Remove any event handlers

    // Append the cloned file input to the form
    document.getElementById("vendorForm").appendChild(fileClone);

    // Reset the original file input for new entries
    fileInput.value = "";

    // reset other fields
    document.getElementById("docName").value = "";
    document.getElementById("docExpiry").value = "";
}

// Optional: Add remove document function
function removeDocument(docId) {
    const row = document.querySelector(`tr[data-doc-id="${docId}"]`);
    if (row) {
        row.remove();
    }
}

/* =========================
    ADD PURCHASE HISTORY
========================== */
function addPurchase() {
    const poId = document.getElementById("poId").value;
    const item = document.getElementById("itemName").value;
    const qty = document.getElementById("quantity").value;
    const cost = document.getElementById("cost").value;
    const warranty = document.getElementById("warrantyExpiry").value;

    if (!poId || !item || !qty || !cost || !warranty) {
        alert("Please complete all purchase fields.");
        return;
    }

    const table = document.getElementById("purchaseTableBody");

    // Generate a unique identifier for this purchase row
    const purchaseId =
        "purchase_" +
        Date.now() +
        "_" +
        Math.random().toString(36).substr(2, 9);

    const row = document.createElement("tr");
    row.setAttribute("data-purchase-id", purchaseId);
    row.innerHTML = `
            <td>${poId}</td>
            <td>${item}</td>
            <td>${qty}</td>
            <td>${cost}</td>
            <td>${warranty}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removePurchase('${purchaseId}')">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>

            <input type="hidden" name="purchases[po_id][]" value="${poId}">
            <input type="hidden" name="purchases[item][]" value="${item}">
            <input type="hidden" name="purchases[quantity][]" value="${qty}">
            <input type="hidden" name="purchases[cost][]" value="${cost}">
            <input type="hidden" name="purchases[expiration][]" value="${warranty}">
        `;

    table.appendChild(row);

    // reset fields
    document.getElementById("poId").value = "";
    document.getElementById("itemName").value = "";
    document.getElementById("quantity").value = "";
    document.getElementById("cost").value = "";
    document.getElementById("warrantyExpiry").value = "";
}

/* =========================
    REMOVE PURCHASE HISTORY
========================== */
function removePurchase(purchaseId) {
    const row = document.querySelector(`tr[data-purchase-id="${purchaseId}"]`);
    if (row) {
        row.remove();
    }
}
