<div class="modal fade" id="manageSubjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header pt-4 border-bottom-0">
                <h5 class="modal-title fw-bold text-center w-100" id="manage-modal-title">Manage Subject Records</h5>
            </div>
            <div class="modal-body px-4 pb-4">
                <p class="text-muted text-center mb-4">Update the gradesheet data for <span class="fw-semibold text-dark" id="current-managed-subject">[Subject Title]</span>.</p>

                <div class="p-4 border-2 border-dashed border-gray-300 rounded-lg text-center bg-gray-50 mb-4">
                    <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                    <h6 class="fw-bold mb-2">Upload Gradesheet Excel File</h6>
                    <p class="text-sm text-muted mb-3">Drag and drop your Excel file here, or click to browse. (.xlsx, .xls)</p>
                    
                    <!-- Hidden file input linked to the button below -->
                    <input type="file" id="excel-upload-input" accept=".xlsx, .xls" class="d-none">
                    <button id="trigger-upload" class="btn btn-outline-success btn-sm fw-semibold">Browse Files</button>
                </div>

                <ul class="list-group mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center text-sm">
                        Total Students
                        <span class="badge bg-primary rounded-pill" id="managed-student-count">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-sm">
                        Last Updated
                        <span class="text-muted" id="managed-last-updated">N/A</span>
                    </li>
                </ul>

                <button type="button" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm"
                    id="simulate-upload-button"
                    data-bs-dismiss="modal">
                    Simulate Update & Close
                </button>
            </div>
        </div>
    </div>
</div>
