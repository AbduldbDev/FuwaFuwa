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

                     <div class="mb-3">
                         <label class="form-label">Select Icon</label>
                         <select class="form-select" name="icon">
                             <option value="">Choose icon</option>

                             <!-- Hardware / Physical -->
                             <option value="fa-desktop" {{ $item->icon == 'fa-desktop' ? 'selected' : '' }}>Desktop (PC)
                             </option>
                             <option value="fa-laptop" {{ $item->icon == 'fa-laptop' ? 'selected' : '' }}>Laptop
                             </option>
                             <option value="fa-server" {{ $item->icon == 'fa-server' ? 'selected' : '' }}>Server
                             </option>
                             <option value="fa-network-wired" {{ $item->icon == 'fa-network-wired' ? 'selected' : '' }}>
                                 Network</option>
                             <option value="fa-wifi" {{ $item->icon == 'fa-wifi' ? 'selected' : '' }}>Router
                             </option>
                             <option value="fa-shield-halved" {{ $item->icon == 'fa-shield-halved' ? 'selected' : '' }}>
                                 Firewall</option>
                             <option value="fa-plug" {{ $item->icon == 'fa-plug' ? 'selected' : '' }}>Modem</option>
                             <option value="fa-box" {{ $item->icon == 'fa-box' ? 'selected' : '' }}>Equipment</option>
                             <option value="fa-warehouse" {{ $item->icon == 'fa-warehouse' ? 'selected' : '' }}>
                                 Warehouse</option>

                             <!-- Digital -->
                             <option value="fa-key" {{ $item->icon == 'fa-key' ? 'selected' : '' }}>License / Key
                             </option>
                             <option value="fa-file-code" {{ $item->icon == 'fa-file-code' ? 'selected' : '' }}>
                                 Software</option>
                             <option value="fa-database" {{ $item->icon == 'fa-database' ? 'selected' : '' }}>Database
                             </option>
                             <option value="fa-cloud" {{ $item->icon == 'fa-cloud' ? 'selected' : '' }}>Cloud Asset
                             </option>

                             <!-- Maintenance / Status -->
                             <option value="fa-screwdriver-wrench"
                                 {{ $item->icon == 'fa-screwdriver-wrench' ? 'selected' : '' }}>Maintenance</option>
                             <option value="fa-tools" {{ $item->icon == 'fa-tools' ? 'selected' : '' }}>Tools</option>
                             <option value="fa-circle-check" {{ $item->icon == 'fa-circle-check' ? 'selected' : '' }}>
                                 Active</option>
                             <option value="fa-circle-xmark" {{ $item->icon == 'fa-circle-xmark' ? 'selected' : '' }}>
                                 Inactive</option>

                             <!-- People / Assignment -->
                             <option value="fa-user" {{ $item->icon == 'fa-user' ? 'selected' : '' }}>Assigned User
                             </option>
                             <option value="fa-users" {{ $item->icon == 'fa-users' ? 'selected' : '' }}>Department
                             </option>

                             <!-- Documents -->
                             <option value="fa-file" {{ $item->icon == 'fa-file' ? 'selected' : '' }}>Document</option>
                             <option value="fa-file-invoice" {{ $item->icon == 'fa-file-invoice' ? 'selected' : '' }}>
                                 Invoice</option>
                             <option value="fa-folder" {{ $item->icon == 'fa-folder' ? 'selected' : '' }}>Folder
                             </option>

                             <!-- Location -->
                             <option value="fa-location-dot" {{ $item->icon == 'fa-location-dot' ? 'selected' : '' }}>
                                 Location</option>
                             <option value="fa-building" {{ $item->icon == 'fa-building' ? 'selected' : '' }}>Office
                             </option>
                         </select>
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
