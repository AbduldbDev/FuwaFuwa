<!-- Add Document Modal -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content add-document-modal">
            <div class="modal-header">
                <i class="fa-solid fa-file-circle-plus me-2"></i>
                <h5 class="modal-title fw-semibold">Add New Document</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('assets.addDocument', $item->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <input type="hidden" name="asset_id" value="{{ $item->id }}">
                    <!-- Document Info Header -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-file-lines"></i>
                        <h6>Document Information</h6>
                    </div>

                    <!-- Document Name -->
                    <div class="mb-3">
                        <label class="form-label">
                            Document Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="Enter document name"
                            required />
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">
                            Upload File <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="file" class="form-control"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png" required />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn submit-btn px-4">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
