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
                          <div class="col-12 col-md-6">
                              <label class="form-label text-muted">Requested By</label>
                              <div class="description-text fw-semibold">{{ $item->requested_by }}</div>
                          </div>
                          <div class="col-12 col-md-6">
                              <label class="form-label text-muted">Department</label>
                              <div class="description-text fw-semibold">{{ $item->department }}</div>
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
                          <div class="col-12 col-md-6 col-xl-6">
                              <label class="form-label text-muted">Asset Type</label>
                              <div class="description-text fw-semibold">{{ $item->asset_type }}</div>
                          </div>
                          <div class="col-12 col-md-6 col-xl-6">
                              <label class="form-label text-muted">Asset Category</label>
                              <div class="description-text fw-semibold">{{ $item->asset_category }}</div>
                          </div>
                          <div class="col-12 ">
                              <label class="form-label text-muted">
                                  Preferred Model / Specifications
                              </label>
                              <div class="description-text fw-semibold">
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
                          <div class="description-text fw-semibold"> {{ $item->request_reason }}</div>
                      </div>

                      <div>
                          <label class="form-label text-muted">Detailed Purpose</label>
                          <p class="description-text fw-semibold">
                              {{ $item->detailed_reason }}
                          </p>
                      </div>

                      <div>
                          <label class="form-label text-muted">Remarks</label>
                          <p class="description-text fw-semibold">
                              {{ $item->remarks }}
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
                  <button class="back-btn btn-outline-secondary shadow-none" data-bs-dismiss="modal">Close</button>

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

                      @if ($item->is_procured === 0)
                          <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                              data-bs-target="#assignModal" data-request-id="{{ $item->id }}"
                              data-asset-tag="{{ $item->asset_tag }}">
                              <i class="fa-solid fa-plus me-1"></i> Assign Asset
                          </button>
                      @endif
                  @endif

              </div>

          </div>
      </div>
  </div>
  <script>
      document.addEventListener('DOMContentLoaded', function() {

          const availableAssets = @json($AvailableAsset);

          initializeRequestDetailsSearch();

          function initializeRequestDetailsSearch() {

              const modals = document.querySelectorAll('[id^="requestDetailsModal"]');

              modals.forEach(modal => {

                  const modalId = modal.id;
                  const itemId = modalId.replace('requestDetailsModal', '');

                  let requestCategory = '';

                  const searchInput = document.getElementById(`assetSearch${itemId}`);
                  const suggestions = document.getElementById(`assetSuggestions${itemId}`);
                  const requestIdInput = document.getElementById(`requestIdInput${itemId}`);
                  const assetTagInput = document.getElementById(`assetTagValue${itemId}`);
                  const availableBtn = modal.querySelector('.btn-success[type="submit"]');

                  if (!searchInput || !suggestions || !assetTagInput) return;

                  let selectedAsset = null;

                  /* ----------------------------------------
                     Helper: Get Correct Display Name
                  -----------------------------------------*/
                  function getDisplayName(asset) {
                      let displayName = asset.asset_model || 'N/A';



                      return displayName;
                  }

                  function resetSearch() {
                      searchInput.value = '';
                      suggestions.innerHTML = '';
                      suggestions.style.display = 'none';
                      assetTagInput.value = '';
                      if (availableBtn) availableBtn.disabled = true;
                      selectedAsset = null;
                  }

                  /* ----------------------------------------
                     Modal Show Event
                  -----------------------------------------*/
                  modal.addEventListener('show.bs.modal', function(event) {

                      resetSearch();

                      const labels = modal.querySelectorAll('.text-muted');
                      labels.forEach(label => {
                          if (label.textContent.trim() === 'Asset Category') {
                              const valueElement = label.closest('.col-12')
                                  ?.querySelector('.fw-semibold');

                              if (valueElement) {
                                  requestCategory = valueElement.textContent.trim();
                              }
                          }
                      });

                      const button = event.relatedTarget;
                      if (button) {
                          const requestId = button.getAttribute('data-request-id');
                          if (requestId && requestIdInput) {
                              requestIdInput.value = requestId;
                          }
                      }
                  });

                  /* ----------------------------------------
                     Search Input Event
                  -----------------------------------------*/
                  searchInput.addEventListener('input', function() {

                      const query = this.value.toLowerCase().trim();
                      suggestions.innerHTML = '';

                      if (!query) {
                          suggestions.style.display = 'none';
                          assetTagInput.value = '';
                          if (availableBtn) availableBtn.disabled = true;
                          selectedAsset = null;
                          return;
                      }

                      // Filter by category first
                      let filteredByCategory = availableAssets.filter(asset =>
                          asset.asset_category === requestCategory
                      );

                      // Filter by search query
                      const filtered = filteredByCategory.filter(asset => {
                          const displayName = getDisplayName(asset).toLowerCase();
                          return (
                              displayName.includes(query) ||
                              (asset.asset_type?.toLowerCase() || '').includes(
                                  query) ||
                              (asset.asset_tag?.toLowerCase() || '').includes(query)
                          );
                      });

                      // No category match
                      if (filteredByCategory.length === 0) {
                          const noCategoryItem = document.createElement('a');
                          noCategoryItem.className =
                              'list-group-item list-group-item-action disabled';
                          noCategoryItem.href = '#';
                          noCategoryItem.textContent =
                              `No in-stock assets available with category: ${requestCategory}`;
                          suggestions.appendChild(noCategoryItem);
                          suggestions.style.display = 'block';
                          return;
                      }

                      /* ----------------------------------------
                         Create Suggestion Items
                      -----------------------------------------*/
                      filtered.forEach(asset => {

                          const item = document.createElement('a');
                          item.className = 'list-group-item list-group-item-action';
                          item.href = '#';

                          const displayName = getDisplayName(asset);
                          const formattedValue =
                              `${asset.asset_tag || 'NO-TAG'} : ${displayName}`;

                          // Display in dropdown
                          item.textContent = formattedValue;

                          item.addEventListener('click', function(e) {
                              e.preventDefault();

                              // Use same format in input
                              searchInput.value = formattedValue;
                              selectedAsset = asset;

                              assetTagInput.value = asset.asset_tag || asset.id;

                              if (availableBtn) availableBtn.disabled = false;

                              suggestions.style.display = 'none';
                          });

                          suggestions.appendChild(item);
                      });

                      // No search match
                      if (filtered.length === 0 && filteredByCategory.length > 0) {
                          const noResultsItem = document.createElement('a');
                          noResultsItem.className =
                              'list-group-item list-group-item-action disabled';
                          noResultsItem.href = '#';
                          noResultsItem.textContent =
                              `No assets matching "${query}" in category: ${requestCategory}`;
                          suggestions.appendChild(noResultsItem);
                      }

                      suggestions.style.display =
                          (filtered.length > 0 || filteredByCategory.length === 0) ?
                          'block' :
                          'none';
                  });

                  searchInput.addEventListener('keydown', function(e) {
                      if (e.key === 'Escape') {
                          suggestions.style.display = 'none';
                      }
                  });

                  document.addEventListener('click', function(e) {
                      if (!modal.contains(e.target)) {
                          suggestions.style.display = 'none';
                      }
                  });

              });
          }
      });
  </script>
