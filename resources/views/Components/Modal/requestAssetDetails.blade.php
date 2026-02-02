  <div class="modal fade" id="requestDetailsModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-l modal-dialog-centered modal-dialog-scrollable">
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

                  <!-- ===== budget ===== -->
                  <section class="mb-4">
                      <h6 class="fw-semibold mb-3">
                          <i class="fa-solid fa-money-bill me-2 text-secondary"></i>
                          Budget
                      </h6>

                      <div>
                          <label class="form-label text-muted">Estimated Cost</label>
                          <div class="fw-semibold">₱ {{ number_format($item->cost, 2) }}</div>

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

                  <!-- ===== activity feed ===== -->
                  <form id="updateStatusForm-{{ $item->id }}"
                      action="{{ route('asset-request.statusupdate', $item->id) }}" method="POST">
                      @csrf
                      @method('PUT')

                      <select name="status" class="form-select mb-2">
                          @php
                              $statusMap = [
                                  'For Review' => ['Pending Approval'],
                                  'Pending Approval' => ['In Procurement'],
                                  'In Procurement' => ['Procured'],
                                  'Procured' => [],
                              ];
                              $current = $item->status;
                              $nextOptions = $statusMap[$current] ?? [];
                          @endphp

                          <option value="{{ $current }}" selected>{{ $current }}</option>
                          @foreach ($nextOptions as $status)
                              <option value="{{ $status }}">{{ $status }}</option>
                          @endforeach
                      </select>

                      <textarea name="remarks" class="form-control mb-2" placeholder="Add remarks...">{{ $item->remarks }}</textarea>

                      {{-- <button type="submit" class="btn btn-primary">Update Status</button> --}}
                  </form>

              </div>

              <!-- modal footer -->
              <div class="modal-footer">
                  <button class="btn btn-outline-secondary shadow-none" data-bs-dismiss="modal">Close</button>

                  @if (Auth::user()->canAccess('Asset Request', 'write') && Auth::user()->user_type === 'admin' && $item->is_added === 0)
                      @if ($item->status === 'Pending Approval')
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
                      @elseif($item->status === 'Procured')
                          <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                              data-bs-target="#assetModal" data-asset-type="{{ $item->asset_type }}"
                              data-asset-category="{{ $item->asset_category }}" data-asset-name="{{ $item->model }}"
                              data-quantity="{{ $item->quantity }}" data-cost="{{ $item->cost }}"
                              data-request-id="{{ $item->id }}">
                              <i class="fa-solid fa-plus me-1"></i> Add Asset
                          </button>
                      @else
                          <button type="submit" form="updateStatusForm-{{ $item->id }}"
                              class="btn btn-primary shadow-none">
                              <i class="fa-solid fa-pen me-1"></i> Update Status
                          </button>
                      @endif
                  @endif
              </div>

          </div>
      </div>
  </div>

  {{-- <script>
      document.addEventListener('DOMContentLoaded', function() {
          const statusSelect = document.getElementById('statusSelect');
          const nextStatus = document.getElementById('nextStatus');

          const statusMap = {
              'For Review': ['Pending Approval'],
              'Pending Approval': ['In Procurement'],
              'In Procurement': ['Procured'],
              'Procured': []
          };

          statusSelect.addEventListener('change', function() {
              const selected = this.value;

              // Clear existing options
              nextStatus.innerHTML = '<option selected disabled>Select next status</option>';

              // Add new options based on mapping
              if (statusMap[selected]) {
                  statusMap[selected].forEach(status => {
                      const option = document.createElement('option');
                      option.value = status;
                      option.textContent = status;
                      nextStatus.appendChild(option);
                  });
              }
          });
      });
  </script> --}}
