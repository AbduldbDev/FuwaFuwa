<div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content add-user-modal">
            <div class="modal-header">
                <i class="fa-solid fa-user-plus me-2"></i>
                <h5 class="modal-title fw-semibold">Edit User</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('user-management.update', $item->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-user"></i>
                        <h6>User Information</h6>
                    </div>

                    <!-- employee id -->
                    <div class="mb-3">
                        <label class="form-label">
                            Employee ID <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="employee_id" class="form-control"
                            value="{{ $item->employee_id }}" />
                    </div>

                    <div class="row">
                        <!-- department -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Department</label>
                            <select class="form-select" name="department">
                                <option disabled>Choose department</option>
                                <option value="IT" {{ $item->department == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="HR" {{ $item->department == 'HR' ? 'selected' : '' }}>HR</option>
                                <option value="Finance" {{ $item->department == 'Finance' ? 'selected' : '' }}>Finance
                                </option>
                            </select>
                        </div>

                        <!-- role -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Select User Role</label>
                            <select name="user_type" class="form-select">
                                <option disabled>Choose role</option>
                                <option value="admin" {{ $item->user_type == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="encoder" {{ $item->user_type == 'encoder' ? 'selected' : '' }}>Encoder
                                </option>
                                <option value="viewer" {{ $item->user_type == 'viewer' ? 'selected' : '' }}>Viewer
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- login credentials -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-address-card"></i>
                        <h6>Login Credentials</h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" value="{{ $item->name }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="username" class="form-control" value="{{ $item->username }}" />
                    </div>

                    <!-- account status -->
                    <div class="mb-3">
                        <label class="form-label d-block">Account Status</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="status"
                                    id="edit_active{{ $item->id }}" value="active"
                                    {{ $item->status == 'active' ? 'checked' : '' }} />
                                <label class="form-check-label" for="edit_active{{ $item->id }}">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="status"
                                    id="edit_inactive{{ $item->id }}" value="inactive"
                                    {{ $item->status == 'inactive' ? 'checked' : '' }} />
                                <label class="form-check-label" for="edit_inactive{{ $item->id }}">
                                    Inactive
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- modal footer -->
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-4">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
