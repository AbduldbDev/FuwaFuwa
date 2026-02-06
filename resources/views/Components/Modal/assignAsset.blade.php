<div class="modal fade" id="assignModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content"> <!-- modal header -->
            <form action="{{ route('assets.store') }}" method="POST" id="assetForm" enctype="multipart/form-data"> @csrf
                <div class="modal-header"> <i class="fa-solid fa-square-plus me-2"></i>
                    <h5 class="modal-title fw-semibold">ADD NEW ASSET</h5> <button type="button"
                        class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div> <!-- modal body -->
                <div class="modal-body px-4"> <!-- ===== Asset Category and Type ===== -->
                    <div id="slide1">
                        <div class="mb-3 d-flex align-items-center gap-2"> <i class="fa-regular fa-box"></i>
                            <h6>Asset Information</h6>
                        </div>
                        <div class="mb-3"> <label class="form-label"> Asset Name <span class="text-danger">*</span>
                            </label> <input type="text" class="form-control" name="asset_name" required /> </div>
                    </div>
                    <div id="slide2" style="display:none">
                        <div class="mb-3 d-flex align-items-center gap-2"> <i class="fa-solid fa-map-marker-alt"></i>
                            <h6>Assignment & Location</h6>
                        </div>
                        <div class="mb-3"> <label class="form-label">Assigned To</label> <input type="text"
                                class="form-control" name="assigned_to" /> </div>
                        <div class="mb-3"> <label class="form-label">Department</label> <select class="form-select"
                                name="department">
                                <option value="">Select department</option>
                                <option>IT Department</option>
                                <option>HR Department</option>
                                <option>Finance Department</option>
                                <option>Operations</option>
                                <option>Admin</option>
                            </select> </div>
                        <div class="mb-3"> <label class="form-label">Location</label> <select class="form-select"
                                name="location">
                                <option value="">Select location</option>
                                <option>Main Office</option>
                                <option>Warehouse</option>
                            </select> </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom"> <button type="button" class="btn btn-secondary"
                        onclick="pprevAssignSlidee()"> Back </button> <button type="button" class="next-btn"
                        onclick="nextAssignSlide()">Next</button> </div>
            </form>
        </div>
    </div>
</div>
<script>
    let assignModalSlide = 1; // separate from other scripts

    function showAssignSlide(slide) {
        // Hide all slides in assignModal
        document.querySelectorAll('#assignModal [id^="slide"]').forEach(el => el.style.display = 'none');

        const slideEl = document.querySelector('#assignModal #slide' + slide);
        if (slideEl) slideEl.style.display = 'block';

        // Update buttons
        const backBtn = document.querySelector('#assignModal .btn-secondary');
        const nextBtn = document.querySelector('#assignModal .next-btn');

        backBtn.style.display = slide === 1 ? 'none' : 'inline-block';
        nextBtn.textContent = slide === 2 ? 'Submit' : 'Next';

        assignModalSlide = slide;
    }

    function nextAssignSlide() {
        const assetName = document.querySelector('#assignModal [name="asset_name"]');
        if (assignModalSlide === 1) {
            if (!assetName.value.trim()) {
                assetName.classList.add('is-invalid');
                assetName.focus();
                return;
            } else {
                assetName.classList.remove('is-invalid');
            }
            showAssignSlide(2);
        } else {
            document.querySelector('#assignModal #assetForm').submit();
        }
    }

    function prevAssignSlide() {
        if (assignModalSlide === 2) showAssignSlide(1);
    }

    // Initialize modal
    document.addEventListener('DOMContentLoaded', () => {
        const assignModal = document.getElementById('assignModal');
        assignModal.addEventListener('show.bs.modal', () => {
            assignModal.querySelector('#assetForm').reset();
            assignModal.querySelector('[name="asset_name"]').classList.remove('is-invalid');
            showAssignSlide(1);
        });
    });
</script>
