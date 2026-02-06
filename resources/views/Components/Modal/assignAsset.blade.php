<div class="modal fade" id="assignModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('assets.assignAsset') }}" method="POST" id="assetForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <i class="fa-solid fa-square-plus me-2"></i>
                    <h5 class="modal-title fw-semibold">ADD NEW ASSET</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">
                    <!-- ===== Slide 1 ===== -->
                    <div id="slide1">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-box"></i>
                            <h6>Asset Information</h6>
                        </div>

                        <!-- Searchable Asset Input -->
                        <div class="mb-3">
                            <label class="form-label">Select Asset <span class="text-danger">*</span></label>
                            <input type="text" id="assetSearch" class="form-control" placeholder="Search asset..."
                                autocomplete="off">
                            <div id="assetSuggestions" class="list-group mt-1"
                                style="max-height:150px; overflow-y:auto; display:none;"></div>

                            <!-- Hidden input to store selected asset ID -->
                            <input type="hidden" name="asset_id" id="selectedAssetId">
                            <input type="hidden" name="request_id" id="requestIdInput">
                        </div>
                    </div>

                    <!-- ===== Slide 2 ===== -->
                    <div id="slide2" style="display:none">
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <h6>Assignment & Location</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assigned To</label>
                            <input type="text" class="form-control" name="assigned_to" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department">
                                <option value="">Select department</option>
                                <option>IT Department</option>
                                <option>HR Department</option>
                                <option>Finance Department</option>
                                <option>Operations</option>
                                <option>Admin</option>
                            </select>
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
                    <button type="button" class="btn btn-secondary" onclick="prevAssignSlide()">Back</button>
                    <button type="button" class="next-btn" onclick="nextAssignSlide()">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    $jsAssets = $AvailableAsset->map(function ($asset) {
        $displayName =
            $asset->asset_type === 'Physical Asset'
                ? optional($asset->technicalSpecifications->firstWhere('spec_key', 'Asset_Model'))->spec_value
                : optional($asset->technicalSpecifications->firstWhere('spec_key', 'License_Name'))->spec_value;

        return [
            'id' => $asset->id,
            'asset_name' => $displayName,
            'asset_category' => $asset->asset_category,
            'asset_type' => $asset->asset_type,
        ];
    });
@endphp

<script>
    let assignModalSlide = 1;
    let selectedAsset = null;

    function showAssignSlide(slide) {
        document.querySelectorAll('#assignModal [id^="slide"]').forEach(el => el.style.display = 'none');
        const slideEl = document.querySelector('#assignModal #slide' + slide);
        if (slideEl) slideEl.style.display = 'block';

        const backBtn = document.querySelector('#assignModal .btn-secondary');
        const nextBtn = document.querySelector('#assignModal .next-btn');

        backBtn.style.display = slide === 1 ? 'none' : 'inline-block';
        nextBtn.textContent = slide === 2 ? 'Submit' : 'Next';

        assignModalSlide = slide;
    }

    function nextAssignSlide() {
        if (assignModalSlide === 1) {
            if (!selectedAsset) {
                alert("Please select an asset!");
                return;
            }
            showAssignSlide(2);
        } else {
            document.querySelector('#assignModal #assetForm').submit();
        }
    }

    function prevAssignSlide() {
        if (assignModalSlide === 2) showAssignSlide(1);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const assignModal = document.getElementById('assignModal');
        const searchInput = document.getElementById('assetSearch');
        const suggestions = document.getElementById('assetSuggestions');
        const selectedAssetIdInput = document.getElementById('selectedAssetId');

        const availableAssets = @json($jsAssets);

        assignModal.addEventListener('show.bs.modal', (event) => {
            assignModal.querySelector('#assetForm').reset();
            selectedAsset = null;
            selectedAssetIdInput.value = '';
            document.getElementById('requestIdInput').value = ''; // reset request id

            // Get the button that triggered the modal
            const button = event.relatedTarget;
            if (button) {
                const requestId = button.getAttribute('data-request-id');
                if (requestId) {
                    document.getElementById('requestIdInput').value = requestId;
                }
            }

            showAssignSlide(1);
            suggestions.style.display = 'none';
        });


        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase().trim();
            suggestions.innerHTML = '';
            if (!query) {
                suggestions.style.display = 'none';
                selectedAssetIdInput.value = '';
                selectedAsset = null;
                return;
            }

            const filtered = availableAssets.filter(a =>
                a.asset_name?.toLowerCase().includes(query) ||
                a.asset_category?.toLowerCase().includes(query) ||
                a.asset_type?.toLowerCase().includes(query)
            );

            filtered.forEach(a => {
                const item = document.createElement('a');
                item.className = 'list-group-item list-group-item-action';
                item.href = '#';
                item.textContent = `${a.asset_name} (${a.asset_category}, ${a.asset_type})`;
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    searchInput.value = a.asset_name;
                    selectedAsset = a;
                    selectedAssetIdInput.value = a.id; // store selected asset id
                    suggestions.style.display = 'none';
                });
                suggestions.appendChild(item);
            });

            suggestions.style.display = filtered.length ? 'block' : 'none';
        });

        document.addEventListener('click', (e) => {
            if (!assignModal.contains(e.target)) suggestions.style.display = 'none';
        });
    });
</script>
