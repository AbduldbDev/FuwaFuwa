   <div class="modal fade" id="archiveAsset" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
           <div class="modal-content add-user-modal">
               <div class="modal-header">
                   <h5 class="modal-title fw-semibold">
                       <i class="fa-solid fa-box-archive me-2"></i>
                       Archive Asset
                   </h5>
                   <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
               </div>

               <div class="modal-body px-4">
                   <!-- asset specification -->
                   <div class="mb-3 d-flex align-items-center gap-2">
                       <i class="fa-regular fa-file-zipper"></i>
                       <h6>Reason for Asset Archival</h6>
                   </div>
                   <form id="deletForm" action="{{ route('assets.delete', $item->id) }}" method="POST">
                       @csrf
                       <div class="row">
                           <!-- status -->
                           <div class="col-md-12 mb-3">
                               <label class="form-label">Status <span class="text-danger">*</span></label>
                               <select class="form-select" name="delete_title" required>
                                   <option value="" selected disabled>Choose asset status</option>
                                   <option value="Lost">Lost</option>
                                   <option value="Damaged">Damaged</option>
                                   <option value="Decommissioned / Disposed">Decommissioned / Disposed</option>
                                   <option value="Retired">Retired</option>
                                   <option value="Others">Others</option>
                               </select>
                           </div>

                           <!-- reasons description -->
                           <div class="mb-3">
                               <label class="form-label">
                                   Reason Description <span class="text-danger">*</span>
                               </label>
                               <textarea class="form-control" rows="4" name="delete_reason" placeholder="Enter detailed purpose..." required></textarea>
                           </div>
                       </div>
                   </form>
               </div>

               <!-- modal footer -->
               <div class="modal-footer border-0 px-4 pb-4">
                   <button class="btn btn-danger px-4" data-bs-dismiss="modal">
                       Cancel
                   </button>
                   <button type="button" class="btn btn-success px-4"
                       onclick="document.getElementById('deletForm').submit()" type="button">
                       Submit
                   </button>
               </div>
           </div>
       </div>
   </div>
