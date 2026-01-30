<div class="modal fade" id="updateAssetModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="updateAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <form id="updateAssetForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAssetModalLabel">Update Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="modal-fields">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class=" submit-btn">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('updateAssetModal');
        const modalFields = document.getElementById('modal-fields');
        const form = document.getElementById('updateAssetForm');

        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const section = button.getAttribute('data-section');
            const url = button.getAttribute('data-url');

            form.action = url;
            modalFields.innerHTML = '';

            switch (section) {
                case 'asset-details':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Asset Name</label>
                        <input type="text" name="asset_name" class="form-control" value="{{ $item->asset_name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Operational Status</label>
                        <select id="operational_status" class="form-select" name="operational_status" required>
                                <option value="">Select Category</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="In Stock">In Stock</option>
                                <option value="Under Maintenance">Under Maintenance</option>
                                <option value="Retired">Retired</option>
                                <option value="Expired">Expired</option>
                        </select>
                    </div>
                `;
                    break;

                case 'technical-specs':
                    @foreach ($item->technicalSpecifications as $spec)
                        modalFields.innerHTML += `
                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_', ' ', $spec->spec_key)) }}</label>
                            <input type="text" name="technical[{{ $spec->id }}]" class="form-control" value="{{ $spec->spec_value }}">
                        </div>
                    `;
                    @endforeach
                    break;

                case 'assignment-location':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Assigned To</label>
                     <select class="form-select" name="assigned_to">
                                <option value="{{ $item->assigned_to }}">{{ $item->assigned_to }}</option>
                                
                                @foreach ($users as $user)
                                
                                    <option value="{{ $user->name }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="{{ $item->department }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ $item->location }}">
                    </div>
                `;
                    break;

                case 'purchase-info':
                    modalFields.innerHTML = `
                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <select class="form-select" name="vendor">
                                <option value="{{ $item->vendor }}">{{ $item->vendor }}</option>
                                
                                @foreach ($vendors as $vendor)
                                
                                    <option value="{{ $vendor->name }}">
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input
                                type="date"
                                name="purchase_date"
                                class="form-control"
                                value="{{ $item->purchase_date }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Cost</label>
                            <input
                                type="number"
                                step="0.01"
                                name="purchase_cost"
                                class="form-control"
                                  value="{{ $item->purchase_cost }}">
                        </div>
                    `;
                    break;


                case 'maintenance-audit':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Compliance Status</label>
                        <select class="form-select" name="compliance_status">
                                <option value="{{ $item->compliance_status }}">{{ $item->compliance_status }}</option>
                                <option value="Compliant">Compliant</option>
                                <option value="Non-Compliant">Non-Compliant</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warranty Start</label>
                        <input type="date" name="warranty_start" class="form-control" value="{{ $item->warranty_start->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warranty End</label>
                        <input type="date" name="warranty_end" class="form-control" value="{{ $item->warranty_end->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Next Maintenance</label>
                        <input type="date" name="next_maintenance" class="form-control" value="{{ $item->next_maintenance->format('Y-m-d') }}">
                    </div>
                `;
                    break;

                case 'documents':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Contract URL</label>
                        <input type="file" name="contract" class="form-control" value="{{ $item->contract }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Purchase Order URL</label>
                        <input type="file" name="purchase_order" class="form-control" value="{{ $item->purchase_order }}">
                    </div>
                `;
                    break;
            }
        });
    });
</script>
