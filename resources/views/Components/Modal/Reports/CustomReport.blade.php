<!-- Create Custom Report Modal -->
<div class="modal fade" id="customReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('reports-analytics.generateCustomReport') }}" method="POST" id="customReportForm">
            @csrf
            <div class="modal-content add-user-modal">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        <i class="fa-solid fa-file-circle-plus me-2"></i>
                        Create Custom Report
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body px-4">

                    <!-- Report Information -->
                    <section>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="fa-regular fa-file-lines"></i>
                            <h6>Report Information</h6>
                        </div>

                        <!-- Hidden inputs for JS -->
                        <input type="hidden" name="report_type" id="selectedReportType">
                        <input type="hidden" name="columns" id="selectedColumns">

                        <div class="row">
                            <!-- Report Name -->
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Report Name <span class="text-danger">*</span></label>
                                <input type="text" name="report_name" class="form-control" required>
                            </div>

                            <!-- Detailed Purpose -->
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Detailed Purpose <span class="text-danger">*</span></label>
                                <textarea name="purpose" class="form-control" rows="4" placeholder="Enter detailed purpose..." required></textarea>
                            </div>

                            <!-- Start & End Date -->
                            <div class="col-lg-6 mb-3">
                                <label class="form-label text-muted">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label text-muted">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>

                            <!-- Report Type -->
                            <div class="mb-3">
                                <label class="form-label">Report Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="reportType" required>
                                    <option value="" disabled selected>Select report type</option>
                                    @foreach ($reportTables as $table => $columns)
                                        <option value="{{ $table }}">{{ ucfirst(str_replace('_', ' ', $table)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dynamic Checklists -->
                            @foreach ($reportTables as $table => $categories)
                                <div class="checklist-wrapper" id="{{ $table }}" style="display:none;">
                                    <div class="row">
                                        @foreach ($categories as $categoryName => $columns)
                                            <div class="col-md-6 mb-3">
                                                <div class="checklist-header">
                                                    <label class="header-check">
                                                        <input type="checkbox" class="check-all">
                                                        <span>{{ $categoryName }}</span>
                                                    </label>
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                </div>
                                                <div class="checklist-items">
                                                    @foreach ($columns as $column)
                                                        <label>
                                                            <input type="checkbox" class="child-check"
                                                                value="{{ $column }}">
                                                            {{ ucwords(str_replace('_', ' ', $column)) }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </section>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4">Submit</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    // Show/hide checklists based on selected report type
    const reportSelect = document.getElementById("reportType");
    const checklists = document.querySelectorAll(".checklist-wrapper");

    reportSelect.addEventListener("change", function() {
        checklists.forEach(list => list.style.display = "none");
        const selected = document.getElementById(this.value);
        if (selected) selected.style.display = "block";
    });

    // Accordion toggle
    document.querySelectorAll(".checklist-header i").forEach(icon => {
        icon.addEventListener("click", e => {
            e.stopPropagation();
            const header = icon.parentElement;
            header.classList.toggle("active");
            const items = header.nextElementSibling;
            items.style.display = items.style.display === "block" ? "none" : "block";
        });
    });

    // Check All / Child logic
    document.querySelectorAll(".checklist-wrapper").forEach(wrapper => {
        wrapper.querySelectorAll(".col-md-6").forEach(category => {
            const checkAll = category.querySelector(".check-all");
            const children = category.querySelectorAll(".child-check");

            if (!checkAll) return;

            // Check all toggle
            checkAll.addEventListener("change", () => {
                children.forEach(child => child.checked = checkAll.checked);
                checkAll.indeterminate = false;
            });

            // Child checkboxes affect parent
            children.forEach(child => {
                child.addEventListener("change", () => {
                    const checkedCount = [...children].filter(c => c.checked).length;
                    if (checkedCount === 0) {
                        checkAll.checked = false;
                        checkAll.indeterminate = false;
                    } else if (checkedCount === children.length) {
                        checkAll.checked = true;
                        checkAll.indeterminate = false;
                    } else {
                        checkAll.indeterminate = true;
                    }
                });
            });
        });
    });


    // Before submitting, gather selected report type and columns
    const form = document.getElementById('customReportForm');
    form.addEventListener('submit', function(e) {
        const selectedType = reportSelect.value;
        if (!selectedType) {
            e.preventDefault();
            alert('Please select a report type!');
            return;
        }

        const checkboxes = document.querySelectorAll(`#${selectedType} .child-check`);
        const selectedCols = [...checkboxes].filter(c => c.checked).map(c => c.value);

        // UNCOMMENT THIS VALIDATION
        if (selectedCols.length === 0) {
            e.preventDefault();
            alert('Please select at least one column!');
            return;
        }

        document.getElementById('selectedReportType').value = selectedType;
        document.getElementById('selectedColumns').value = selectedCols.join(',');
    });
</script>
