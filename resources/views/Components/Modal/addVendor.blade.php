  <div class="modal fade" id="addVendorModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content add-user-modal">
              <div class="modal-header">
                  <i class="fa-solid fa-plus me-2"></i>
                  <h5 class="modal-title fw-semibold">ADD NEW VENDOR</h5>
                  <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body px-4">
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
                          <input type="text" class="form-control" />
                      </div>

                      <div class="col-lg-6 mb-3">
                          <label class="form-label">
                              Contact Person <span class="text-danger">*</span>
                          </label>
                          <input type="email" class="form-control" />
                      </div>

                      <div class="col-lg-6">
                          <label class="form-label">
                              Contact Number <span class="text-danger">*</span>
                          </label>
                          <input type="tel" class="form-control" />
                      </div>

                      <div class="col-lg-6 ">
                          <label class="form-label">Status <span class="text-danger">*</span></label>

                          <select class="form-select">
                              <option selected disabled>Choose status</option>
                              <option>Active</option>
                              <option>Inactive</option>
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
                          <label class="form-label">
                              Document Name <span class="text-danger">*</span>
                          </label>
                          <input type="text" class="form-control" />
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">
                              Attach File <span class="text-danger">*</span>
                          </label>
                          <input type="file" class="form-control" required />
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">
                              Expiration date <span class="text-danger">*</span>
                          </label>
                          <input type="date" class="form-control" />
                      </div>
                  </div>

                  <div class="mb-5 table-responsive">
                      <table class="table align-middle mb-0 doc-table">
                          <thead>
                              <tr>
                                  <th>Document Name</th>
                                  <th>Attached File</th>
                                  <th>Expiration Date</th>
                              </tr>
                          </thead>

                          <tbody>
                              <tr>
                                  <td>
                                      <div class="d-flex align-items-center gap-2">
                                          Vendor Contract
                                      </div>
                                  </td>
                                  <td>
                                      <a href="uploads/very-long-vendor-contract-file-name-2026-final-version.pdf"
                                          target="_blank" class="file-link"
                                          title="very-long-vendor-contract-file-name-2026-final-version.pdf">
                                          <span class="file-name">
                                              very-long-vendor-contract-file-name-2026-final-version.pdf
                                          </span>
                                      </a>
                                  </td>
                                  <td>2026-03-15</td>
                              </tr>
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
                          <label class="form-label">
                              Purchase Order ID <span class="text-danger">*</span>
                          </label>
                          <input type="text" class="form-control" />
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">
                              Item Name <span class="text-danger">*</span>
                          </label>
                          <input type="text" class="form-control" />
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">
                              Quantity <span class="text-danger">*</span>
                          </label>
                          <input type="number" class="form-control" />
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">
                              Cost <span class="text-danger">*</span>
                          </label>
                          <input type="number" class="form-control" />
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">
                              Warranty Expiration date <span class="text-danger">*</span>
                          </label>
                          <input type="date" class="form-control" />
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
                              </tr>
                          </thead>

                          <tbody>
                              <tr>
                                  <td>
                                      PO-2025-0001
                                  </td>
                                  <td>
                                      pc
                                  </td>
                                  <td>5 pieces</td>
                                  <td>20.00</td>
                                  <td>2026-03-15</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>

              </div>

              <!-- modal footer -->
              <div class="modal-footer border-0 px-4 pb-4">
                  <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                      Cancel
                  </button>
                  <button type="button" class="btn btn-success px-4">
                      Save
                  </button>
              </div>
          </div>
      </div>
  </div>
