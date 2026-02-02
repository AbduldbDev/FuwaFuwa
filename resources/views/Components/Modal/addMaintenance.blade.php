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
                       <form id="maintenanceForm" action="{{ route('maintenance-repair.store') }}"
                           enctype="multipart/form-data" method="POST">
                           @csrf

                           <div class="row mb-5">
                               <div class="col-md-12">
                                   <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                                   <input type="text" id="maintenanceType" name="maintenance_type"
                                       class="form-control" readonly>
                               </div>
                           </div>

                           <!-- Corrective Fields -->
                           <div id="correctiveFields">
                               <div class="row mb-5">
                                   <div class="col-md-6">
                                       <label class="form-label">Reported By</label>
                                       <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                                   </div>
                                   <div class="col-md-6">
                                       <label class="form-label">Department</label>
                                       <input type="text" class="form-control"
                                           value="{{ Auth::user()->department }}">
                                   </div>
                               </div>

                               <div class="mb-3">
                                   <label class="form-label">Detailed Description</label>
                                   <textarea name="description" class="form-control" rows="3"></textarea>
                               </div>

                               <div class="mb-5">
                                   <label class="form-label">Attach Document(s)</label>
                                   <input type="file" name="document[]" class="form-control" multiple>
                               </div>

                           </div>

                           <!-- Shared Asset Info -->
                           <div class="row mb-3">
                               <div class="col-md-4">
                                   <label class="form-label">Asset</label>
                                   <select name="asset_tag" id="assetSelect" class="form-control">
                                       <option value="">-- Select Asset --</option>
                                       @foreach ($Assets as $item)
                                           <option value="{{ $item->asset_tag }}" data-tag="{{ $item->asset_tag }}"
                                               data-name="{{ $item->asset_name }}"
                                               data-last-maintenance="{{ $item->last_maintenance_date }}">
                                               {{ $item->asset_tag }} - {{ $item->asset_name }}
                                           </option>
                                       @endforeach
                                   </select>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Asset Name</label>
                                   <input type="text" name="asset_name" class="form-control">
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Last Maintenance Date</label>
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
                                       <input type="date" name="start_date" class="form-control">
                                   </div>
                                   <div class="col-md-6">
                                       <label class="form-label">Maintenance Frequency</label>
                                       <select name="frequency" id="frequency" class="form-select"></select>
                                   </div>
                               </div>

                               <div class="mb-3">
                                   <label class="form-label">Assign Technician</label>
                                   <input type="date" name="technician" class="form-control">
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
       document.addEventListener('DOMContentLoaded', function() {

           const modal = document.getElementById('assetIssueModal');

           modal.addEventListener('shown.bs.modal', function() {

               if (!$('#assetSelect').hasClass("select2-hidden-accessible")) {
                   $('#assetSelect').select2({
                       placeholder: 'Search asset...',
                       width: '100%',
                       dropdownParent: $('#assetIssueModal') // 🔥 REQUIRED
                   });
               }

           });

           $('#assetSelect').on('change', function() {
               let selected = $(this).find(':selected');

               $('input[name="asset_name"]').val(selected.data('name') ?? '');
               $('input[name="last_maintenance_date"]').val(
                   selected.data('last-maintenance') ?? ''
               );
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
                           'Monthly'
                       ] : ['Weekly', 'Monthly'];

                       options.forEach(o => {
                           frequency.insertAdjacentHTML('beforeend', `<option>${o}</option>`);
                       });
                   }
               }
               // If Step 2 → Submit
               else if (step2.classList.contains('active')) {
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
