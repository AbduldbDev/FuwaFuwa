 <div class="modal fade" id="viewCorrectiveMaintenance{{ $item->id }}" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content rounded-3">
             <!-- modal header -->
             <div class="modal-header">
                 <i class="fa-solid fa-circle-check me-2"></i>
                 <h5 class="modal-title fw-semibold">
                     Completed
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
                             <div class="description-text fw-semibold">{{ $item->asset_tag ?? 'N/A' }}</div>
                         </div>
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Asset Name</label>
                             <div class="description-text fw-semibold">{{ $item->asset_name ?? 'N/A' }}</div>
                         </div>
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Last Maintenance Date</label>
                             <div class="description-text fw-semibold">
                                 {{ \Carbon\Carbon::parse($item->last_maintenance_date)->format('M d, Y') }}</div>
                         </div>
                     </div>
                 </section>

                 <hr />

                 <!-- ===== issue/task description ===== -->

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
                     <h6 class="fw-semibold mb-3">
                         <i class="fa-solid fa-calendar-days me-2"></i>
                         Maintenance Schedule
                     </h6>

                     <div class="row g-3">
                         <!-- Scheduled Date -->
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Scheduled Date</label>
                             <div class="description-text fw-semibold">
                                 {{ \Carbon\Carbon::parse($item->start_date)->format('M d, Y') }}</div>
                         </div>

                         <!-- Assigned Technician -->
                         <div class="col-lg-6">
                             <label class="form-label text-muted">Assigned Technician</label>
                             <div class="description-text fw-semibold">{{ $item->technician }}</div>
                         </div>
                     </div>

                 </section>

                 <hr />

                 <!-- post service details -->
                 <section class="mb-4">
                     <h6 class="fw-semibold mb-3" style="font-size: 20px;">
                         <i class="fa-solid fa-calendar-days me-2"></i>
                         Activity Feed
                     </h6>

                     <div class="row">
                         <!-- condition post-service -->
                         <div class="col-md-12 mb-3">
                             <label class="form-label text-muted">Condition Post Service</label>
                             <div class="description-text fw-semibold">{{ $item->post_description }}
                             </div>
                         </div>

                         @if ($item->documents)
                             <div class="col-md-6 mb-3">
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

                         <!-- next maintenance schedule -->
                         <div class="col-md-6 mb-3">
                             <label class="form-label text-muted">Start Date</label>
                             <div class="description-text fw-semibold">
                                 {{ \Carbon\Carbon::parse($item->start_date)->format('M d, Y') }}</div>
                         </div>

                         <div class="col-md-6 mb-3">
                             <label class="form-label text-muted">Completion Date</label>
                             <div class="description-text fw-semibold">
                                 {{ \Carbon\Carbon::parse($item->completed_at)->format('M d, Y h:i a') }}</div>
                         </div>
                     </div>

                 </section>

             </div>

             <!-- modal footer -->
             <div class="modal-footer">
                 <button class="back-btn shadow-none" data-bs-dismiss="modal">
                     Close
                 </button>
             </div>
         </div>
     </div>
 </div>
