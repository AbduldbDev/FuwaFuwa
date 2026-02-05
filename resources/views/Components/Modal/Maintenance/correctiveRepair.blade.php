 <div class="modal fade" id="scheduleMaintenance{{ $item->id }}" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content rounded-3">
             <!-- modal header -->
             <div class="modal-header">
                 <i class="fa-regular fa-calendar me-2"></i>
                 <h5 class="modal-title fw-semibold">
                     Schedule Maintenance
                 </h5>
                 <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
             </div>

             <!-- modal body -->
             <div class="modal-body px-4">
                 <!-- ===== maintenance information ===== -->
                 <section class="mb-4">
                     <h6 class="fw-semibold mb-3">
                         <i class="fa-solid fa-tools me-2"></i>
                         Maintenance Information
                     </h6>

                     <div class="row g-3">
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Maintenance ID</label>
                             <div class="description-text fw-semibold">{{ $item->maintenance_id }}</div>
                         </div>
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Maintenance Type</label>
                             <div class="description-text fw-semibold">{{ $item->maintenance_type }}</div>
                         </div>
                     </div>
                 </section>

                 <hr />

                 <!-- ===== asset information ===== -->
                 <section class="mb-4">
                     <h6 class="fw-semibold mb-3">
                         <i class="fa-solid fa-box me-2"></i>
                         Asset Information
                     </h6>

                     <div class="row g-3">
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Asset Tag</label>
                             <div class="description-text fw-semibold">{{ $item->asset_tag }}</div>
                         </div>
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Asset Name</label>
                             <div class="description-text fw-semibold">{{ $item->asset_name }}</div>
                         </div>
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Last Maintenance Date</label>
                             <div class="description-text fw-semibold">
                                 {{ \Carbon\Carbon::parse($item->last_maintenance_date)->format('F d, Y') }}</div>
                         </div>
                     </div>
                 </section>

                 <hr />

                 <!-- ===== issue/task description ===== -->
                 <section class="mb-4">
                     <h6 class="fw-semibold mb-3">
                         <i class="fa-solid fa-clipboard-list me-2"></i>
                         Issue/Task Description
                     </h6>

                     <div class="mb-3">
                         <label class="form-label text-muted">Detailed Description</label>
                         <div class="description-text fw-semibold">{{ $item->description }}</div>
                     </div>

                     @if ($item->documents)
                         <div class="mb-3">
                             <label class="form-label text-muted">Attached Files</label>
                             <ul class="fw-semibold">
                                 @foreach (json_decode($item->documents) as $file)
                                     <li> <a href="{{ $file }}" target="_blank" class="file-link">
                                             {{ basename($file) }}
                                         </a>
                                     </li>
                                 @endforeach
                             </ul>
                         </div>
                     @endif
                 </section>

                 <hr />

                 <!-- ===== priority ===== -->
                 <section class="mb-4">
                     <h6 class="fw-semibold mb-3">
                         <i class="fa-solid fa-flag me-2"></i>
                         Priority Level
                     </h6>
                     @php
                         $priorityClass = match ($item->priority) {
                             'Low' => 'low',
                             'Medium' => 'medium',
                             'High' => 'high',
                             'Emergency' => 'emergency',
                             default => 'low',
                         };
                     @endphp

                     <span class="priority-badge low" style="font-size: 14px;">
                         {{ $item->priority }}
                     </span>
                 </section>

                 <hr />

                 <!-- ===== maintenance schedule ===== -->
                 <section class="mb-4">
                     <form id="scheduleForm{{ $item->id }}"
                         action="{{ route('maintenance-repair.update', $item->id) }}" method="POST"
                         enctype="multipart/form-data">
                         @csrf
                         @method('PUT')
                         <h6 class="fw-semibold mb-3" style="font-size: 20px;">
                             <i class="fa-solid fa-calendar-days me-2"></i>
                             Maintenance Schedule
                         </h6>

                         <div class="row g-3">
                             <!-- Scheduled Date -->
                             <div class="col-md-6">
                                 <label class="form-label text-muted">
                                     Start Date <span class="text-danger">*</span>
                                 </label>
                                 <input type="date" class="form-control" name="start_date" />
                             </div>

                             <!-- Assigned Technician -->
                             <div class="col-md-6">
                                 <label for="assignedTechnician" class="form-label text-muted">
                                     Assigned Technician
                                 </label>
                                 <input type="text" class="form-control" name="technician" />
                             </div>
                         </div>
                     </form>
                 </section>

             </div>

             <!-- modal footer -->
             <div class="modal-footer">
                 <button class="back-btn shadow-none" data-bs-dismiss="modal">
                     Close
                 </button>
                 <button class="btn btn-success shadow-none"
                     onclick="document.getElementById('scheduleForm{{ $item->id }}').submit()">
                     <i class="fa-solid fa-check me-1"></i> Submit
                 </button>
             </div>
         </div>
     </div>
 </div>
