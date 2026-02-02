<!-- EDIT VENDOR MODAL -->
<div class="modal fade" id="editVendorModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content add-user-modal">
            <div class="modal-header">
                <i class="fa-solid fa-pen me-2"></i>
                <h5 class="modal-title fw-semibold">EDIT VENDOR</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
                <form id="vendorForm{{ $item->id }}" action="{{ route('vendors.update', $item->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Vendor Basic Info -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-user"></i>
                        <h6>Basic Information</h6>
                    </div>
                    <div class="mb-5 row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $item->name }}"
                                required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_person"
                                value="{{ $item->contact_person }}" required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Contact Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="contact_email"
                                value="{{ $item->contact_email }}" required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="contact_number"
                                value="{{ $item->contact_number }}" required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="category" value="{{ $item->category }}"
                                required />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="" disabled>Choose status</option>
                                <option value="Active" {{ $item->status === 'Active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="Inactive" {{ $item->status === 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Existing Documents -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-file"></i>
                        <h6>Existing Compliance Documents</h6>
                    </div>
                    <div class="mb-5 table-responsive">
                        <table class="table align-middle mb-0 doc-table">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Attached File</th>
                                    <th>Expiration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="existingDocTableBody{{ $item->id }}">
                                @foreach ($item->documents as $index => $document)
                                    <tr data-doc-id="{{ $document->id }}">
                                        <td>{{ $document->name }}</td>
                                        <td>
                                            @if ($document->file)
                                                <a href="{{ asset('storage/' . $document->file) }}" target="_blank"
                                                    class="text-decoration-none"><i
                                                        class="fa-solid fa-file me-1"></i>View File</a>
                                            @else
                                                <span class="text-muted">No file</span>
                                            @endif
                                            <input type="hidden" name="existing_documents[{{ $index }}][id]"
                                                value="{{ $document->id }}">
                                            <input type="hidden" name="existing_documents[{{ $index }}][name]"
                                                value="{{ $document->name }}">
                                            <input type="hidden"
                                                name="existing_documents[{{ $index }}][expiration]"
                                                value="{{ $document->expiration }}">
                                        </td>
                                        <td>{{ $document->expiration }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="removeExistingDocument('{{ $item->id }}', '{{ $document->id }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Add New Documents -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-file-plus"></i>
                        <h6>Add New Compliance Document/s</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Document Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newDocName{{ $item->id }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Attach File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="newDocFile{{ $item->id }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Expiration date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="newDocExpiry{{ $item->id }}">
                        </div>
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="addNewDocument('{{ $item->id }}')">+ Add New Document</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 doc-table">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Attached File</th>
                                    <th>Expiration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="newDocTableBody{{ $item->id }}"></tbody>
                        </table>
                    </div>

                    <!-- Existing Purchase History -->
                    <div class="mb-3 d-flex align-items-center gap-2 mt-3">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <h6>Existing Purchase History</h6>
                    </div>
                    <div class="mb-5 table-responsive">
                        <table class="table align-middle mb-0 doc-table">
                            <thead>
                                <tr>
                                    <th>Purchase Order ID</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Warranty Expiration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="existingPurchaseTableBody{{ $item->id }}">
                                @foreach ($item->purchases as $index => $purchase)
                                    <tr data-purchase-id="{{ $purchase->id }}">
                                        <td>{{ $purchase->order_id }}</td>
                                        <td>{{ $purchase->item_name }}</td>
                                        <td>{{ $purchase->quantity }}</td>
                                        <td>{{ $purchase->cost }}</td>
                                        <td>{{ $purchase->expiration }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="removeExistingPurchase('{{ $item->id }}', '{{ $purchase->id }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>

                                        <input type="hidden" name="existing_purchases[{{ $index }}][id]"
                                            value="{{ $purchase->id }}">
                                        <input type="hidden" name="existing_purchases[{{ $index }}][po_id]"
                                            value="{{ $purchase->order_id }}">
                                        <input type="hidden"
                                            name="existing_purchases[{{ $index }}][item_name]"
                                            value="{{ $purchase->item_name }}">
                                        <input type="hidden"
                                            name="existing_purchases[{{ $index }}][quantity]"
                                            value="{{ $purchase->quantity }}">
                                        <input type="hidden" name="existing_purchases[{{ $index }}][cost]"
                                            value="{{ $purchase->cost }}">
                                        <input type="hidden"
                                            name="existing_purchases[{{ $index }}][expiration]"
                                            value="{{ $purchase->expiration }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Add New Purchases -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i>
                        <h6>Add New Purchase History</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Purchase Order ID</label>
                            <input type="text" class="form-control" id="newPoId{{ $item->id }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="newItemName{{ $item->id }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="newQuantity{{ $item->id }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Cost</label>
                            <input type="number" class="form-control" id="newCost{{ $item->id }}"
                                step="0.01">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Warranty Expiration date</label>
                            <input type="date" class="form-control" id="newWarrantyExpiry{{ $item->id }}">
                        </div>
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="addNewPurchase('{{ $item->id }}')">+ Add New Purchase</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 doc-table">
                            <thead>
                                <tr>
                                    <th>Purchase Order ID</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Warranty Expiration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="newPurchaseTableBody{{ $item->id }}"></tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success px-4"
                    form="vendorForm{{ $item->id }}">Update</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/js/Vendor/EditVendor.js') }}"></script>
