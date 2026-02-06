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
                           <div class="col-md-6 ">
                               <div class="option-card" data-type="Corrective">
                                   <i class="fa-solid fa-screwdriver-wrench fa-2x mb-2"></i>
                                   <h6>Corrective</h6>
                                   <small>Repair</small>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="option-card" data-type="Preventive">
                                   <i class="fa-solid fa-calendar-check fa-2x mb-2"></i>
                                   <h6>Preventive</h6>
                                   <small>Scheduled</small>
                               </div>
                           </div>
                           {{-- <div class="col-md-4">
                               <div class="option-card" data-type="Inspection">
                                   <i class="fa-solid fa-clipboard-check fa-2x mb-2"></i>
                                   <h6>Inspection</h6>
                                   <small>Scheduled</small>
                               </div>
                           </div> --}}
                       </div>
                   </div>

                   <!-- STEP 2 -->
                   <div class="step" id="step2">
                       <div class="mb-3 d-flex align-items-center gap-2">
                           <i class="fa-solid fa-tools"></i>
                           <h6>Maintenance Information</h6>
                       </div>

                       <!-- form -->
                       <form id="maintenanceForm" action="{{ route('maintenance-repair.store') }}"
                           enctype="multipart/form-data" method="POST">
                           @csrf

                           <div class="row mb-5">
                               <div class="col-md-12">
                                   <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                                   <input type="text" id="maintenanceType" name="maintenance_type" required
                                       class="form-control" readonly>
                               </div>
                           </div>

                           <!-- Corrective Fields -->
                           <div id="correctiveFields">
                               <div class="row mb-5">
                                   <div class="col-md-6">
                                       <label class="form-label">Reported By <span class="text-danger">*</span></label>
                                       <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                                   </div>
                                   <div class="col-md-6">
                                       <label class="form-label">Department <span class="text-danger">*</span></label>
                                       <input type="text" class="form-control" value="{{ Auth::user()->department }}"
                                           required>
                                   </div>
                               </div>

                               <div class="mb-3">
                                   <label class="form-label">Detailed Description <span
                                           class="text-danger">*</span></label>
                                   <textarea name="description" class="form-control" rows="3" required></textarea>
                               </div>

                               <div class="mb-5">
                                   <label class="form-label">Attach Document(s)</label>
                                   <input type="file" name="document[]" class="form-control" multiple>
                               </div>

                           </div>

                           <!-- Shared Asset Info -->
                           <div class="row mb-3">
                               <div class="col-md-4">
                                   <div class="position-relative">
                                       <label class="form-label">Asset Tags <span class="text-danger">*</span></label>
                                       <input type="text" id="assetInput" class="form-control"
                                           placeholder="Type to search asset" required>

                                       <div id="assetDropdown" class="list-group position-absolute w-100 d-none"
                                           style="max-height:200px; overflow:auto; z-index:1055;">
                                           @foreach ($Assets as $item)
                                               <button type="button" class="list-group-item list-group-item-action"
                                                   data-tag="{{ $item->asset_tag }}" data-name="{{ $item->asset_name }}"
                                                   data-next="{{ $item->last_maintenance }}">
                                                   {{ $item->asset_tag }} - {{ $item->asset_name }}
                                               </button>
                                           @endforeach
                                       </div>
                                   </div>

                                   <input type="hidden" name="asset_tag">

                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Asset Name <span class="text-danger">*</span></label>
                                   <input type="text" name="asset_name" class="form-control" Asset Tags>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Last Maintenance Date </label>
                                   <input type="date" name="last_maintenance_date" class="form-control">
                               </div>
                           </div>

                           <!-- Priority -->
                           <div class="mb-5">
                               <label class="form-label d-block">Priority Level</label>
                               <div class="d-flex gap-4">
                                   <div class="form-check">
                                       <input class="form-check-input shadow-none" type="radio" name="priority"
                                           value="Low" checked />
                                       <label class="form-check-label">Low</label>
                                   </div>
                                   <div class="form-check">
                                       <input class="form-check-input shadow-none" type="radio" name="priority"
                                           value="Medium" />
                                       <label class="form-check-label">Medium</label>
                                   </div>
                                   <div class="form-check">
                                       <input class="form-check-input shadow-none" type="radio" name="priority"
                                           value="High" />
                                       <label class="form-check-label">High</label>
                                   </div>
                                   <div class="form-check">
                                       <input class="form-check-input shadow-none" type="radio" name="priority"
                                           value="Emergency" />
                                       <label class="form-check-label">Emergency</label>
                                   </div>
                               </div>
                           </div>

                           <!-- Schedule Fields -->
                           <div id="scheduleFields">
                               <div class="row mb-3">
                                   <div class="col-md-6">
                                       <label class="form-label">Start Date</label>
                                       <input type="date" name="start_date" class="form-control" required>
                                   </div>
                                   <div class="col-md-6">
                                       <label class="form-label">Maintenance Frequency</label>
                                       <select name="frequency" id="frequency" class="form-select" required></select>
                                   </div>
                               </div>

                               <div class="mb-3">
                                   <label class="form-label">Assign Technician</label>
                                   <input type="text" name="technician" class="form-control" required>
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
   <script>
       document.addEventListener('DOMContentLoaded', () => {

           const input = document.getElementById('assetInput');
           const dropdown = document.getElementById('assetDropdown');
           const hidden = document.querySelector('input[name="asset_tag"]');

           // Filter dropdown while typing
           input.addEventListener('input', () => {
               const filter = input.value.toLowerCase();
               let hasMatch = false;

               dropdown.querySelectorAll('button').forEach(item => {
                   const text = item.textContent.toLowerCase();
                   const match = text.includes(filter);
                   item.classList.toggle('d-none', !match);
                   if (match) hasMatch = true;
               });

               dropdown.classList.toggle('d-none', !hasMatch);
           });

           // Click to select an asset
           dropdown.addEventListener('click', e => {
               if (e.target.tagName === 'BUTTON') {
                   const btn = e.target;

                   // Put the asset_tag in the input
                   input.value = btn.dataset.tag;

                   // Put the asset_tag in hidden for form submission
                   hidden.value = btn.dataset.tag;

                   // Fill asset name
                   document.querySelector('input[name="asset_name"]').value =
                       btn.dataset.name || '';

                   // Fill next maintenance date (YYYY-MM-DD)
                   document.querySelector('input[name="last_maintenance_date"]').value =
                       btn.dataset.next ? btn.dataset.next.split(' ')[0] : '';

                   dropdown.classList.add('d-none');
               }
           });

           // Close dropdown if click outside
           document.addEventListener('click', e => {
               if (!e.target.closest('.position-relative')) {
                   dropdown.classList.add('d-none');
               }
           });

       });
   </script>

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
           const form = document.getElementById('maintenanceForm');

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
               e.preventDefault();

               if (!selectedType) return;

               // If Step 1 → Step 2
               if (step1.classList.contains('active')) {
                   step1.classList.remove('active');
                   step2.classList.add('active');
                   backBtn.disabled = false;
                   nextBtn.textContent = 'Submit';

                   document.getElementById('maintenanceType').value = selectedType;

                   if (selectedType === 'Corrective') {
                       correctiveFields.style.display = 'block';
                       scheduleFields.style.display = 'none';
                   } else {
                       correctiveFields.style.display = 'none';
                       scheduleFields.style.display = 'block';

                       frequency.innerHTML = '';
                       const options = selectedType === 'Preventive' ? ['Semi-Annual', 'Quarterly',
                           'Monthly', 'Weekly'
                       ] : ['Weekly', 'Monthly'];

                       options.forEach(o => {
                           frequency.insertAdjacentHTML('beforeend',
                               `<option value="${o}">${o}</option>`);
                       });
                   }
               }
               // If Step 2 → Submit
               else if (step2.classList.contains('active')) {

                   // Only validate visible required fields
                   const requiredFields = Array.from(form.querySelectorAll('[required]'))
                       .filter(field => field.offsetParent !== null); // offsetParent null means hidden

                   let allFilled = true;

                   requiredFields.forEach(field => {
                       if (!field.value) {
                           field.classList.add('is-invalid'); // optional: highlight
                           allFilled = false;
                       } else {
                           field.classList.remove('is-invalid');
                       }
                   });

                   if (!allFilled) {
                       alert('Please fill in all required fields before submitting.');
                       return;
                   }

                   form.submit(); // 🚀 Submit the form
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
