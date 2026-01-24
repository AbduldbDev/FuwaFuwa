<div class="modal fade" id="requestAsset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content add-user-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    PURCHASE REQUISITION FORM
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('asset-request.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <!-- requester -->
                    <h4 class="mb-3">Requester Information</h4>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">
                                Requested By <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="requested_by"
                                value="{{ Auth::user()->name }}" readonly />
                        </div>

                        <div class="col-lg-6 mb-4">
                            <label class="form-label">
                                Department <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="department"
                                value="{{ Auth::user()->department }}" readonly />
                        </div>
                    </div>

                    <!-- asset specification -->
                    <h4 class="mb-3">Asset Specifications</h4>

                    <div class="row">
                        <!-- category -->
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Asset Category</label>
                            <select class="form-select" name="asset_category" required>
                                <option value="" selected disabled>Choose asset category</option>
                                <option>Physical Asset</option>
                                <option>Digital Asset</option>
                            </select>
                        </div>

                        <!-- type -->
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Asset Type</label>
                            <select class="form-select" name="asset_type" required>
                                <option value="" selected disabled>Choose asset type</option>
                                <option>PC</option>
                                <option>Laptop</option>
                                <option>Modem</option>
                                <option>Router</option>
                                <option>Server Cabinet</option>
                                <option>Communication Cabinet</option>
                            </select>
                        </div>

                        <!-- quantity -->
                        <div class="col-lg-6 mb-4">
                            <label class="form-label">
                                Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" name="quantity" required />
                        </div>

                        <!-- prefered model/specs -->
                        <div class="col-lg-6 mb-4">
                            <label class="form-label">
                                Preferred Model/Specs <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="model" required />
                        </div>
                    </div>

                    <!-- justification -->
                    <h4 class="mb-3">Justification</h4>

                    <div class="mb-3">
                        <label class="form-label">Reason for Request</label>
                        <select class="form-select" name="request_reason" required>
                            <option value="" selected disabled>Select reason</option>
                            <option>New hire</option>
                            <option>Asset Replacement</option>
                            <option>Project Requirement</option>
                            <option>Uprade</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Detailed Purpose <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" rows="4" placeholder="Enter detailed purpose..." name="detailed_reason" required></textarea>
                    </div>

                    <!-- budget -->
                    <h4 class="mb-3">Budget</h4>

                    <div class="mb-3">
                        <label class="form-label">
                            Estimated Cost <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" name="cost" required />
                    </div>

                    <!-- account status -->
                    <div class="mb-3">
                        <label class="form-label d-block">Priority Level</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="active" checked value="low" />
                                <label class="form-check-label" for="active">
                                    Low
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="inactive" value="medium" />
                                <label class="form-check-label" for="inactive">
                                    Medium
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="inactive" value="high" />
                                <label class="form-check-label" for="inactive">
                                    High
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="inactive" value="emergency" />
                                <label class="form-check-label" for="inactive">
                                    Emergency
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal footer -->
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-4">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
