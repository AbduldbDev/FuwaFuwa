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
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#assetIssueModal">
                    <i class="fa-solid fa-plus"></i>
                    Asset Issue
                </button>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
        </div>

        <!-- add asset issue modal -->
        <div class="modal fade" id="assetIssueModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <i class="fa-solid fa-bug me-2"></i>
                        <h5 class="modal-title">Asset Issue</h5>
                        <button class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- STEP 1 -->
                        <div class="step active" id="step1">
                            <h6 class="mb-3">Select Maintenance Type</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="option-card" data-type="Corrective">
                                        <i class="fa-solid fa-screwdriver-wrench fa-2x mb-2"></i>
                                        <h6>Corrective</h6>
                                        <small>Repair</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="option-card" data-type="Preventive">
                                        <i class="fa-solid fa-calendar-check fa-2x mb-2"></i>
                                        <h6>Preventive</h6>
                                        <small>Scheduled</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="option-card" data-type="Inspection">
                                        <i class="fa-solid fa-clipboard-check fa-2x mb-2"></i>
                                        <h6>Inspection</h6>
                                        <small>Scheduled</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div class="step" id="step2">
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-tools"></i>
                                <h6>Maintenance Information</h6>
                            </div>

                            <!-- form -->
                            <form>
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <label class="form-label">Maintenance ID <span class="text-danger">*</span></label>
                                        <input type="text" id="maintenanceId" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Maintenance Type <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="maintenanceType" class="form-control" readonly>
                                    </div>
                                </div>

                                <!-- corrective -->
                                <div id="correctiveFields">
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-file-lines"></i>
                                        <h6>Report Information</h6>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <label class="form-label">Reported By</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Department</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-clipboard-list"></i>
                                        <h6>Issue/Task Description</h6>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Detailed Description</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Attach Document</label>
                                        <input type="file" class="form-control">
                                    </div>
                                </div>

                                <!-- shared -->
                                <section>
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-box"></i>
                                        <h6>Asset Information</h6>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Asset Tag</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Asset Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Last Maintenance Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                </section>

                                <!-- priority level -->
                                <div class="mb-5">
                                    <label class="form-label d-block">Priority Level</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="radio" name="status"
                                                id="active" checked />
                                            <label class="form-check-label" for="active">
                                                Low
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="radio" name="status"
                                                id="inactive" />
                                            <label class="form-check-label" for="inactive">
                                                Medium
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="radio" name="status"
                                                id="inactive" />
                                            <label class="form-check-label" for="inactive">
                                                High
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="radio" name="status"
                                                id="inactive" />
                                            <label class="form-check-label" for="inactive">
                                                Emergency
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- preventive / inspection -->
                                <div id="scheduleFields">
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <h6>Maintenance Schedule</h6>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Maintenance Frequency</label>
                                            <select id="frequency" class="form-select"></select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Assign Technician</label>
                                        <select class="form-select">
                                            <option>Technician A</option>
                                            <option>Technician B</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

                    <!-- buttons -->
                    <div class="modal-footer">
                        <button class="back-btn" id="backBtn" disabled>Back</button>
                        <button class="next-btn" id="nextBtn">Next</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #1E40AF; background: #E0E7FF;">
                            <i class="fa-solid fa-tools"></i>
                        </div>
                        <div>
                            <h2>800,000,000</h2>
                            <h6>Total Maintenance</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #6D28D9; background: #EDE9FE;">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                        <div>
                            <h2>12,091,209</h2>
                            <h6>In Progress</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #166534; background: #DCFCE7;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <h2>12,091,209</h2>
                            <h6>Completed</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #92400E; background: #FFEDD5;">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <h2>12,091,209</h2>
                            <h6>High Priority</h6>
                        </div>
                    </div>
                </div>
            </div>
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
                    <h4>For Repair <span>(2)</span></h4>
                </header>

                <article class="repair-row">
                    <div class="repair-info">
                        <div class="repair-top mb-1">
                            <span class="repair-id">COR-2025-001</span>
                            <span class="status-badge warning">Pending</span>
                        </div>
                        <span class="issue-reason">Screen flickering daming sira, boo</span>
                        <div class="repair-meta">
                            <span>Asset: Laptop Pro 16</span>
                            <span>Issued by: IT Dept</span>

                        </div>
                    </div>
                    <button class="schedule-btn">Schedule Maintenance</button>
                </article>

                <article class="repair-row">
                    <div class="repair-info">
                        <div class="repair-top mb-1">
                            <span class="repair-id">COR-2025-001</span>
                            <span class="status-badge warning">Pending</span>
                        </div>
                        <span class="issue-reason">Screen flickering daming sira, boo</span>
                        <div class="repair-meta">
                            <span>Asset: Laptop Pro 16</span>
                            <span>Issued by: IT Dept</span>

                        </div>
                    </div>
                    <button class="schedule-btn">Schedule Maintenance</button>
                </article>

                <article class="repair-row">
                    <div class="repair-info">
                        <div class="repair-top mb-1">
                            <span class="repair-id">COR-2025-001</span>
                            <span class="status-badge warning">Pending</span>
                        </div>
                        <span class="issue-reason">Screen flickering daming sira, boo</span>
                        <div class="repair-meta">
                            <span>Asset: Laptop Pro 16</span>
                            <span>Issued by: IT Dept</span>

                        </div>
                    </div>
                    <button class="schedule-btn">Schedule Maintenance</button>
                </article>

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
                    <option value="Urgent">Urgent</option>
                </select>
            </div>

            <!-- filters -->
            <div class="d-flex gap-2 mb-4">
                <span class="filter-pill active">All</span>
                <span class="filter-pill">Findings from Inspection</span>
                <span class="filter-pill">In Progress</span>
                <span class="filter-pill">Completed</span>
            </div>

            <!-- requests card -->
            <div class="row">
                <!-- asset card -->
                <div class="col-lg-4">
                    <div class="request-card low">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- asset-info -->
                            <div class="d-flex align-items-center gap-3">
                                <div class="asset-icon">
                                    <i class="fa-solid fa-laptop"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">COR-2025-001</h6>
                                    <small class="text-muted">Laptop Pro 16</small>
                                    <br>
                                    <small class="text-muted">IT Department</small>
                                    <div class="mt-1">
                                        <span class="request-status for-review">For Review</span>
                                        <span class="priority-badge low">Low Priority</span>
                                    </div>
                                </div>
                            </div>

                            <!-- time and buttons -->
                            <div class="d-flex flex-column align-items-end gap-5">
                                <small class="text-muted">2 hrs ago</small>

                                <!-- action buttons -->
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary action-btn" data-bs-toggle="modal"
                                        data-bs-target="#requestDetailsModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success action-btn">
                                        <i class="fa-regular fa-calendar-check"></i>
                                    </button>
                                    <button class="btn btn-outline-danger action-btn">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <!-- CALENDAR -->
    <script>
        const calendarEl = document.getElementById("calendar");
        const monthLabel = document.getElementById("monthLabel");
        const yearSelect = document.getElementById("yearSelect");

        const prevMonth = document.getElementById("prevMonth");
        const nextMonth = document.getElementById("nextMonth");

        let month = 0;
        let year = 2026;

        const maintenanceEvents = {
            "2026-01-08": "preventive",
            "2026-01-12": "inspection",
            "2026-01-14": "corrective",
            "2026-01-25": "inspection",
        };

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

    <!-- MAINTENANCE MODAL -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const optionCards = document.querySelectorAll('.option-card');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const backBtn = document.getElementById('backBtn');
            const nextBtn = document.getElementById('nextBtn');
            const correctiveFields = document.getElementById('correctiveFields');
            const scheduleFields = document.getElementById('scheduleFields');
            const frequency = document.getElementById('frequency');
            const modal = document.getElementById('assetIssueModal');

            let selectedType = null;

            // INITIAL STATE
            nextBtn.disabled = true;

            optionCards.forEach(card => {
                card.addEventListener('click', () => {
                    optionCards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');
                    selectedType = card.dataset.type;
                    nextBtn.disabled = false;
                });
            });

            nextBtn.addEventListener('click', (e) => {
                e.preventDefault(); // 🚨 VERY IMPORTANT

                if (!selectedType) return;

                step1.classList.remove('active');
                step2.classList.add('active');
                backBtn.disabled = false;
                nextBtn.textContent = 'Submit';

                document.getElementById('maintenanceType').value = selectedType;
                document.getElementById('maintenanceId').value =
                    'MT-' + Date.now().toString().slice(-6);

                if (selectedType === 'Corrective') {
                    correctiveFields.style.display = 'block';
                    scheduleFields.style.display = 'none';
                } else {
                    correctiveFields.style.display = 'none';
                    scheduleFields.style.display = 'block';

                    frequency.innerHTML = '';
                    const options = selectedType === 'Preventive' ? ['Semi-Annual', 'Quarterly',
                        'Monthly'] : ['Weekly', 'Monthly'];

                    options.forEach(o => {
                        frequency.insertAdjacentHTML('beforeend', `<option>${o}</option>`);
                    });
                }
            });

            backBtn.addEventListener('click', (e) => {
                e.preventDefault();

                step2.classList.remove('active');
                step1.classList.add('active');
                backBtn.disabled = true;
                nextBtn.textContent = 'Next';
            });

            modal.addEventListener('hidden.bs.modal', () => {
                // FULL RESET
                step1.classList.add('active');
                step2.classList.remove('active');
                backBtn.disabled = true;
                nextBtn.disabled = true;
                nextBtn.textContent = 'Next';
                selectedType = null;

                optionCards.forEach(c => c.classList.remove('active'));
                modal.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
            });

        });
    </script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
