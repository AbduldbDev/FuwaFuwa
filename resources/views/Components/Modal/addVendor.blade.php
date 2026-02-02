<div class="modal fade" id="addVendorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content add-user-modal">
            <div class="modal-header">
                <i class="fa-solid fa-plus me-2"></i>
                <h5 class="modal-title fw-semibold">ADD NEW VENDOR</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
                <form id="vendorForm" action="{{ route('vendors.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- vendor basic information -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-user"></i>
                        <h6>Basic Information</h6>
                    </div>

                    <div class="mb-5 row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">
                                Vendor Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="name" />
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">
                                Contact Person <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="contact_person" />
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">
                                Contact Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" name="contact_email" />
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">
                                Contact Number <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control" name="contact_number" />
                        </div>

                        <div class="col-lg-6 ">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="category" />
                        </div>

                        <div class="col-lg-6 ">
                            <label class="form-label">Status <span class="text-danger">*</span></label>

                            <select class="form-select" name="status" required>
                                <option value="" selected disabled>Choose status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- compliance documents -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-file"></i>
                        <h6>Compliance Document/s</h6>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Document Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="docName">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Attach File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="docFile">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Expiration date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="docExpiry">
                        </div>

                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addDocument()">
                                + Add Document
                            </button>
                        </div>
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

                            <tbody id="docTableBody">

                            </tbody>
                        </table>
                    </div>

                    <!-- purchase history log inputs -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <h6>Purchase History Log</h6>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Purchase Order ID</label>
                            <input type="text" class="form-control" id="poId">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemName">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Cost</label>
                            <input type="number" class="form-control" id="cost">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Warranty Expiration date</label>
                            <input type="date" class="form-control" id="warrantyExpiry">
                        </div>

                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addPurchase()">
                                + Add Purchase
                            </button>
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

                            <tbody id="purchaseTableBody">

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <!-- modal footer -->
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-success px-4" form="vendorForm">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>
<script src="{{ asset('/Js/Vendor/AddVendor.js') }}?v={{ time() }}"></script>
