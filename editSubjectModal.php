<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Subject</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit-row-index">

                <div class="mb-3">
                    <label class="form-label">Academic Year</label>
                    <input type="text" id="edit-year-input" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Term Number</label>
                    <input type="number" id="edit-term-input" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject Code</label>
                    <input type="text" id="edit-code-input" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject Name</label>
                    <input type="text" id="edit-subject-input" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">No. of Students</label>
                    <input type="number" id="edit-students-input" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <input type="text" id="edit-section-input" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-warning w-100" id="update-subject-btn">Save Changes</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="updateConfirmModal" tabindex="-1" aria-labelledby="updateConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-warning" id="updateConfirmModalLabel">Confirm Changes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <p class="mb-2">Are you sure you want to save the changes for this subject?</p>
                <p class="fw-bold text-dark fs-6" id="confirm-subject-code-display"></p>
                <small class="text-muted">You will not be able to undo the edit immediately.</small>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Keep Editing</button>
                <button type="button" class="btn btn-warning btn-sm text-white" id="confirm-update-btn">Confirm Update</button>
            </div>
        </div>
    </div>
</div>

<script src="js/editSubjectModal.js"></script>