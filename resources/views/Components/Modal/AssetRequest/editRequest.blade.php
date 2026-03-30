<div class="modal fade" id="editRequest{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content add-user-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    EDIT PURCHASE REQUISITION
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('asset-request.update', $item->id) }}" method="POST"
                id="assetRequestForm{{ $item->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <!-- requester -->
                    <h4 class="mb-3">Requester Information</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Requested By <span class="text-danger">*</span></label>
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <input type="hidden" class="form-control" value="{{ Auth::user()->name }}" readonly
                                name="requested_by">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <div class="fw-semibold">{{ Auth::user()->department }}</div>
                            <input type="hidden" class="form-control" value="{{ Auth::user()->department }}" readonly
                                name="department" required>
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
                                <option value="Physical Asset"
                                    {{ $item->asset_type == 'Physical Asset' ? 'selected' : '' }}>Physical Asset
                                </option>
                                <option value="Digital Asset"
                                    {{ $item->asset_type == 'Digital Asset' ? 'selected' : '' }}>Digital Asset</option>
                            </select>
                        </div>

                        <!-- type -->
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Asset Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="asset_category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ $item->asset_category == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- prefered model/specs -->
                        <div class="col-lg-12 mb-4">
                            <label class="form-label">
                                Preferred Model/Specs <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="model" value="{{ $item->model }}"
                                required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Priority Level</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="active{{ $item->id }}" value="low"
                                    {{ $item->priority == 'low' ? 'checked' : '' }} />
                                <label class="form-check-label" for="active{{ $item->id }}">
                                    Low
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="medium{{ $item->id }}" value="medium"
                                    {{ $item->priority == 'medium' ? 'checked' : '' }} />
                                <label class="form-check-label" for="medium{{ $item->id }}">
                                    Medium
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="high{{ $item->id }}" value="high"
                                    {{ $item->priority == 'high' ? 'checked' : '' }} />
                                <label class="form-check-label" for="high{{ $item->id }}">
                                    High
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="priority"
                                    id="emergency{{ $item->id }}" value="emergency"
                                    {{ $item->priority == 'emergency' ? 'checked' : '' }} />
                                <label class="form-check-label" for="emergency{{ $item->id }}">
                                    Emergency
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- justification -->
                    <h4 class="mb-3">Justification</h4>

                    <div class="mb-3">
                        <label class="form-label">Reason for Request <span class="text-danger">*</span></label>
                        <select class="form-select" name="request_reason" id="requestReason{{ $item->id }}"
                            required>
                            <option value="" disabled>Select reason</option>
                            <option value="New hire" {{ $item->request_reason == 'New hire' ? 'selected' : '' }}>New
                                hire</option>
                            <option value="Asset Replacement"
                                {{ $item->request_reason == 'Asset Replacement' ? 'selected' : '' }}>Asset Replacement
                            </option>
                            <option value="Project Requirement"
                                {{ $item->request_reason == 'Project Requirement' ? 'selected' : '' }}>Project
                                Requirement</option>
                            <option value="Upgrade" {{ $item->request_reason == 'Upgrade' ? 'selected' : '' }}>Upgrade
                            </option>
                            <option value="other"
                                {{ !in_array($item->request_reason, ['New hire', 'Asset Replacement', 'Project Requirement', 'Upgrade']) ? 'selected' : '' }}>
                                Other</option>
                        </select>
                    </div>

                    <!-- Other Reason Input (Hidden by default) -->
                    <div class="mb-3" id="otherReasonContainer{{ $item->id }}"
                        style="display: {{ !in_array($item->request_reason, ['New hire', 'Asset Replacement', 'Project Requirement', 'Upgrade']) ? 'block' : 'none' }};">
                        <label class="form-label">
                            Specify Other Reason <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="other_reason_input{{ $item->id }}"
                            placeholder="Please specify the reason..." name="other_reason"
                            value="{{ !in_array($item->request_reason, ['New hire', 'Asset Replacement', 'Project Requirement', 'Upgrade']) ? $item->request_reason : '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Detailed Purpose <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" rows="4" placeholder="Enter detailed purpose..." name="detailed_reason"
                            required>{{ $item->detailed_reason }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Remarks <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" rows="4" placeholder="Enter remarks..." name="remarks" required>{{ $item->remarks }}</textarea>
                    </div>
                </div>

                <!-- modal footer -->
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle each modal separately using unique IDs
        @foreach ($items as $editItem)
            {
                const requestReasonSelect{{ $editItem->id }} = document.getElementById(
                    'requestReason{{ $editItem->id }}');
                const otherReasonContainer{{ $editItem->id }} = document.getElementById(
                    'otherReasonContainer{{ $editItem->id }}');
                const otherReasonInput{{ $editItem->id }} = document.getElementById(
                    'other_reason_input{{ $editItem->id }}');
                const assetRequestForm{{ $editItem->id }} = document.getElementById(
                    'assetRequestForm{{ $editItem->id }}');

                if (requestReasonSelect{{ $editItem->id }}) {
                    // Add event listener for reason selection
                    requestReasonSelect{{ $editItem->id }}.addEventListener('change', function() {
                        if (this.value === 'other') {
                            // Show the other reason input
                            otherReasonContainer{{ $editItem->id }}.style.display = 'block';
                            otherReasonInput{{ $editItem->id }}.required = true;
                        } else {
                            // Hide the other reason input
                            otherReasonContainer{{ $editItem->id }}.style.display = 'none';
                            otherReasonInput{{ $editItem->id }}.required = false;
                            otherReasonInput{{ $editItem->id }}.value = ''; // Clear the input
                        }
                    });

                    // Form submission handler
                    if (assetRequestForm{{ $editItem->id }}) {
                        assetRequestForm{{ $editItem->id }}.addEventListener('submit', function(e) {
                            const selectedReason = requestReasonSelect{{ $editItem->id }}.value;

                            if (selectedReason === 'other') {
                                const otherReasonValue = otherReasonInput{{ $editItem->id }}.value
                                    .trim();

                                if (!otherReasonValue) {
                                    e.preventDefault(); // Prevent form submission
                                    alert('Please specify the other reason');
                                    otherReasonInput{{ $editItem->id }}.focus();
                                    return;
                                }

                                // Update the select dropdown value to the custom reason
                                const tempOption = document.createElement('option');
                                tempOption.value = otherReasonValue;
                                tempOption.textContent = otherReasonValue;
                                tempOption.selected = true;

                                // Remove the "other" option and add the custom value
                                requestReasonSelect{{ $editItem->id }}.innerHTML = '';
                                requestReasonSelect{{ $editItem->id }}.appendChild(tempOption);
                            }
                        });
                    }
                }
            }
        @endforeach

        // Reset the form when modal is closed
        @foreach ($items as $editItem)
            {
                const modal = document.getElementById('editRequest{{ $editItem->id }}');
                if (modal) {
                    modal.addEventListener('hidden.bs.modal', function() {
                        // Reset to initial state
                        const otherReasonContainer = document.getElementById(
                            'otherReasonContainer{{ $editItem->id }}');
                        const otherReasonInput = document.getElementById(
                            'other_reason_input{{ $editItem->id }}');
                        const requestReasonSelect = document.getElementById(
                            'requestReason{{ $editItem->id }}');

                        if (otherReasonContainer) otherReasonContainer.style.display = 'none';
                        if (otherReasonInput) {
                            otherReasonInput.value = '';
                            otherReasonInput.required = false;
                        }

                        // Reset the select dropdown to initial options
                        if (requestReasonSelect) {
                            requestReasonSelect.innerHTML = `
                            <option value="" disabled>Select reason</option>
                            <option value="New hire">New hire</option>
                            <option value="Asset Replacement">Asset Replacement</option>
                            <option value="Project Requirement">Project Requirement</option>
                            <option value="Upgrade">Upgrade</option>
                            <option value="other">Other</option>
                        `;
                            requestReasonSelect.value = '';
                            requestReasonSelect.required = true;
                        }
                    });
                }
            }
        @endforeach
    });
</script>
