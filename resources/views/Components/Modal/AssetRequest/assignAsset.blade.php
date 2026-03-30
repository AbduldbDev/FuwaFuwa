<div class="modal fade" id="assignModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('assets.assignAsset') }}" method="POST" id="assetForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <i class="fa-solid fa-square-plus me-2"></i>
                    <h5 class="modal-title fw-semibold">ASSIGN ASSET</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">
                    <!-- Only Slide 1 - Assignment & Location -->
                    <div>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <h6>Assignment & Location</h6>
                        </div>

                        <!-- Asset Search Section -->
                        <div class="mb-3">
                            <label class="form-label">Select Asset <span class="text-danger">*</span></label>
                            <input type="text" id="assignAssetSearch" class="form-control"
                                placeholder="Click to search asset..." autocomplete="off" readonly>
                            <div id="assignAssetSuggestions" class="list-group mt-1"
                                style="max-height:300px; overflow-y:auto; display:none;"></div>

                            <!-- Hidden input to store selected asset ID -->
                            <input type="hidden" name="asset_id" id="assignSelectedAssetId">
                            <input type="hidden" name="request_id" id="assignRequestIdInput">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assigned To</label>
                            <select class="form-control" name="assigned_to" id="assignAssignedTo">
                                <option value="">Select Employee</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}" data-department="{{ $user->department }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" name="department" id="assignDepartment" readonly
                                placeholder="Select Employee First">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="next-btn" onclick="submitAssignForm()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    $jsAssets = $AvailableAsset->map(function ($asset) {
        $displayName = $asset->asset_name;

        // Get asset_tag
        $assetTag = $asset->asset_tag ?? '';

        return [
            'id' => $asset->id,
            'asset_name' => $displayName,
            'asset_category' => $asset->asset_category,
            'asset_type' => $asset->asset_type,
            'asset_tag' => $assetTag,
        ];
    });
@endphp

<script>
    let assignSelectedAsset = null;

    // Function to submit the form
    function submitAssignForm() {
        if (!assignSelectedAsset) {
            alert("Please select an asset!");
            return;
        }
        document.querySelector('#assignModal #assetForm').submit();
    }

    // Function to format asset display text
    function formatAssetDisplay(asset) {
        let displayText =
            `${asset.asset_name || 'N/A'} (${asset.asset_category || 'N/A'}) (${asset.asset_type || 'N/A'})`;
        if (asset.asset_tag) {
            displayText += ` [${asset.asset_tag}]`;
        }
        return displayText;
    }

    // Function to pre-select asset by tag
    function selectAssetByTag(assetTag, availableAssets, searchInput, selectedAssetIdInput, suggestions) {
        if (!assetTag) return;

        // Find asset with matching tag
        const matchedAsset = availableAssets.find(a => a.asset_tag === assetTag);

        if (matchedAsset) {
            // Set the search input value to the formatted display text
            searchInput.value = formatAssetDisplay(matchedAsset);

            // Set the selected asset
            assignSelectedAsset = matchedAsset;

            // Set the hidden input value
            if (selectedAssetIdInput) {
                selectedAssetIdInput.value = matchedAsset.id;
            }

            // Clear any suggestions
            if (suggestions) {
                suggestions.innerHTML = '';
                suggestions.style.display = 'none';
            }
        }
    }

    // Function to update department based on selected user
    function updateDepartmentFromUser(selectElement, departmentInput) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const department = selectedOption.getAttribute('data-department') || '';
        departmentInput.value = department;
    }

    // Initialize Assign Modal
    document.addEventListener('DOMContentLoaded', () => {
        const assignModal = document.getElementById('assignModal');
        const searchInput = document.getElementById('assignAssetSearch');
        const suggestions = document.getElementById('assignAssetSuggestions');
        const selectedAssetIdInput = document.getElementById('assignSelectedAssetId');
        const requestIdInput = document.getElementById('assignRequestIdInput');
        const assignedToSelect = document.getElementById('assignAssignedTo');
        const departmentInput = document.getElementById('assignDepartment');

        const availableAssets = @json($jsAssets);

        if (assignModal) {
            assignModal.addEventListener('show.bs.modal', (event) => {
                // Reset form
                if (searchInput) searchInput.value = '';
                if (suggestions) {
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'none';
                }
                if (selectedAssetIdInput) selectedAssetIdInput.value = '';
                if (requestIdInput) requestIdInput.value = '';
                if (assignedToSelect) assignedToSelect.value = '';
                if (departmentInput) departmentInput.value = '';
                assignSelectedAsset = null;

                // Get the button that triggered the modal
                const button = event.relatedTarget;
                if (button) {
                    const requestId = button.getAttribute('data-request-id');
                    if (requestId && requestIdInput) {
                        requestIdInput.value = requestId;
                    }

                    // Get the asset tag from the button
                    const assetTag = button.getAttribute('data-asset-tag');
                    if (assetTag && searchInput && selectedAssetIdInput) {
                        // Pre-select the asset with this tag
                        selectAssetByTag(assetTag, availableAssets, searchInput, selectedAssetIdInput,
                            suggestions);
                    }
                }
            });

            // Update department when user is selected
            if (assignedToSelect && departmentInput) {
                assignedToSelect.addEventListener('change', function() {
                    updateDepartmentFromUser(this, departmentInput);
                });
            }

            // Show all assets when the search input is clicked
            if (searchInput) {
                searchInput.addEventListener('click', () => {
                    // Show all available assets
                    suggestions.innerHTML = '';

                    if (availableAssets.length === 0) {
                        const noItem = document.createElement('a');
                        noItem.className = 'list-group-item list-group-item-action disabled';
                        noItem.href = '#';
                        noItem.textContent = 'No assets available';
                        noItem.style.cursor = 'default';
                        suggestions.appendChild(noItem);
                        suggestions.style.display = 'block';
                        return;
                    }

                    availableAssets.forEach(asset => {
                        const item = document.createElement('a');
                        item.className = 'list-group-item list-group-item-action';
                        item.href = '#';

                        // Format the display text using the same format function
                        item.textContent = formatAssetDisplay(asset);

                        item.addEventListener('click', (e) => {
                            e.preventDefault();

                            // Set the search input value to the formatted display text
                            searchInput.value = formatAssetDisplay(asset);

                            assignSelectedAsset = asset;
                            if (selectedAssetIdInput) selectedAssetIdInput.value = asset
                                .id;
                            if (suggestions) suggestions.style.display = 'none';
                        });
                        suggestions.appendChild(item);
                    });

                    suggestions.style.display = 'block';
                });
            }
        }
    });
</script>
