@extends('Layout.app')

@section('content')
    <section id="assets" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Asset Management</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#assetModal">
                    <i class="fa-solid fa-plus"></i>
                    Add New Asset
                </button>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>
        @include('Components/Modal/addAsset')
        <!-- Data Table -->
        <div class="row">
            <div class="container mt-4">
                <div class="table-container">
                    <!-- seach, filter & pagination -->
                    <div class="controls">
                        <div class="searfil">
                            <!-- search -->
                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search assets..." />
                            </div>

                            <!-- filter -->
                            <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter"
                                style="border-radius: 5px">
                                <option value="all">All Assets</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Desktop">Desktop</option>
                                <option value="Server">Server</option>
                                <option value="Network Switch">Network Switch</option>
                                <option value="Firewall">Firewall</option>
                                <option value="Software License">Software License</option>
                            </select>
                        </div>

                        <!-- pagination -->
                        <div class="pagination" id="pagination"></div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" id="assetTable">
                            <thead class="border-bottom">
                                <tr>
                                    <th></th>
                                    <th>Asset ID</th>
                                    <th>Category</th>
                                    <th>Model Name</th>
                                    <th>Status</th>
                                    <th>Compliance Type</th>
                                    <th>Purchase Cost</th>
                                    <th>Asset Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td><a class="asset-link"
                                                href="{{ url('asset/show/' . $item->asset_tag) }}">{{ $item->asset_tag }}</a>
                                        </td>
                                        <td data-category="Laptop">{{ $item->asset_category }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>Active</td>
                                        <td class="text-danger">{{ $item->compliance_status }}</td>
                                        <td>{{ $item->purchase_cost }}</td>
                                        <td>{{ $item->location }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const searchInput = document.getElementById("searchInput");
        const categoryFilter = document.getElementById("categoryFilter");
        const rows = document.querySelectorAll("#assetTable tbody tr");

        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;

            rows.forEach((row) => {
                const rowText = row.innerText.toLowerCase();
                const rowCategory =
                    row.querySelector("[data-category]").dataset.category;

                const matchesSearch = rowText.includes(searchValue);
                const matchesCategory =
                    categoryValue === "all" || rowCategory === categoryValue;

                row.style.display = matchesSearch && matchesCategory ? "" : "none";
            });
        }

        searchInput.addEventListener("keyup", filterTable);
        categoryFilter.addEventListener("change", filterTable);
    </script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
