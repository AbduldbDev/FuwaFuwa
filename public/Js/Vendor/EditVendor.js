// NEW DOCUMENT
function addNewDocument(vendorId) {
    const name = document.getElementById(`newDocName${vendorId}`).value;
    const fileInput = document.getElementById(`newDocFile${vendorId}`);
    const expiry = document.getElementById(`newDocExpiry${vendorId}`).value;

    if (!name || !fileInput.files.length || !expiry) {
        alert("Please complete all document fields.");
        return;
    }

    const file = fileInput.files[0];
    const table = document.getElementById(`newDocTableBody${vendorId}`);
    const docId = "new_doc_" + Date.now();

    const row = document.createElement("tr");
    row.setAttribute("data-doc-id", docId);
    row.innerHTML = `
        <td>${name}</td>
        <td>${file.name}</td>
        <td>${expiry}</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeNewDocument('${vendorId}', '${docId}')">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
        <input type="hidden" name="new_documents[name][]" value="${name}">
        <input type="hidden" name="new_documents[expiry][]" value="${expiry}">
        <input type="hidden" name="new_documents[file_name][]" value="${file.name}">
    `;
    table.appendChild(row);

    fileInput.value = "";
    document.getElementById(`newDocName${vendorId}`).value = "";
    document.getElementById(`newDocExpiry${vendorId}`).value = "";
}

// NEW PURCHASE
function addNewPurchase(vendorId) {
    const poId = document.getElementById(`newPoId${vendorId}`).value;
    const item = document.getElementById(`newItemName${vendorId}`).value;
    const qty = document.getElementById(`newQuantity${vendorId}`).value;
    const cost = document.getElementById(`newCost${vendorId}`).value;
    const warranty = document.getElementById(
        `newWarrantyExpiry${vendorId}`,
    ).value;

    if (!poId || !item || !qty || !cost || !warranty) {
        alert("Please complete all purchase fields.");
        return;
    }

    const table = document.getElementById(`newPurchaseTableBody${vendorId}`);
    const purchaseId = "new_purchase_" + Date.now();

    const row = document.createElement("tr");
    row.setAttribute("data-purchase-id", purchaseId);
    row.innerHTML = `
        <td>${poId}</td>
        <td>${item}</td>
        <td>${qty}</td>
        <td>${cost}</td>
        <td>${warranty}</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeNewPurchase('${vendorId}', '${purchaseId}')">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
        <input type="hidden" name="new_purchases[order_id][]" value="${poId}">
        <input type="hidden" name="new_purchases[item_name][]" value="${item}">
        <input type="hidden" name="new_purchases[quantity][]" value="${qty}">
        <input type="hidden" name="new_purchases[cost][]" value="${cost}">
        <input type="hidden" name="new_purchases[expiration][]" value="${warranty}">
    `;
    table.appendChild(row);

    document.getElementById(`newPoId${vendorId}`).value = "";
    document.getElementById(`newItemName${vendorId}`).value = "";
    document.getElementById(`newQuantity${vendorId}`).value = "";
    document.getElementById(`newCost${vendorId}`).value = "";
    document.getElementById(`newWarrantyExpiry${vendorId}`).value = "";
}

// REMOVE EXISTING DOCUMENT
function removeExistingDocument(vendorId, docId) {
    const form = document.getElementById(`vendorForm${vendorId}`);
    if (
        !form.querySelector(
            `input[name="delete_documents[]"][value="${docId}"]`,
        )
    ) {
        const delInput = document.createElement("input");
        delInput.type = "hidden";
        delInput.name = "delete_documents[]";
        delInput.value = docId;
        form.appendChild(delInput);
    }

    const row = document.querySelector(
        `#existingDocTableBody${vendorId} tr[data-doc-id="${docId}"]`,
    );
    if (row) {
        row.style.opacity = "0.5";
        row.style.textDecoration = "line-through";
        row.querySelector("button").disabled = true;
    }
}

// REMOVE EXISTING PURCHASE
function removeExistingPurchase(vendorId, purchaseId) {
    const form = document.getElementById(`vendorForm${vendorId}`);
    if (
        !form.querySelector(
            `input[name="delete_purchases[]"][value="${purchaseId}"]`,
        )
    ) {
        const delInput = document.createElement("input");
        delInput.type = "hidden";
        delInput.name = "delete_purchases[]";
        delInput.value = purchaseId;
        form.appendChild(delInput);
    }

    const row = document.querySelector(
        `#existingPurchaseTableBody${vendorId} tr[data-purchase-id="${purchaseId}"]`,
    );
    if (row) {
        row.style.opacity = "0.5";
        row.style.textDecoration = "line-through";
        row.querySelector("button").disabled = true;
    }
}

// REMOVE NEW DOCUMENT/PURCHASE
function removeNewDocument(vendorId, docId) {
    const row = document.querySelector(
        `#newDocTableBody${vendorId} tr[data-doc-id="${docId}"]`,
    );
    if (row) row.remove();
}

function removeNewPurchase(vendorId, purchaseId) {
    const row = document.querySelector(
        `#newPurchaseTableBody${vendorId} tr[data-purchase-id="${purchaseId}"]`,
    );
    if (row) row.remove();
}
