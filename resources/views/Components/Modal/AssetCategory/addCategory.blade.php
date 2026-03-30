 <!-- Add category modal -->
 <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-md modal-dialog-centered">
         <div class="modal-content add-category-modal">
             <div class="modal-header">
                 <i class="fa-solid fa-boxes-stacked me-2"></i>
                 <h5 class="modal-title fw-semibold">Add New Category</h5>
                 <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
             </div>
             <form method="POST" action="{{ route('asset-categories.store') }}">
                 <div class="modal-body px-4">
                     <div class="mb-3 d-flex align-items-center gap-2">
                         <i class="fa-regular fa-user"></i>
                         <h6>Category Information</h6>
                     </div>
                     @csrf
                     <div class="mb-3">
                         <label class="form-label">
                             Category Name<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="name" class="form-control" placeholder="Enter category name" />
                     </div>

                     <div class="mb-3">
                         <label class="form-label">Select Icon</label>
                         <select class="form-select" name="icon">
                             <option value="">Choose icon</option>

                             <!-- Hardware / Physical -->
                             <option value="fa-desktop">Desktop (PC)</option>
                             <option value="fa-laptop">Laptop</option>
                             <option value="fa-server">Server</option>
                             <option value="fa-network-wired">Network</option>
                             <option value="fa-wifi">Router</option>
                             <option value="fa-shield-halved">Firewall</option>
                             <option value="fa-plug">Modem</option>
                             <option value="fa-box">Equipment</option>
                             <option value="fa-warehouse">Warehouse</option>

                             <!-- Digital -->
                             <option value="fa-key">License / Key</option>
                             <option value="fa-file-code">Software</option>
                             <option value="fa-database">Database</option>
                             <option value="fa-cloud">Cloud Asset</option>

                             <!-- Maintenance / Status -->
                             <option value="fa-screwdriver-wrench">Maintenance</option>
                             <option value="fa-tools">Tools</option>
                             <option value="fa-circle-check">Active</option>
                             <option value="fa-circle-xmark">Inactive</option>

                             <!-- People / Assignment -->
                             <option value="fa-user">Assigned User</option>
                             <option value="fa-users">Department</option>

                             <!-- Documents -->
                             <option value="fa-file">Document</option>
                             <option value="fa-file-invoice">Invoice</option>
                             <option value="fa-folder">Folder</option>

                             <!-- Location -->
                             <option value="fa-location-dot">Location</option>
                             <option value="fa-building">Office</option>
                         </select>
                     </div>

                     <div class=" mb-3">
                         <label class="form-label">Select Type <span class="text-danger">*</span></label>
                         <select class="form-select" name="type">
                             <option selected disabled>Choose type</option>
                             <option value="Physical Asset">Physical Asset</option>
                             <option value="Digital Asset">Digital Asset</option>
                         </select>
                     </div>

                 </div>

                 <!-- modal footer -->
                 <div class="modal-footer border-0 px-4 pb-4">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                         Cancel
                     </button>
                     <button type="submit" class="btn btn-success">
                         Save
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
