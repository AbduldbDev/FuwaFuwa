@extends('Layout.app')

@section('content')
    <div id="users" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>User Management</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                @if (Auth::user()->canAccess('User', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fa-solid fa-plus"></i>
                        Add New User
                    </button>
                @endif

                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <!-- all users -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="all-entity">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <!-- number and label -->
                    <div class="entity-count">
                        <h2>{{ $total }}</h2>
                        <h6>Total User</h6>
                    </div>
                </div>
            </div>

            <!-- active users -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="active-entity">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <!-- number and label -->
                    <div class="entity-count">
                        <h2>{{ $active }}</h2>
                        <h6>Active User</h6>
                    </div>
                </div>
            </div>
            <!-- inactive users -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="inactive-entity">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <!-- number and label -->
                    <div class="entity-count">
                        <h2>{{ $inactive }}</h2>
                        <h6>Inactive User</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="entity-container">
            <div class="controls mb-3">
                <h3>User Profiles</h3>

                <!-- filters -->
                <div class="filters">
                    <!-- department -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="departmentFilter">
                        <option value="all">All Departments</option>
                        <option value="IT">IT</option>
                        <option value="HR">HR</option>
                        <option value="Finance">Finance</option>
                    </select>

                    <!-- role -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="roleFilter"
                        style="border-radius: 10px">
                        <option value="all">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="encoder">Encoder</option>
                        <option value="viewer">Viewer</option>
                    </select>

                    <!-- account status -->
                    <select class="form-select form-select-sm w-auto shadow-none" id="accountStatusFilter"
                        style="border-radius: 10px">
                        <option value="all">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- profiles -->
            <div class="users-container">

                <div class="row my-4">
                    @foreach ($items as $item)
                        <div class="col-lg-3 col-md-6 user-card" data-department="{{ $item->department }}"
                            data-role="{{ $item->user_type }}" data-status="{{ ucfirst($item->status) }}">

                            <div class="profile-card">
                                <!-- profile picture and name -->
                                <div class="profile-info">
                                    <!-- image -->
                                    <img src="assets/user.png" alt="User" />
                                    <!-- name -->
                                    <div class="profile-name">
                                        <strong>{{ $item->name }}</strong><br />
                                        <small>@<span>{{ $item->username }}</span></small> <br />
                                        <span
                                            class="user-status {{ $item->status === 'active' ? 'active-user' : 'inactive-user' }}">{{ ucfirst($item->status) }}</span>
                                    </div>
                                </div>

                                <!-- profile contacts and button -->
                                <div class="profile-contacts mt-4">
                                    <!-- user id -->
                                    <div class="info-row">
                                        <span class="label">User ID</span>
                                        <span class="value">USER{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</span>

                                    </div>

                                    <!-- email -->
                                    <div class="info-row">
                                        <span class="label">Email</span>
                                        <span class="value">{{ $item->email }}</span>
                                    </div>

                                    <!-- department -->
                                    <div class="info-row">
                                        <span class="label">Department</span>
                                        <span class="value">{{ $item->department }}</span>
                                    </div>

                                    <!-- user type -->
                                    <div class="info-row">
                                        <span class="label">User Role</span>
                                        <span class="value">{{ ucfirst($item->user_type) }}</span>
                                    </div>

                                    <!-- buttons -->
                                    @if (Auth::user()->canAccess('User', 'write'))
                                        <div class="control-buttons mt-4">
                                            <!-- edit -->
                                            <button class="edit-btn" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal{{ $item->id }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                                Edit
                                            </button>
                                            <!-- delete -->
                                            <button class="delete-btn"
                                                data-url="{{ route('user-management.delete', $item->id) }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @include('Components/Modal/edituser')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('Components/Modal/adduser')

    <script src="{{ asset('/js/userSearch.js') }}"></script>
    <script src="{{ asset('/js/userFilter.js') }}"></script>
    <script src="{{ asset('/js/deleteAlert.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
