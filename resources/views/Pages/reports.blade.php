@extends('Layout.app')

@section('content')
    <div id="reports" class="content-section">
        <!-- navbar -->
        <div class="navbar">
            <h2>Reports & Analytics</h2>
            <div class="group-box">
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#customReport">
                    <i class="fa-solid fa-plus"></i>
                    Custom Report
                </button>
                <i class="fa-regular fa-bell notif-bell"></i>
            </div>
            @include('Components.Modal.Reports.CustomReport')
        </div>

        <!-- numbers -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #1E40AF; background: #E0E7FF;">
                            <i class="fas fa-file-circle-check"></i>
                        </div>
                        <div>
                            <h2>{{ $TotalGeneratedReport }}</h2>
                            <h6>Reports Generate This Month</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #6D28D9; background: #EDE9FE;">
                            <i class="fas fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h2>{{ $LastGeneratedReport?->created_at?->format('M d, Y') ?? 'No generated yet' }}</h2>
                            <h6>Last Generated Report</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #166534; background: #DCFCE7;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h2>{{ $TotalScheduledMonthlyReports }}</h2>
                            <h6>Scheduled Monthly Reports</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="number-icon" style="color: #92400E; background: #FFEDD5;">
                            <i class="fas fa-sliders"></i>
                        </div>
                        <div>
                            <h2>{{ $TotalCustomReportsCreated }}</h2>
                            <h6>Custom Reports Created</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- available reports -->
        <div class="report-container">
            <!-- header -->
            <div class="report-control">
                <h3>Available Reports</h3>

                <input type="text" id="searchFilter" class="form-control form-control-sm w-25 shadow-none"
                    placeholder="Search report name or purpose">

            </div>

            <!-- filters -->
            <div class="filters d-flex justify-content-end">
                <!-- time range filter -->
                <select class="form-select form-select-sm w-auto shadow-none" id="timeRangeFilter">
                    <option value="All Reports">All Reports</option>
                    <option value="Custom Reports">Custom Reports</option>
                    <option value="Scheduled Reports">Scheduled Reports</option>
                </select>

                <div class="date-range-filter">
                    <label>Date Range</label>
                    <input type="month">
                </div>
            </div>
            <hr>

            @foreach ($reports as $item)
                <div class="report-card mb-1" data-type="{{ $item->type }}"
                    data-date="{{ $item->created_at->format('Y-m') }}"
                    data-search="{{ strtolower($item->name . ' ' . $item->description) }}">
                    <div class="report-info">
                        <!-- icon -->
                        <div class="report-icon">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>

                        <!-- report name and date -->
                        <div>
                            <h5>{{ $item->name }}</h5>
                            <p>Generated {{ $item->created_at->format('M d, Y • h:i a') }}</p>
                            <p>Purpose: {{ $item->description }}</p>
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="report-actions">
                        @if ($item->file_path)
                            <div class="report-actions">
                                <button class="download"
                                    onclick="window.location.href='{{ route('reports-analytics.download', $item->id) }}'">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        @else
                            <button class="download btn btn-sm btn-secondary" disabled>
                                <i class="fa fa-download"></i> Not Available
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeRangeFilter = document.getElementById('timeRangeFilter');
            const monthFilter = document.querySelector('.date-range-filter input[type="month"]');
            const searchInput = document.getElementById('searchFilter');
            const reportCards = document.querySelectorAll('.report-card');

            let activeType = 'All Reports';
            let activeMonth = '';
            let searchText = '';

            function filterReports() {
                reportCards.forEach(card => {
                    const reportType = card.dataset.type;
                    const reportMonth = card.dataset.date;
                    const searchData = card.dataset.search;

                    // Type filter
                    const typeMatch =
                        activeType === 'All Reports' || reportType === activeType;

                    // Month filter
                    const monthMatch = !activeMonth || reportMonth === activeMonth;

                    // Search filter
                    const searchMatch = !searchText || searchData.includes(searchText);

                    card.style.display =
                        typeMatch && monthMatch && searchMatch ? '' : 'none';
                });
            }

            // Type dropdown
            timeRangeFilter.addEventListener('change', function() {
                activeType = this.value;
                filterReports();
            });

            // Month picker
            monthFilter.addEventListener('change', function() {
                activeMonth = this.value;
                filterReports();
            });

            // Search input
            searchInput.addEventListener('input', function() {
                searchText = this.value.toLowerCase().trim();
                filterReports();
            });

            filterReports();
        });
    </script>
@endsection

@push('css')
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
@endpush
