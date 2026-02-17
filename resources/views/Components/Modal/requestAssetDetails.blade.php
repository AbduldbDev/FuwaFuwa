  <div class="modal fade" id="requestDetailsModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content rounded-3">
              <!-- modal header -->
              <div class="modal-header">
                  <h5 class="modal-title fw-semibold">
                      ASSET REQUEST DETAILS
                  </h5>
                  <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
              </div>

              <!-- modal body -->
              <div class="modal-body px-4">
                  <!-- ===== requester information ===== -->
                  <section class="mb-4">
                      <h6 class="fw-semibold mb-3">
                          <i class="fa-solid fa-user me-2 text-secondary"></i>
                          Requester Information
                      </h6>

                      <div class="row g-3">
                          <div class="col-md-6">
                              <label class="form-label text-muted">Requested By</label>
                              <div class="fw-semibold">{{ $item->requested_by }}</div>
                          </div>
                          <div class="col-md-6">
                              <label class="form-label text-muted">Department</label>
                              <div class="fw-semibold">{{ $item->department }}</div>
                          </div>
                      </div>
                  </section>

                  <hr />

                  <!-- ===== asset sepcification ===== -->
                  <section class="mb-4">
                      <h6 class="fw-semibold mb-3">
                          <i class="fa-solid fa-box me-2 text-secondary"></i>
                          Asset Specification
                      </h6>

                      <div class="row g-3">
                          <div class="col-lg-6">
                              <label class="form-label text-muted">Asset Type</label>
                              <div class="fw-semibold">{{ $item->asset_type }}</div>
                          </div>
                          <div class="col-lg-6">
                              <label class="form-label text-muted">Asset Category</label>
                              <div class="fw-semibold">{{ $item->asset_category }}</div>
                          </div>

                          <div class="col-lg-6">
                              <label class="form-label text-muted">Quantity</label>
                              <div class="fw-semibold">{{ $item->quantity }} Units</div>
                          </div>

                          <div class="col-lg-6">
                              <label class="form-label text-muted">
                                  Preferred Model / Specifications
                              </label>
                              <div class="fw-semibold">
                                  {{ $item->model }}
                              </div>
                          </div>
                      </div>
                  </section>

                  <hr />

                  <!-- ===== justification ===== -->
                  <section class="mb-4">
                      <h6 class="fw-semibold mb-3">
                          <i class="fa-solid fa-clipboard-list me-2 text-secondary"></i>
                          Justification
                      </h6>

                      <div class="mb-3">
                          <label class="form-label text-muted">Reason for Request</label>
                          <div> {{ $item->request_reason }}</div>
                      </div>

                      <div>
                          <label class="form-label text-muted">Detailed Purpose</label>
                          <p>
                              {{ $item->detailed_reason }}
                          </p>
                      </div>
                  </section>
                  <hr />
                  <!-- ===== priority ===== -->
                  <section class="mb-4">
                      <h6 class="fw-semibold mb-3">
                          <i class="fa-solid fa-flag me-2 text-secondary"></i>
                          Priority Level
                      </h6>

                      <span class="badge {{ $priorityClass }} px-3 py-2">
                          {{ ucfirst($item->priority) }} Priority
                      </span>

                  </section>
                  <hr />

                  @if ($item->status === 'For Review')
                      <section class="mb-4">
                          <label class="form-label">Select Asset <span class="text-danger">*</span></label>
                          <input type="text" id="assetSearch{{ $item->id }}" class="form-control"
                              placeholder="Search asset..." autocomplete="off">
                          <div id="assetSuggestions{{ $item->id }}" class="list-group mt-1"
                              style="max-height:300px; overflow-y:auto; display:none;"></div>

                          <!-- Hidden input to store selected asset ID -->
                          <input type="hidden" name="asset_id" id="selectedAssetId{{ $item->id }}">
                          <input type="hidden" name="request_id" id="requestIdInput{{ $item->id }}"
                              value="{{ $item->id }}">
                      </section>
                  @endif

                  <!-- ===== activity feed ===== -->
                  @php
                      $canEditStatus = in_array(Auth::user()->user_type, ['admin', 'encoder']);
                  @endphp

                  <form id="updateStatusForm-{{ $item->id }}"
                      action="{{ route('asset-request.statusupdate', $item->id) }}" method="POST">
                      @csrf
                      @method('PUT')

                      <select name="status" class="form-select mb-2" {{ $canEditStatus ? '' : 'disabled' }} required>
                          <option value="">SELECT STATUS</option>

                          @foreach (['For Review', 'In Progress', 'For Procurement', 'For Release'] as $status)
                              <option value="{{ $status }}" {{ $item->status === $status ? 'selected' : '' }}>
                                  {{ $status }}
                              </option>
                          @endforeach
                      </select>

                      @if ($canEditStatus)
                          <div class="text-right">
                              <button type="submit" class="btn save-btn w-100">
                                  Update Status
                              </button>
                          </div>
                      @endif
                  </form>

              </div>

              <!-- modal footer -->
              <div class="modal-footer">
                  <button class="btn btn-outline-secondary shadow-none" data-bs-dismiss="modal">Close</button>

                  {{-- ADMIN ACTIONS --}}
                  @if (Auth::user()->canAccess('Asset Request', 'write') && Auth::user()->user_type === 'admin')

                      @if ($item->status === 'For Review')
                          {{-- Not Available --}}
                          <form action="{{ route('asset-request.forreview', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="status" value="unavailable">

                              <button class="btn btn-danger shadow-none">
                                  <i class="fa-solid fa-check me-1"></i> Not Available
                              </button>
                          </form>

                          {{-- Available --}}
                          <form action="{{ route('asset-request.forreview', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="status" value="available">
                              <input type="hidden" name="asset_tag" id="assetTagValue{{ $item->id }}"
                                  value="">
                              <button class="btn btn-success shadow-none">
                                  <i class="fa-solid fa-xmark me-1"></i> Available
                              </button>
                          </form>
                      @elseif ($item->status === 'In Progress')
                          <form action="{{ route('asset-request.rejectStatus', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button class="btn btn-danger shadow-none">
                                  <i class="fa-solid fa-xmark me-1"></i> Reject
                              </button>
                          </form>

                          <form action="{{ route('asset-request.approveStatus', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button class="btn btn-success shadow-none">
                                  <i class="fa-solid fa-check me-1"></i> Approve
                              </button>
                          </form>
                      @elseif ($item->status === 'For Procurement')
                          <form action="{{ route('asset-request.rejectStatus', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button class="btn btn-danger shadow-none">
                                  <i class="fa-solid fa-xmark me-1"></i> Cancel
                              </button>
                          </form>

                          <form action="{{ route('asset-request.forreview', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="status" value="available">
                              <button class="btn btn-success shadow-none">
                                  <i class="fa-solid fa-check me-1"></i> Procured
                              </button>
                          </form>
                      @endif
                  @endif
                  @if (Auth::user()->canAccess('Asset Request', 'write') &&
                          in_array(Auth::user()->user_type, ['admin', 'encoder']) &&
                          $item->status === 'For Release')
                      @if ($item->is_added === 0)
                          <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                              data-bs-target="#assetModal" data-asset-type="{{ $item->asset_type }}"
                              data-asset-category="{{ $item->asset_category }}"
                              data-asset-name="{{ $item->model }}" data-quantity="{{ $item->quantity }}"
                              data-cost="{{ $item->cost }}" data-request-id="{{ $item->id }}">
                              <i class="fa-solid fa-plus me-1"></i> Add Asset
                          </button>
                      @endif

                      <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                          data-bs-target="#assignModal" data-request-id="{{ $item->id }}"
                          data-asset-tag="{{ $item->asset_tag }}">
                          <i class="fa-solid fa-plus me-1"></i> Assign Asset
                      </button>
                  @endif

              </div>

          </div>
      </div>
  </div>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Get all available assets from the PHP variable
          const availableAssets = @json($AvailableAsset);

          // Initialize search for all request details modals
          initializeRequestDetailsSearch();

          function initializeRequestDetailsSearch() {
              // Get all request details modals
              const modals = document.querySelectorAll('[id^="requestDetailsModal"]');

              modals.forEach(modal => {
                  // Extract the item ID from the modal ID
                  const modalId = modal.id;
                  const itemId = modalId.replace('requestDetailsModal', '');

                  // Get the request's asset category from the modal content
                  // Look for the Asset Category display in the modal body
                  const categoryElement = modal.querySelector('.col-lg-6 .fw-semibold');
                  // You might need to adjust the selector based on your actual HTML structure
                  // Alternative: Find by looking for the text "Asset Category" and then get the next div
                  let requestCategory = '';

                  // Method 1: Find by looking for the label text
                  const labels = modal.querySelectorAll('.text-muted');
                  labels.forEach(label => {
                      if (label.textContent.trim() === 'Asset Category') {
                          // Get the next element with class fw-semibold
                          const valueElement = label.closest('.col-lg-6')?.querySelector(
                              '.fw-semibold');
                          if (valueElement) {
                              requestCategory = valueElement.textContent.trim();
                          }
                      }
                  });

                  // Get elements for this specific modal using the item ID
                  const searchInput = document.getElementById(`assetSearch${itemId}`);
                  const suggestions = document.getElementById(`assetSuggestions${itemId}`);
                  const requestIdInput = document.getElementById(`requestIdInput${itemId}`);
                  const assetTagInput = document.getElementById(`assetTagValue${itemId}`);

                  // Get the Available button (if it exists in this modal)
                  const availableBtn = modal.querySelector('.btn-success[type="submit"]');

                  // Skip if elements don't exist
                  if (!searchInput || !suggestions || !assetTagInput) return;

                  // Variable to store selected asset for this modal
                  let selectedAsset = null;

                  // Function to reset search for this modal
                  function resetSearch() {
                      if (searchInput) searchInput.value = '';
                      if (suggestions) {
                          suggestions.innerHTML = '';
                          suggestions.style.display = 'none';
                      }
                      if (assetTagInput) assetTagInput.value = '';
                      if (availableBtn) availableBtn.disabled = true;
                      selectedAsset = null;
                  }

                  // Handle modal show event
                  modal.addEventListener('show.bs.modal', function(event) {
                      resetSearch();

                      // Re-fetch the request category when modal opens
                      const labels = modal.querySelectorAll('.text-muted');
                      labels.forEach(label => {
                          if (label.textContent.trim() === 'Asset Category') {
                              const valueElement = label.closest('.col-lg-6')
                                  ?.querySelector('.fw-semibold');
                              if (valueElement) {
                                  requestCategory = valueElement.textContent.trim();

                              }
                          }
                      });

                      // Get the button that triggered the modal
                      const button = event.relatedTarget;
                      if (button) {
                          const requestId = button.getAttribute('data-request-id');
                          if (requestId && requestIdInput) {
                              requestIdInput.value = requestId;
                          }
                      }
                  });

                  // Handle search input
                  searchInput.addEventListener('input', function() {
                      const query = this.value.toLowerCase().trim();

                      // Clear previous suggestions
                      suggestions.innerHTML = '';

                      if (!query) {
                          suggestions.style.display = 'none';
                          if (assetTagInput) assetTagInput.value = '';
                          if (availableBtn) availableBtn.disabled = true;
                          selectedAsset = null;
                          return;
                      }

                      // First filter by category matching the request's asset category
                      let filteredByCategory = availableAssets.filter(asset =>
                          asset.asset_category === requestCategory
                      );

                      // Then filter by search query
                      const filtered = filteredByCategory.filter(asset =>
                          (asset.asset_name?.toLowerCase() || '').includes(query) ||
                          (asset.asset_type?.toLowerCase() || '').includes(query) ||
                          (asset.asset_tag?.toLowerCase() || '').includes(query)
                      );

                      // If no results after category filter, show message
                      if (filteredByCategory.length === 0) {
                          const noCategoryItem = document.createElement('a');
                          noCategoryItem.className =
                              'list-group-item list-group-item-action disabled';
                          noCategoryItem.href = '#';
                          noCategoryItem.textContent =
                              `No in-stock assets available with category: ${requestCategory}`;
                          noCategoryItem.style.cursor = 'default';
                          suggestions.appendChild(noCategoryItem);
                          suggestions.style.display = 'block';
                          return;
                      }

                      // Create suggestion items
                      filtered.forEach(asset => {
                          const item = document.createElement('a');
                          item.className = 'list-group-item list-group-item-action';
                          item.href = '#';

                          // Display asset information including tag if available
                          let displayText =
                              `${asset.asset_name || 'N/A'} (${asset.asset_category || 'N/A'}) (${asset.asset_type || 'N/A'})`;
                          if (asset.asset_tag) {
                              displayText += ` [${asset.asset_tag}]`;
                          }
                          item.textContent = displayText;

                          // Handle suggestion click
                          item.addEventListener('click', function(e) {
                              e.preventDefault();

                              // Set the selected asset
                              searchInput.value = asset.asset_name || '';
                              selectedAsset = asset;

                              // Set the asset tag value in the hidden input
                              if (assetTagInput) {
                                  assetTagInput.value = asset.asset_tag || asset
                                      .id;

                                  // Enable the Available button since an asset is selected
                                  if (availableBtn) availableBtn.disabled = false;
                              }

                              // Hide suggestions
                              suggestions.style.display = 'none';
                          });

                          suggestions.appendChild(item);
                      });

                      // If no results after search query, show message
                      if (filtered.length === 0 && filteredByCategory.length > 0) {
                          const noResultsItem = document.createElement('a');
                          noResultsItem.className =
                              'list-group-item list-group-item-action disabled';
                          noResultsItem.href = '#';
                          noResultsItem.textContent =
                              `No assets matching "${query}" in category: ${requestCategory}`;
                          noResultsItem.style.cursor = 'default';
                          suggestions.appendChild(noResultsItem);
                      }

                      // Show or hide suggestions based on results
                      suggestions.style.display = (filtered.length > 0 || filteredByCategory
                          .length === 0) ? 'block' : 'none';
                  });

                  // Handle keyboard navigation (optional)
                  searchInput.addEventListener('keydown', function(e) {
                      if (e.key === 'Escape') {
                          suggestions.style.display = 'none';
                      }
                  });

                  // Close suggestions when clicking outside
                  document.addEventListener('click', function(e) {
                      if (!modal.contains(e.target)) {
                          suggestions.style.display = 'none';
                      }
                  });

                  // Prevent form submission when clicking on suggestions
                  if (suggestions) {
                      suggestions.addEventListener('click', function(e) {
                          e.preventDefault();
                      });
                  }
              });
          }
      });
  </script>
