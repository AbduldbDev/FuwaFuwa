@extends('Layout.app')

@section('content')
    <section id="assets" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Asset Categories</h2>
            <div class="group-box">

                @if (Auth::user()->canAccess('Asset Category', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fa-solid fa-plus"></i>
                        <div class="btn-text">Add Category</div>
                    </button>
                @endif

                <x-notification-dropdown />
            </div>
        </div>
        @include('Components.Modal.AssetCategory.addCategory')

        <div class="row">
            <div class="container mt-4">
                <div class="table-container">
                    <!-- seach, filter & pagination -->
                    <div class="controls">

                        <!-- search -->
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search category..." />
                        </div>

                        <div class="filters">
                            <!-- category -->
                            <select class="form-select form-select-sm w-auto shadow-none" id="typeFilter">
                                <option value="all">All Type</option>
                                <option value="Physical Asset">Physical Asset</option>
                                <option value="Digital Asset">Digital Asset</option>
                            </select>

                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped  align-middle" id="assetTable">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Asset Type</th>
                                    <th>Asset Category</th>
                                    <th>Created By</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse   ($items  as $index =>  $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>
                                            <i class="fa-solid {{ $item->icon }} me-2"></i>
                                            <span>{{ $item->name }}</span>
                                        </td>
                                        <td>{{ $item->user->name }}</td>

                                        <td style="">
                                            @if (Auth::user()->canAccess('Asset Category', 'write'))
                                                <div class="d-flex justify-content-center gap-2">

                                                    {{-- EDIT --}}
                                                    <button class="action-btn edit-btn" data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal{{ $item->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @include('Components.Modal.AssetCategory.editCategory')

                                                    {{-- DELETE --}}
                                                    <button class="action-btn delete-btn"
                                                        data-url="{{ route('asset-categories.delete', $item->id) }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <i class="fa fa-archive mb-3" style="font-size: 4rem; color: #6c757d;"></i>
                                                <h4 class="mb-2" style="color: #6c757d; font-weight: 500;">
                                                    No Assets Categories Found
                                                </h4>
                                                <small class="text-muted">
                                                    Add new category to see them listed here.
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('/Js/AssetsCategory/assetCategoryFilter.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('/Js/SweetAlert/AssetCategory.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
