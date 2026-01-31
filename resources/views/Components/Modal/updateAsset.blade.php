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

            const section = button.dataset.section;
            const url = button.dataset.url;
            const asset = JSON.parse(button.dataset.asset || '{}');
            const users = JSON.parse(button.dataset.users || '[]');
            const vendors = JSON.parse(button.dataset.vendors || '[]');

            form.action = url;
            modalFields.innerHTML = '';

            switch (section) {

                case 'asset-details':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Asset Name</label>
                        <input type="text" name="asset_name" class="form-control" value="${asset.asset_name ?? ''}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Operational Status</label>
                        <select class="form-select" name="operational_status">
                            ${['Active','Inactive','In Stock','Under Maintenance','Retired','Expired']
                                .map(status => `
                                    <option value="${status}" ${asset.operational_status === status ? 'selected' : ''}>
                                        ${status}
                                    </option>
                                `).join('')}
                        </select>
                    </div>
                `;
                    break;

                case 'technical-specs':
                    if (asset.technical_specifications?.length) {
                        asset.technical_specifications.forEach(spec => {
                            modalFields.innerHTML += `
                            <div class="mb-3">
                                <label class="form-label">${spec.spec_key.replace(/_/g,' ').toUpperCase()}</label>
                                <input type="text"
                                    name="technical[${spec.id}]"
                                    class="form-control"
                                    value="${spec.spec_value ?? ''}">
                            </div>
                        `;
                        });
                    }
                    break;

                case 'assignment-location':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Assigned To</label>
                        <select class="form-select" name="assigned_to">
                            ${users.map(u => `
                                <option value="${u.name}" ${u.name === asset.assigned_to ? 'selected' : ''}>
                                    ${u.name}
                                </option>
                            `).join('')}
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="${asset.department ?? ''}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="${asset.location ?? ''}">
                    </div>
                `;
                    break;

                case 'purchase-info':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Vendor</label>
                        <select class="form-select" name="vendor">
                            ${vendors.map(v => `
                                <option value="${v.name}" ${v.name === asset.vendor ? 'selected' : ''}>
                                    ${v.name}
                                </option>
                            `).join('')}
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" name="purchase_date" class="form-control" value="${asset.purchase_date ? new Date(asset.purchase_date).toISOString().split('T')[0] : ''}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purchase Cost</label>
                        <input type="number" step="0.01" name="purchase_cost" class="form-control" value="${asset.purchase_cost ?? ''}">
                    </div>
                `;
                    break;
                case 'depreciation-insights':
                    modalFields.innerHTML = `

                    <div class="mb-3">
                        <label class="form-label">Useful Life Years</label>
                        <input type="number" name="useful_life_years" class="form-control" value="${asset.useful_life_years ?? ''}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Salvage Value</label>
                        <input type="number" name="salvage_value" class="form-control" value="${asset.salvage_value ?? ''}">
                    </div>

                   
                `;
                    break;

                case 'maintenance-audit':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Compliance Status</label>
                        <select class="form-select" name="compliance_status">
                            <option value="Compliant" ${asset.compliance_status === 'Compliant' ? 'selected' : ''}>Compliant</option>
                            <option value="Non-Compliant" ${asset.compliance_status === 'Non-Compliant' ? 'selected' : ''}>Non-Compliant</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Warranty Start</label>
                        <input type="date" name="warranty_start" class="form-control" value="${asset.warranty_start ? new Date(asset.warranty_start).toISOString().split('T')[0] : ''}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Warranty End</label>
                        <input type="date" name="warranty_end" class="form-control" value="${asset.warranty_end ? new Date(asset.warranty_end).toISOString().split('T')[0] : ''}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Next Maintenance</label>
                        <input type="date" name="next_maintenance" class="form-control" value="${asset.next_maintenance ? new Date(asset.next_maintenance).toISOString().split('T')[0] : ''}">
                    </div>
                `;
                    break;

                case 'documents':
                    modalFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Contract</label>
                        <input type="file" name="contract" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purchase Order</label>
                        <input type="file" name="purchase_order" class="form-control">
                    </div>
                `;
                    break;
            }
        });
    });
</script>
