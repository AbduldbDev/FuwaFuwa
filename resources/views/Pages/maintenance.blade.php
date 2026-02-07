@extends('Layout.app')

@section('content')
    <div id="maintenance" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Maintenance & Repair</h2>
            <div class="group-box">

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
            <div class="row g-4">
                <div class="col-lg-4 col-md-12"> <!-- calendar -->
                    <div class="calendar-card" style="position:relative;">
                        <!-- Header -->
                        <div class="calendar-header">
                            <h4>Maintenance Calendar</h4>

                            <div class="date-controls">
                                <!-- Month control -->
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

                        <!-- Weekdays row -->
                        <div class="weekdays">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>

                        <!-- Calendar grid -->
                        <div class="calendar-grid" id="calendar"
                            style="display:grid; grid-template-columns: repeat(7, 1fr); gap:5px;"></div>

                        <!-- Legend -->
                        <div class="legend" style="margin-top:10px;">
                            <div><span class="dot corrective"></span> Corrective</div>
                            <div><span class="dot preventive"></span> Preventive</div>
                        </div>

                        <!-- Popup -->
                        <div id="popup"
                            style="
                                    position:absolute; 
                                    display:none; 
                                    background:#fff; 
                                    border:1px solid #ccc; 
                                    padding:10px; 
                                    border-radius:6px; 
                                    box-shadow:0 4px 8px rgba(0,0,0,0.1); 
                                    z-index:1000; 
                                    max-width:100px;
                                ">
                        </div>

                    </div>

                </div>
                <div class="col-lg-4 col-md-12">
                    <section class="repair-wrapper overflow-auto h-100">
                        <header class="repair-header">
                            <h4>Findings <span>({{ $ForInspection->count() }})</span></h4>
                        </header>

                        @forelse ($ForInspection as $item)
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
                        @empty
                            <div class="text-center p-4 text-muted">
                                <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                                <p>No findings available.</p>
                            </div>
                        @endforelse
                    </section>
                </div>
                <div class="col-lg-4 col-md-12">
                    <section class="repair-wrapper overflow-auto h-100">
                        <header class="repair-header">
                            <h4>For Repair <span>({{ $PendingCorrective->count() }})</span></h4>
                        </header>

                        @forelse ($PendingCorrective as $item)
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
                        @empty
                            <div class="text-center p-4 text-muted">
                                <i class="fa-solid fa-tools fa-2x mb-2"></i>
                                <p>No pending corrective repairs.</p>
                            </div>
                        @endforelse
                    </section>
                </div>
            </div>

            <!-- repair card -->

        </div>

        <!-- overview -->
        <div class="request-container">
            <!-- controls -->
            <div class="request-control">
                <h3 class="mb-3">Maintenance Overview</h3>
                <input type="text" id="searchFilter" class="form-control form-control-sm w-25"
                    placeholder="Search maintenance id, asset tag, or name">

            </div>

            <div class="d-flex gap-2 mb-4 justify-content-between">
                @php
                    $counts = $RequestStatusCounts ?? [];
                    $total = array_sum($counts);
                @endphp

                <div class="d-flex gap-2 mb-4">

                    <span class="filter-pill all active" data-status="all">
                        All <strong>({{ $total }})</strong>
                    </span>

                    <span class="filter-pill preventive" data-status="Preventive">
                        Preventive <strong>({{ $counts['Preventive'] ?? 0 }})</strong>
                    </span>

                    <span class="filter-pill corrective" data-status="Corrective">
                        Corrective <strong>({{ $counts['Corrective'] ?? 0 }})</strong>
                    </span>

                    <span class="filter-pill completed" data-status="Completed">
                        Completed <strong>({{ $counts['Completed'] ?? 0 }})</strong>
                    </span>
                </div>

                <div>
                    <select class="form-select form-select-sm w-auto shadow-none" id="categoryFilter">
                        <option value="All Priority">All Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>
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

                    <div class="col-lg-4 mb-4">
                        <div class="request-card request-card-wrapper {{ $CardClass }}"
                            data-type="{{ strtolower($item->maintenance_type) }}"
                            data-status="{{ strtolower($item->status) }}"
                            data-priority="{{ strtolower($item->priority) }}"
                            data-search="{{ strtolower($item->maintenance_id . ' ' . ($item->asset_tag ?? '') . ' ' . ($item->asset_name ?? '')) }}">

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
        const popup = document.getElementById("popup");

        let month = new Date().getMonth();
        let year = new Date().getFullYear();

        // Transform array to object keyed by date
        const eventsByDate = {};
        maintenanceEvents.forEach(event => {
            const dateKey = event.start_date;
            if (!eventsByDate[dateKey]) eventsByDate[dateKey] = [];
            eventsByDate[dateKey].push(event);
        });

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

            for (let i = 0; i < 42; i++) {
                const cell = document.createElement("div");
                cell.className = "day";

                const dateNum = i - firstDay + 1;
                if (dateNum > 0 && dateNum <= daysInMonth) {
                    const dateLabel = document.createElement("div");
                    dateLabel.className = "date-number";
                    dateLabel.textContent = dateNum;
                    cell.appendChild(dateLabel);

                    const key = `${year}-${String(month + 1).padStart(2, "0")}-${String(dateNum).padStart(2, "0")}`;

                    if (eventsByDate[key]) {
                        cell.classList.add("has-event");
                        cell.style.cursor = "pointer";

                        // Add colored dots for each event type
                        eventsByDate[key].forEach(event => {
                            cell.classList.add(event.maintenance_type.toLowerCase());
                        });

                        // Click to show popup
                        cell.onclick = (e) => {
                            let content =
                                `<h5 style="margin:0 0 5px 0; font-size:14px;">Maintenance Events for ${key}</h5>
                                <div style=" font-size:13px;">`;
                            eventsByDate[key].forEach(ev => {
                                content +=
                                    `<p><strong>Asset Tag:</strong></p>
                                    <p>${ev.asset_tag ?? 'N/A'}</p>
                                    <p><strong>Asset Name:</strong></p>
                                    <p> ${ev.asset_name?? 'N/A'}</p>`;
                            });
                            content += "</div>";

                            popup.innerHTML = content;
                            popup.style.display = "block";

                            // Position the popup above the clicked cell
                            const rect = cell.getBoundingClientRect();
                            const calendarRect = calendarEl.getBoundingClientRect();

                            popup.style.top = (rect.top - calendarRect.top - popup.offsetHeight - 10) + "px"; // 8px gap
                            popup.style.left = (rect.left - calendarRect.left) + "px";
                        };
                    }
                } else {
                    cell.classList.add("empty");
                }

                calendarEl.appendChild(cell);
            }
        }

        // Hide popup when clicking outside
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".day")) {
                popup.style.display = "none";
            }
        });

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
