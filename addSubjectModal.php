<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center pt-4">
                <h5 class="modal-title fw-bold" style="font-size: 1.1rem;">Add New Subject</h5>
            </div>

            <div class="modal-body px-4 pb-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Academic Year</label>
                    <input type="text" id="new-year" class="form-control" placeholder="ex. 2025-2026">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Term Number</label>
                    <input type="number" id="new-term" class="form-control" placeholder="ex. 1">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject Code</label>
                    <input type="text" id="new-code" class="form-control" placeholder="ex. COSC1046">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject Title</label>
                    <input type="text" id="new-title" class="form-control" placeholder="ex. Software Engineering 1">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Section</label>
                    <input type="text" id="new-section" class="form-control" placeholder="ex. BSCS 501">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Number of Students</label>
                    <input type="number" id="new-students" class="form-control" placeholder="ex. 48">
                </div>
                <button type="button" class="btn btn-success w-100 py-2 fw-semibold shadow-sm"
                    id="save-new-subject" style="background-color:#0F8A33;border-color:#0F8A33;"
                    data-bs-dismiss="modal">
                    Save Subject
                </button>
            </div>
        </div>
    </div>
</div>

<script src="js/addSubjectModal.js"></script>