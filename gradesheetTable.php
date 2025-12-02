<div class="d-flex flex-wrap justify-content-between align-items-end mb-3">
    <div>
        <h4 class="fw-bold m-0 text-dark">Edit Gradesheet</h4>
        <p class="text-muted mb-0 small">COSC1046 • Fundamentals of Web Programming</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-white border bg-white btn-sm text-secondary shadow-sm" data-bs-toggle="modal" data-bs-target="#gradeSettingsModal">
            Grade Settings
        </button>
        <button class="btn btn-outline-danger btn-sm px-3 shadow-sm">- Archive Student</button>
        <button class="btn btn-outline-success btn-sm px-3 shadow-sm">Save Records</button>
        <button class="btn btn-outline-secondary btn-sm shadow-sm">Export Excel</button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
            <table class="table table-bordered align-middle mb-0" id="gradesheetTable">
                <thead>
                    <tr>
                        <th class="text-start ps-3 align-middle bg-light text-center" rowspan="2" style="min-width: 200px;">
                            STUDENT ID
                        </th>
                        <th class="text-start ps-3 align-middle bg-light text-center" rowspan="2" style="min-width: 200px;">
                            STUDENT NAME
                        </th>
                        <th class="text-center header-midterms" id="midterm-main-header" colspan="4">MIDTERM PERIOD</th>
                        <th class="text-center header-finals" id="finals-main-header" colspan="4">FINAL PERIOD</th>
                        <th class="text-center bg-light align-middle" rowspan="2" style="width: 80px;">
                            FINAL<br>RATING
                        </th>
                    </tr>
                    <tr id="sub-headers-row">
                        <th class="text-center text-secondary bg-white">Quiz 1</th>
                        <th class="text-center text-secondary bg-white">Act 1</th>
                        <th class="text-center text-secondary bg-white">Exam</th>
                        <th class="text-center text-primary bg-light fw-bold">Grade</th>
                        <th class="text-center text-secondary bg-white">Quiz 1</th>
                        <th class="text-center text-secondary bg-white">Act 1</th>
                        <th class="text-center text-secondary bg-white">Exam</th>
                        <th class="text-center text-success bg-light fw-bold">Grade</th>
                    </tr>
                </thead>
                <tbody id="gradesheet-body">
                    <tr>
                        <td>
                            <input type="text" class="form-control form-control-sm text-center studentID-input" value="02000123456">
                        </td>
                        <!-- Student Name -->
                        <td>
                            <input type="text" class="form-control form-control-sm text-center name-input" value="Fabricante, Marvin Russel Y.">
                        </td>

                        <!-- Midterm -->
                        <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="mQuiz" data-index="1" value="85"></td>
                        <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="mAct" data-index="1" value="90"></td>
                        <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="mExam" value="88"></td>
                        <td class="text-center fw-bold text-dark bg-light grade-display" data-col-type="mGrade">0</td>

                        <!-- Finals -->
                        <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="fQuiz" data-index="1" value="92"></td>
                        <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="fAct" data-index="1" value="87"></td>
                        <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="fExam" value="90"></td>
                        <td class="text-center fw-bold text-dark bg-light grade-display" data-col-type="fGrade">0</td>

                        <!-- Final Rating -->
                        <td class="text-center fw-bold text-primary final-grade-col">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'partials/modals/gradeSettingsModal.php'; ?>
