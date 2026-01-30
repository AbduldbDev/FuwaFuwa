@extends('Layout.app')

@section('content')
    <section id="asset-detail" class="asset-detail-section">
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

        <!-- asset name -->
        <div class="asset-header my-4">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <!-- Asset Icon -->
                    <div class="asset-icon">
                        <i class="fa-solid fa-laptop"></i>
                    </div>

                    <!-- Asset Info -->
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-1 fw-semibold">{{ $item->asset_tag }}</h4>
                            <span class="badge bg-success ">{{ ucwords($item->status) }}</span>
                        </div>

                        <div class="asset-meta text-muted">
                            <span>{{ $item->asset_name }}</span>
                            <span class="divider">|</span>
                            <span> <i class="fa-regular fa-user"></i> {{ $item->users->name }}</span>
                            <span class="divider">|</span>
                            <span>{{ $item->asset_id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delete Icon -->
                <button class="delete-btn">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>

            <div class="date-details text-muted">
                <p><strong> Created Date: </strong> {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y - h:i A') }}
                </p>
                <p><strong> Last Update: </strong> {{ \Carbon\Carbon::parse($item->updated_at)->format('M d, Y - h:i A') }}
                </p>
            </div>
        </div>

        <!-- asset tabs -->
        <div class="tabs-wrapper mb-4">
            <div class="tabs">
                <button class="tab active" data-tab="overview">Overview</button>
                <button class="tab" data-tab="history">History</button>
                <span class="tab-indicator"></span>
            </div>
        </div>

        <!-- overview tab -->
        <div id="overview" class="tab-content active">
            <div class="row g-4">
                <!-- left side -->
                <div class="col-lg-8">

                    <!-- asset details -->
                    <div class="card section-card mb-4">
                        <div class="section-toggle" onclick="toggleSection(this)">
                            <!-- asset title header -->
                            <div class="asset-title">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Asset Details</h6>
                            </div>
                            <!-- edi asset btn -->
                            <div class="edit-asset-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Type</div>
                                <div class="col-8 value">{{ $item->asset_type }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Category</div>
                                <div class="col-8 value">{{ $item->asset_category }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Tag</div>
                                <div class="col-8 value">{{ $item->asset_tag }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Asset Name</div>
                                <div class="col-8 value">{{ $item->asset_name }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Operational Status</div>
                                <div class="col-8 value">
                                    <span class="badge bg-success">{{ $item->operational_status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- technical specification -->
                    <div class="card section-card mb-4">
                        <div class="section-toggle" onclick="toggleSection(this)">
                            <!-- asset title header -->
                            <div class="asset-title">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Technical Specification</h6>
                            </div>
                            <!-- edi asset btn -->
                            <div class="edit-asset-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                        </div>

                        <div class="section-body">
                            @forelse ($item->technicalSpecifications as $spec)
                                <div class="row detail-row">
                                    <div class="col-4 label">
                                        {{ ucwords(str_replace('_', ' ', $spec->spec_key)) }}
                                    </div>
                                    <div class="col-8 value">{{ $spec->spec_value }}</div>
                                </div>
                            @empty
                                <div class="row detail-row">
                                    <div class="col-12 text-muted">No technical specifications available.</div>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- assignment and location -->
                    <div class="card section-card mb-4">
                        <div class="section-toggle" onclick="toggleSection(this)">
                            <!-- asset title header -->
                            <div class="asset-title">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Assignment & Location</h6>
                            </div>
                            <!-- edi asset btn -->
                            <div class="edit-asset-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Assigned To</div>
                                <div class="col-8 value">{{ $item->assigned_to }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Department</div>
                                <div class="col-8 value">{{ $item->department }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Location</div>
                                <div class="col-8 value">{{ $item->location }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- purchase information -->
                    <div class="card section-card mb-4">
                        <div class="section-toggle" onclick="toggleSection(this)">
                            <!-- asset title header -->
                            <div class="asset-title">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Purchase Information</h6>
                            </div>
                            <!-- edi asset btn -->
                            <div class="edit-asset-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Vendor</div>
                                <div class="col-8 value">
                                    {{ $item->vendor }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Purchase Date</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->purchase_date)->format('F d, Y') }}
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Purchase Cost</div>
                                <div class="col-8 value">Php {{ number_format($item->purchase_cost, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- pmaintenance & audit -->
                    <div class="card section-card mb-4">
                        <div class="section-toggle" onclick="toggleSection(this)">
                            <!-- asset title header -->
                            <div class="asset-title">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Maintenance & Audit</h6>
                            </div>
                            <!-- edi asset btn -->
                            <div class="edit-asset-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Compliance Status</div>
                                <div class="col-8 value">{{ $item->compliance_status }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Warranty Start Date</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->warranty_start)->format('F d, Y') }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Warranty End Date</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->warranty_end)->format('F d, Y') }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Next Schedule Maintenance</div>
                                <div class="col-8 value">
                                    {{ \Carbon\Carbon::parse($item->next_maintenance)->format('F d, Y') }}</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Useful Life (years)</div>
                                <div class="col-8 value">{{ $item->useful_life_years }} years</div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Salvage Value</div>
                                <div class="col-8 value">Php {{ number_format($item->salvage_value, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- documents -->
                    <div class="card section-card mb-4">
                        <div class="section-toggle" onclick="toggleSection(this)">
                            <!-- asset title header -->
                            <div class="asset-title">
                                <i class="fa-solid fa-chevron-down"></i>
                                <h6 class="mb-0 fw-semibold">Documents</h6>
                            </div>
                            <!-- edi asset btn -->
                            <div class="edit-asset-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="row detail-row">
                                <div class="col-4 label">Contract</div>
                                <div class="col-8 value">
                                    <a href="contract.pdf">contract.pdf</a>
                                </div>
                            </div>
                            <div class="row detail-row">
                                <div class="col-4 label">Warranty Start Date</div>
                                <div class="col-8 value">
                                    <a href="purchase_order.pdf">purchase_order.pdf</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- right side -->
                <div class="col-lg-4">
                    <div class="card section-card">
                        <div class="history-header d-flex justify-content-between">
                            <h6 class="mb-0 fw-semibold">Recent History</h6>
                            <a href="#" class="see-all">See All</a>
                        </div>

                        <div class="card-body history-list">
                            <div class="history-item">
                                <strong>Ryan Bacon</strong> changed fields
                                <small>Warranty: 12 → 24 months</small>
                                <span class="date">2025-01-10</span>
                            </div>

                            <div class="history-item">
                                <strong>Ryan Bacon</strong> changed status
                                <small>Available → Assigned</small>
                                <span class="date">2025-01-02</span>
                            </div>

                            <div class="history-item">
                                <strong>John Miller</strong> changed location
                                <small>Denver → Ankara</small>
                                <span class="date">2025-01-01</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- history tab -->
        <div id="history" class="tab-content">
            <div class="card section-card">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Full Asset History</h6>
                    <p class="text-muted">
                        This is where the full history table or timeline will go.
                    </p>
                </div>
            </div>
        </div>

    </section>
    <script>
        const tabs = document.querySelectorAll(".tab");
        const contents = document.querySelectorAll(".tab-content");
        const indicator = document.querySelector(".tab-indicator");

        /* Set default indicator */
        window.onload = () => {
            moveIndicator(document.querySelector(".tab.active"));
        };

        tabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                tabs.forEach((t) => t.classList.remove("active"));
                tab.classList.add("active");

                contents.forEach((c) => c.classList.remove("active"));
                document.getElementById(tab.dataset.tab).classList.add("active");

                moveIndicator(tab);
            });
        });

        function moveIndicator(tab) {
            const tabRect = tab.getBoundingClientRect();
            const parentRect = tab.parentElement.getBoundingClientRect();

            const extraWidth = 20; // pixels (8px on each side)

            indicator.style.width = `${tabRect.width + extraWidth}px`;
            indicator.style.transform = `translateX(${
          tabRect.left - parentRect.left - extraWidth / 2
        }px)`;
        }

        /* Collapsible sections */
        function toggleSection(header) {
            const card = header.closest(".section-card");
            card.classList.toggle("collapsed");
        }
    </script>
@endsection

@push('css')
    <link href="{{ asset('/css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
