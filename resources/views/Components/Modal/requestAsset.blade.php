<div class="modal fade" id="requestAsset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content add-user-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    PURCHASE REQUISITION FORM
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('asset-request.store') }}" method="POST" id="assetRequestForm">
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
                            <label class="form-label">Asset Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="asset_type" required>
                                <option value="" selected disabled>Choose asset category</option>
                                <option>Physical Asset</option>
                                <option>Digital Asset</option>
                            </select>
                        </div>

                        <!-- type -->
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Asset Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="asset_category" required>
                                <option value="PC">PC</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Router">Router</option>
                                <option value="Firewall">Firewall</option>
                                <option value="Switch">Switch</option>
                                <option value="Modem">Modem</option>
                                <option value="Communication Cabinet">Communication Cabinet</option>
                                <option value="Server Cabinet">Server Cabinet</option>
                                <option value="License">License</option>

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
                        <label class="form-label">Reason for Request <span class="text-danger">*</span></label>
                        <select class="form-select" name="request_reason" id="requestReason" required>
                            <option value="" selected disabled>Select reason</option>
                            <option value="New hire">New hire</option>
                            <option value="Asset Replacement">Asset Replacement</option>
                            <option value="Project Requirement">Project Requirement</option>
                            <option value="Upgrade">Upgrade</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Other Reason Input (Hidden by default) -->
                    <div class="mb-3" id="otherReasonContainer" style="display: none;">
                        <label class="form-label">
                            Specify Other Reason <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="other_reason_input"
                            placeholder="Please specify the reason..." name="other_reason">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Detailed Purpose <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" rows="4" placeholder="Enter detailed purpose..." name="detailed_reason" required></textarea>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const requestReasonSelect = document.getElementById('requestReason');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        const otherReasonInput = document.getElementById('other_reason_input');
        const assetRequestForm = document.getElementById('assetRequestForm');

        // Add event listener for reason selection
        requestReasonSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                // Show the other reason input
                otherReasonContainer.style.display = 'block';
                otherReasonInput.required = true;
                requestReasonSelect.required = false; // Not required since we'll use other_reason
            } else {
                // Hide the other reason input
                otherReasonContainer.style.display = 'none';
                otherReasonInput.required = false;
                otherReasonInput.value = ''; // Clear the input
                requestReasonSelect.required = true; // Make select required again
            }
        });

        // Form submission handler
        assetRequestForm.addEventListener('submit', function(e) {
            const selectedReason = requestReasonSelect.value;

            if (selectedReason === 'other') {
                const otherReasonValue = otherReasonInput.value.trim();

                if (!otherReasonValue) {
                    e.preventDefault(); // Prevent form submission
                    alert('Please specify the other reason');
                    otherReasonInput.focus();
                    return;
                }

                // Update the select dropdown value to the custom reason
                // This will make it submit with the name="request_reason"
                const tempOption = document.createElement('option');
                tempOption.value = otherReasonValue;
                tempOption.textContent = otherReasonValue;
                tempOption.selected = true;

                // Remove the "other" option and add the custom value
                requestReasonSelect.innerHTML = '';
                requestReasonSelect.appendChild(tempOption);
            }
        });

        // Reset the form when modal is closed
        document.getElementById('requestAsset').addEventListener('hidden.bs.modal', function() {
            // Reset to initial state
            otherReasonContainer.style.display = 'none';
            otherReasonInput.value = '';
            otherReasonInput.required = false;

            // Reset the select dropdown to initial options
            requestReasonSelect.innerHTML = `
            <option value="" selected disabled>Select reason</option>
            <option value="New hire">New hire</option>
            <option value="Asset Replacement">Asset Replacement</option>
            <option value="Project Requirement">Project Requirement</option>
            <option value="Upgrade">Upgrade</option>
            <option value="other">Other</option>
        `;
            requestReasonSelect.required = true;
        });
    });
</script>

<script src="{{ asset('/Js/Assets/assetCategorySelect.js') }}"></script>
