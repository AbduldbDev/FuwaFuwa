  <div class="modal fade" id="editVendorModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content add-user-modal">
              <div class="modal-header">
                  <i class="fa-solid fa-plus me-2"></i>
                  <h5 class="modal-title fw-semibold">EDIT VENDOR</h5>
                  <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body px-4">
                  <form id="vendorForm{{ $item->id }}" action="{{ route('vendors.update', $item->id) }}"
                      method="POST">
                      @csrf
                      @method('PUT')
                      <!-- vendor basic information -->
                      <div class="mb-3 d-flex align-items-center gap-2">
                          <i class="fa-regular fa-user"></i>
                          <h6>Basic Information</h6>
                      </div>

                      <div class=" row">
                          <div class="col-lg-6 mb-3">
                              <label class="form-label">
                                  Vendor Name <span class="text-danger">*</span>
                              </label>
                              <input type="text" class="form-control" name="name" value="{{ $item->name }}" />
                          </div>

                          <div class="col-lg-6 mb-3">
                              <label class="form-label">
                                  Contact Person <span class="text-danger">*</span>
                              </label>
                              <input type="text" class="form-control" name="contact_person"
                                  value="{{ $item->contact_person }}" />
                          </div>

                          <div class="col-lg-6 mb-3">
                              <label class="form-label">
                                  Contact Email <span class="text-danger">*</span>
                              </label>
                              <input type="email" class="form-control" name="contact_email"
                                  value="{{ $item->contact_email }}" />
                          </div>

                          <div class="col-lg-6 mb-3">
                              <label class="form-label">
                                  Contact Number <span class="text-danger">*</span>
                              </label>
                              <input type="tel" class="form-control" name="contact_number"
                                  value="{{ $item->contact_number }}" />
                          </div>

                          <div class="col-lg-6 ">
                              <label class="form-label">
                                  Category <span class="text-danger">*</span>
                              </label>
                              <input type="text" class="form-control" name="category"
                                  value="{{ $item->category }}" />
                          </div>

                          <div class="col-lg-6">
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

                  </form>
              </div>

              <!-- modal footer -->
              <div class="modal-footer border-0 px-4 pb-4">
                  <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                      Cancel
                  </button>
                  <button type="submit" class="btn btn-success px-4" form="vendorForm{{ $item->id }}">
                      Save
                  </button>
              </div>

          </div>
      </div>
  </div>
