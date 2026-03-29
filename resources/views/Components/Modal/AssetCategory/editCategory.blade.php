 <div class="modal fade" id="editCategoryModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-md modal-dialog-centered">
         <div class="modal-content add-category-modal">
             <div class="modal-header">
                 <i class="fa-solid fa-boxes-stacked me-2"></i>
                 <h5 class="modal-title fw-semibold">Edit Category</h5>
                 <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
             </div>
             <form method="POST" action="{{ route('asset-categories.update', $item->id) }}">
                 @method('PUT')
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
                         <input type="text" name="name" class="form-control" placeholder="Enter category name"
                             value="{{ $item->name }}" />
                     </div>

                     <div class=" mb-3">
                         <label class="form-label">Select Type <span class="text-danger">*</span></label>
                         <select class="form-select" name="type">
                             <option selected disabled>Choose type</option>
                             <option value="Physical Asset" {{ $item->type == 'Physical Asset' ? 'selected' : '' }}>
                                 Physical Asset
                             </option>
                             <option value="Digital Asset" {{ $item->type == 'Digital Asset' ? 'selected' : '' }}>
                                 Digital Asset
                             </option>
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
