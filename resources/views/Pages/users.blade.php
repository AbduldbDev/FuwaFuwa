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
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa-solid fa-plus"></i>
                    Add New User
                </button>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <!-- all users -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="all-users">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <!-- number and label -->
                    <div class="user-count">
                        <h2>{{ $total }}</h2>
                        <h6>Total User</h6>
                    </div>
                </div>
            </div>

            <!-- active users -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="active-users">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <!-- number and label -->
                    <div class="user-count">
                        <h2>{{ $active }}</h2>
                        <h6>Active User</h6>
                    </div>
                </div>
            </div>
            <!-- inactive users -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <!-- icon -->
                    <div class="inactive-users">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <!-- number and label -->
                    <div class="user-count">
                        <h2>{{ $inactive }}</h2>
                        <h6>Inactive User</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- profiles -->
        <div class="row my-4">
            @foreach ($items as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="profile-card">
                        <!-- profile picture and name -->
                        <div class="profile-info">
                            <!-- image -->
                            <img src="assets/user.png" alt="User" />
                            <!-- name -->
                            <div class="profile-name">
                                <strong>{{ $item->name }}</strong><br />
                                <small>@<span>{{ $item->username }}</span></small>
                            </div>
                        </div>

                        <!-- profile contacts and button -->
                        <div class="profile-contacts mt-4">
                            <!-- email -->
                            <div class="email mb-2">
                                <i class="fa-regular fa-envelope"></i>
                                <p>{{ $item->email }}</p>
                            </div>

                            <!-- department -->
                            <div class="department mb-2">
                                <i class="fa-regular fa-folder"></i>
                                <p>{{ $item->department }}</p>
                            </div>

                            <!-- user type -->
                            <div class="user-type mb-2">
                                <i class="fa-regular fa-user"></i>
                                <p style="text-transform: capitalize">{{ $item->user_type }}</p>
                            </div>

                            <!-- buttons -->
                            <div class="control-buttons mt-4">
                                <!-- edit -->
                                <button class="edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $item->id }}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Edit
                                </button>
                                <!-- delete -->
                                <button class="delete-btn" data-url="{{ route('user-management.delete', $item->id) }}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @include('Components/Modal/edituser')
            @endforeach
        </div>
    </div>
    @include('Components/Modal/adduser')

    <script src="{{ asset('/js/userSearch.js') }}"></script>
    <script src="{{ asset('/js/deleteAlert.js') }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
