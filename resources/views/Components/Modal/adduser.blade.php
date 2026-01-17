 <!-- Add user modal -->
 <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content add-user-modal">
             <div class="modal-header">
                 <h3 class="modal-title w-100 text-center fw-semibold">
                     ADD NEW USER
                 </h3>
                 <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
             </div>
             <form method="POST" action="{{ route('user-management.store') }}">
                 <div class="modal-body px-4">
                     <h4 class="mb-3">User Information</h4>

                     @csrf
                     <!-- employee id -->
                     <div class="mb-3">
                         <label class="form-label">
                             Employee ID <span class="text-danger">*</span>
                         </label>
                         <input type="text" name="employee_id" class="form-control" />
                     </div>

                     <div class="row">
                         <!-- department -->
                         <div class="col-md-6 mb-3">
                             <label class="form-label">Select Department</label>
                             <select class="form-select" name="department">
                                 <option selected disabled>Choose department</option>
                                 <option value="IT">IT</option>
                                 <option value="HR">HR</option>
                                 <option value="Finance">Finance</option>
                             </select>
                         </div>

                         <!-- role -->
                         <div class="col-md-6 mb-4">
                             <label class="form-label">Select User Role</label>
                             <select name="user_type" class="form-select">
                                 <option selected disabled>Choose role</option>
                                 <option value="admin">Admin</option>
                                 <option value="encoder">Encoder</option>
                                 <option value="viewer">Viewer</option>
                             </select>
                         </div>
                     </div>

                     <!-- login credentials -->
                     <h4 class="mb-3">Login Credentials</h4>

                     <div class="mb-3">
                         <label class="form-label">
                             Full Name <span class="text-danger">*</span>
                         </label>
                         <input type="text" name="name" class="form-control" />
                     </div>

                     <div class="mb-3">
                         <label class="form-label">
                             Email <span class="text-danger">*</span>
                         </label>
                         <input type="email" name="email" class="form-control" />
                     </div>

                     <div class="mb-3">
                         <label class="form-label">
                             Username <span class="text-danger">*</span>
                         </label>
                         <input type="text" name="username" class="form-control" />
                     </div>

                     <!-- account status -->
                     <div class="mb-3">
                         <label class="form-label d-block">Account Status</label>
                         <div class="d-flex gap-4">
                             <div class="form-check">
                                 <input class="form-check-input shadow-none" type="radio" name="status"
                                     id="active" value="active" checked />
                                 <label class="form-check-label" for="active">
                                     Active
                                 </label>
                             </div>
                             <div class="form-check">
                                 <input class="form-check-input shadow-none" type="radio" name="status"
                                     id="inactive" value="inactive" />
                                 <label class="form-check-label" for="inactive">
                                     Inactive
                                 </label>
                             </div>
                         </div>
                     </div>

                 </div>

                 <!-- modal footer -->
                 <div class="modal-footer border-0 px-4 pb-4">
                     <button type="submit" class="btn btn-danger px-4" data-bs-dismiss="modal">
                         Cancel
                     </button>
                     <button type="submit" class="btn btn-success px-4">
                         Save
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
