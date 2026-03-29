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
                     <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
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
