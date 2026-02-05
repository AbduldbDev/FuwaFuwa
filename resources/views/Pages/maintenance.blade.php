@extends('Layout.app')

@section('content')
    <div id="maintenance" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Maintenance & Repair</h2>
            <div class="group-box">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                @if (Auth::user()->canAccess('Maintenance', 'write'))
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#assetIssueModal">
                        <i class="fa-solid fa-plus"></i>
                        Asset Issue
                    </button>
                @endif
                <x-notification-dropdown />
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <x-stat-card icon="fa-solid fa-tools" icon-color="#1E40AF" icon-bg="#E0E7FF" title="Total Maintenance"
                :value="number_format($TotalMaintenance)" />

            <x-stat-card icon="fa-solid fa-spinner" icon-color="#6D28D9" icon-bg="#EDE9FE" title="In Progress"
                :value="number_format($TotalInprogress)" />

            <x-stat-card icon="fa-solid fa-circle-check" icon-color="#166534" icon-bg="#DCFCE7" title="Completed"
                :value="number_format($TotalCompleted)" />

            <x-stat-card icon="fa-solid fa-triangle-exclamation" icon-color="#92400E" icon-bg="#FFEDD5"
                title="High Priority" :value="number_format($TotalHigh)" />

        </div>

        <!-- calendar schedule -->
        <div class="maintenance-container mb-4">
            <!-- calendar -->
            <div class="calendar-card">
                <div class="calendar-header">
                    <h4>Maintenance Calendar</h4>

                    <div class="date-controls">
                        <!-- month -->
                        <div class="month-control">
                            <button id="prevMonth" aria-label="Previous month">
                                <i class="fa-solid fa-angle-left"></i>
                            </button>

                            <span id="monthLabel"></span>

                            <button id="nextMonth" aria-label="Next month">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </div>

                        <!-- Year control -->
                        <select id="yearSelect"></select>
                    </div>
                </div>

                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>

                <div class="calendar-grid" id="calendar"></div>

                <div class="legend">
                    <div><span class="dot corrective"></span>Corrective</div>
                    <div><span class="dot preventive"></span>Preventive</div>
                    <div><span class="dot inspection"></span>Inspection</div>
                </div>
            </div>

            <!-- repair card -->
            <section class="repair-wrapper overflow-auto">
                <header class="repair-header">
                    <h4>Findings <span>({{ $ForInspection->count() }})</span></h4>
                </header>
                @foreach ($ForInspection as $item)
                    <article class="repair-row">
                        <div class="repair-info">
                            <div class="repair-top mb-1">
                                <span class="repair-id">{{ $item->maintenance_id }}</span>
                            </div>
                            <span class="issue-reason">{{ $item->description }}</span>
                            <div class="repair-meta">
                                <span>Asset: {{ $item->asset_tag }}</span>
                                <span>Issued by: {{ $item->reporter->name }}</span>

                            </div>
                        </div>
                        <button class="schedule-btn" data-bs-toggle="modal"
                            data-bs-target="#scheduleMaintenance{{ $item->id }}">Schedule
                            Maintenance</button>
                    </article>
                    @include('Components.Modal.Maintenance.inspectionRepair')
                @endforeach
            </section>

            <!-- repair card -->
            <section class="repair-wrapper overflow-auto">
                <header class="repair-header">
                    <h4>For Repair <span>({{ $PendingCorrective->count() }})</span></h4>
                </header>
                @foreach ($PendingCorrective as $item)
                    <article class="repair-row">
                        <div class="repair-info">
                            <div class="repair-top mb-1">
                                <span class="repair-id">{{ $item->maintenance_id }}</span>
                            </div>
                            <span class="issue-reason">{{ $item->description }}</span>
                            <div class="repair-meta">
                                <span>Asset: {{ $item->asset_name }}</span>
                                <span>Issued by: {{ $item->reporter->name }}</span>

                            </div>
                        </div>
                        <button class="schedule-btn" data-bs-toggle="modal"
                            data-bs-target="#scheduleMaintenance{{ $item->id }}">Schedule
                            Maintenance</button>
                    </article>
                    @include('Components.Modal.Maintenance.correctiveRepair')
                @endforeach
            </section>

        </div>

        <!-- overview -->
        <div class="request-container">
            <!-- controls -->
            <div class="request-control">
                <h3 class="mb-3">Maintenance Overview</h3>

                <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter">
                    <option value="All Priority">All Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Emergency">Emergency</option>
                </select>
            </div>

            <!-- filters -->
            <div class="d-flex gap-2 mb-4">
                <span class="filter-pill all active">All</span>
                <span class="filter-pill inspection">Inspection</span>
                <span class="filter-pill preventive">Preventive</span>
                <span class="filter-pill corrective">Corrective</span>
                <span class="filter-pill completed">Completed</span>
            </div>

            <!-- requests card -->
            <div class="row">
                <!-- asset card -->
                @foreach ($InProgress as $item)
                    @php
                        $priorityClass = match ($item->priority) {
                            'Low' => 'low',
                            'Medium' => 'medium',
                            'High' => 'high',
                            'Emergency' => 'high',
                            default => 'low',
                        };

                        $CardClass = match ($item->status) {
                            'Inspection' => 'inspection',
                            'Preventive' => 'preventive',
                            'Corrective' => 'corrective',
                            'Completed' => 'completed',
                            default => 'inspection',
                        };
                    @endphp

                    <div class="col-lg-4">
                        <div class="request-card request-card-wrapper {{ $CardClass }}"
                            data-status="{{ strtolower($item->status) }}"
                            data-priority="{{ strtolower($item->priority) }}">

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- asset-info -->
                                <div class="d-flex align-items-center gap-3">
                                    <div class="asset-icon">
                                        <i class="fa-solid fa-laptop"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $item->maintenance_id }}</h6>
                                        <small class="text-muted">{{ $item->asset_tag ?? 'N/A' }}</small>
                                        <br>
                                        <small class="text-muted">{{ $item->asset_name ?? 'N/A' }}</small>
                                        <div class="mt-1">
                                            <span
                                                class="priority-badge {{ $priorityClass }}">{{ $item->priority }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column align-items-end gap-5">
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(['short' => true, 'parts' => 1]) }}</small>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary action-btn" data-bs-toggle="modal"
                                            data-bs-target="#viewCorrectiveMaintenance{{ $item->id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($item->maintenance_type === 'Corrective' && $item->status !== 'Completed')
                        @include('Components.Modal.Maintenance.correctiveInprogress')
                    @elseif (in_array($item->maintenance_type, ['Inspection', 'Preventive']) && $item->status !== 'Completed')
                        @include('Components.Modal.Maintenance.inspectionInprogress')
                    @elseif (in_array($item->maintenance_type, ['Inspection', 'Preventive']) && $item->status === 'Completed')
                        @include('Components.Modal.Maintenance.inpsectionCompleted')
                    @else
                        @include('Components.Modal.Maintenance.correctiveCompleted')
                    @endif
                @endforeach
            </div>

            <!-- modal -->
            <div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-l modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content rounded-3">
                        <!-- modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title fw-semibold">
                                ASSET REQUEST DETAILS
                            </h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- modal body -->
                        <div class="modal-body px-4">
                            <!-- ===== requester information ===== -->
                            <section class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class="fa-solid fa-user me-2 text-secondary"></i>
                                    Requester Information
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Requested By</label>
                                        <div class="fw-semibold">Juan Dela Cruz</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Department</label>
                                        <div class="fw-semibold">IT Department</div>
                                    </div>
                                </div>
                            </section>

                            <hr />

                            <!-- ===== asset sepcification ===== -->
                            <section class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class="fa-solid fa-box me-2 text-secondary"></i>
                                    Asset Specification
                                </h6>

                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label class="form-label text-muted">Asset Type</label>
                                        <div class="fw-semibold">Hardware</div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-muted">Asset Category</label>
                                        <div class="fw-semibold">Laptop</div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label text-muted">Quantity</label>
                                        <div class="fw-semibold">2 Units</div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label text-muted">
                                            Preferred Model / Specifications
                                        </label>
                                        <div class="fw-semibold">
                                            Dell Latitude 5440, i7, 16GB RAM, 512GB SSD
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <hr />

                            <!-- ===== justification ===== -->
                            <section class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class="fa-solid fa-clipboard-list me-2 text-secondary"></i>
                                    Justification
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label text-muted">Reason for Request</label>
                                    <div>Replacement of outdated workstations</div>
                                </div>

                                <div>
                                    <label class="form-label text-muted">Detailed Purpose</label>
                                    <p>
                                        The requested laptops will be used by developers
                                        assigned to the new internal system upgrade project to
                                        ensure optimal performance and productivity.
                                    </p>
                                </div>
                            </section>

                            <hr />

                            <!-- ===== budget ===== -->
                            <section class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class="fa-solid fa-money-bill me-2 text-secondary"></i>
                                    Budget
                                </h6>

                                <div>
                                    <label class="form-label text-muted">Estimated Cost</label>
                                    <div class="fw-semibold">₱180,000</div>
                                </div>
                            </section>

                            <hr />

                            <!-- ===== priority ===== -->
                            <section class="mb-4">
                                <h6 class="fw-semibold mb-3">
                                    <i class="fa-solid fa-flag me-2 text-secondary"></i>
                                    Priority Level
                                </h6>

                                <span class="badge bg-warning text-dark px-3 py-2">
                                    Medium Priority
                                </span>
                            </section>

                            <hr />

                            <!-- ===== activity feed ===== -->
                            <section>
                                <h6 class="fw-semibold mb-3">
                                    <i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i>
                                    Activity & Review
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <select class="form-select">
                                            <option selected disabled>Select status</option>
                                            <option>For Review</option>
                                            <option>Pending Approval</option>
                                            <option>Approved</option>
                                            <option>Rejected</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control" rows="3" placeholder="Add remarks or comments..."></textarea>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary shadow-none" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button class="btn btn-danger shadow-none">
                                <i class="fa-solid fa-xmark me-1"></i> Reject
                            </button>
                            <button class="btn btn-success shadow-none">
                                <i class="fa-solid fa-check me-1"></i> Approve
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Components/Modal/addMaintenance')
    <!-- CALENDAR -->
    <script>
        const maintenanceEvents = @json($maintenanceEvents);

        const calendarEl = document.getElementById("calendar");
        const monthLabel = document.getElementById("monthLabel");
        const yearSelect = document.getElementById("yearSelect");

        const prevMonth = document.getElementById("prevMonth");
        const nextMonth = document.getElementById("nextMonth");

        let month = new Date().getMonth();
        let year = new Date().getFullYear();

        // Populate year dropdown
        for (let y = 2020; y <= 2035; y++) {
            const option = document.createElement("option");
            option.value = y;
            option.textContent = y;
            if (y === year) option.selected = true;
            yearSelect.appendChild(option);
        }

        function renderCalendar() {
            calendarEl.innerHTML = "";

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            monthLabel.textContent = new Date(year, month).toLocaleString("en-US", {
                month: "long"
            });

            // Always 42 cells
            for (let i = 0; i < 42; i++) {
                const cell = document.createElement("div");
                cell.className = "day";

                const dateNum = i - firstDay + 1;
                if (dateNum > 0 && dateNum <= daysInMonth) {
                    cell.textContent = dateNum;

                    const key = `${year}-${String(month + 1).padStart(2, "0")}-${String(dateNum).padStart(2, "0")}`;

                    if (maintenanceEvents[key]) {
                        cell.classList.add(maintenanceEvents[key]);
                    }
                } else {
                    cell.classList.add("empty");
                }

                calendarEl.appendChild(cell);
            }
        }

        prevMonth.onclick = () => {
            month--;
            if (month < 0) {
                month = 11;
                year--;
                yearSelect.value = year;
            }
            renderCalendar();
        };

        nextMonth.onclick = () => {
            month++;
            if (month > 11) {
                month = 0;
                year++;
                yearSelect.value = year;
            }
            renderCalendar();
        };

        yearSelect.onchange = (e) => {
            year = parseInt(e.target.value, 10);
            renderCalendar();
        };

        renderCalendar();
    </script>

    <script src="{{ asset('/Js/Maintenance/maintenanceFilter.js') }}?v={{ time() }}"></script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
