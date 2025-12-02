<div class="modal fade" id="gradeSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered **modal-md**">
        <div class="modal-content">
            <div class="modal-header justify-content-center pt-4" style="background-color: #f8f9fa;">
                <h5 class="modal-title fw-bold" style="font-size: 1.25rem; color: #0F8A33;">Gradesheet Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                
                <div class="mb-4 pb-3 border-bottom">
                    <label class="form-label text-dark fw-bold mb-1">Total Number of Students</label>
                    <div class="input-group input-group-lg">
                        <input type="number" id="total-students-count" class="form-control text-center fw-bold" value="40" min="1">
                        <span class="input-group-text bg-light text-secondary">rows</span>
                    </div>
                </div>
                
                <div class="row g-4 mb-4">
                    
                    <div class="col-md-6">
                        <div class="setting-box setting-box-midterm p-3 border rounded h-100">
                            <h6 class="setting-title fw-bold mb-3" style="color: #0F8A33;">Midterm Components</h6>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="setting-label text-secondary">Number of Quizzes:</label>
                                <input type="number" id="midterm-quiz-count" class="form-control form-control-sm text-center bg-white border" value="1" min="0" style="width: 70px;">
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="setting-label text-secondary">Number of Activities:</label>
                                <input type="number" id="midterm-act-count" class="form-control form-control-sm text-center bg-white border" value="1" min="0" style="width: 70px;">
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <label class="setting-label text-dark fw-semibold">Final Exam:</label>
                                <span class="fw-bold text-success">1</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="setting-box setting-box-finals p-3 border rounded h-100">
                            <h6 class="setting-title fw-bold mb-3" style="color: #0F8A33;">Finals Components</h6>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="setting-label text-secondary">Number of Quizzes:</label>
                                <input type="number" id="finals-quiz-count" class="form-control form-control-sm text-center bg-white border" value="1" min="0" style="width: 70px;">
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="setting-label text-secondary">Number of Activities:</label>
                                <input type="number" id="finals-act-count" class="form-control form-control-sm text-center bg-white border" value="1" min="0" style="width: 70px;">
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <label class="setting-label text-dark fw-semibold">Final Exam:</label>
                                <span class="fw-bold text-success">1</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="save-settings-btn" class="btn w-100 py-2 fw-semibold shadow-sm" style="background-color: #0F8A33; border-color: #0F8A33; color: white;" data-bs-dismiss="modal">
                    Save Settings
                </button>

            </div>
        </div>
    </div>
</div>
<script>
document.getElementById("save-settings-btn").addEventListener("click", function () {

    /* ===============================
       1. READ SETTINGS VALUES
    ================================ */
    const totalStudents = parseInt(document.getElementById("total-students-count").value);

    const mQuiz = parseInt(document.getElementById("midterm-quiz-count").value);
    const mAct = parseInt(document.getElementById("midterm-act-count").value);

    const fQuiz = parseInt(document.getElementById("finals-quiz-count").value);
    const fAct = parseInt(document.getElementById("finals-act-count").value);

    const gradesheetTbody = document.getElementById("gradesheet-body");
    const mainHeader = document.getElementById("sub-headers-row");

    /* ===============================
        2. REBUILD SUB-HEADERS
    ================================ */
    let headerHTML = "";

    // Midterm Quizzes
    for (let i = 1; i <= mQuiz; i++) {
        headerHTML += `<th class="text-center text-secondary bg-white">Quiz ${i}</th>`;
    }

    // Midterm Activities
    for (let i = 1; i <= mAct; i++) {
        headerHTML += `<th class="text-center text-secondary bg-white">Act ${i}</th>`;
    }

    // Midterm Exam + Grade
    headerHTML += `
        <th class="text-center text-secondary bg-white">Exam</th>
        <th class="text-center text-primary bg-light fw-bold">Grade</th>
    `;

    // Finals Quizzes
    for (let i = 1; i <= fQuiz; i++) {
        headerHTML += `<th class="text-center text-secondary bg-white">Quiz ${i}</th>`;
    }

    // Finals Activities
    for (let i = 1; i <= fAct; i++) {
        headerHTML += `<th class="text-center text-secondary bg-white">Act ${i}</th>`;
    }

    // Finals Exam + Grade
    headerHTML += `
        <th class="text-center text-secondary bg-white">Exam</th>
        <th class="text-center text-success bg-light fw-bold">Grade</th>
    `;

    mainHeader.innerHTML = headerHTML;

    /* ===============================
       3. UPDATE MAIN TOP HEADERS
    ================================ */
    // Midterm colspan
    document.getElementById("midterm-main-header").setAttribute("colspan", mQuiz + mAct + 2);

    // Finals colspan
    document.getElementById("finals-main-header").setAttribute("colspan", fQuiz + fAct + 2);


    /* ===============================
       4. REBUILD STUDENT ROWS
    ================================ */
    gradesheetTbody.innerHTML = ""; // clear

    for (let i = 0; i < totalStudents; i++) {
        let row = `<tr>`;

        // Student ID
        row += `
            <td><input type="text" class="form-control form-control-sm text-center studentID-input"></td>
        `;

        // Student Name
        row += `
            <td><input type="text" class="form-control form-control-sm text-center name-input"></td>
        `;

        /* -------- MIDTERM -------- */
        // Midterm Quizzes
        for (let q = 1; q <= mQuiz; q++) {
            row += `
                <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="mQuiz" data-index="${q}"></td>
            `;
        }

        // Midterm Activities
        for (let a = 1; a <= mAct; a++) {
            row += `
                <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="mAct" data-index="${a}"></td>
            `;
        }

        // Midterm Exam
        row += `
            <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="mExam"></td>
        `;

        // Midterm Grade
        row += `
            <td class="text-center fw-bold text-dark bg-light grade-display" data-col-type="mGrade">0</td>
        `;


        /* -------- FINALS -------- */
        // Finals Quizzes
        for (let q = 1; q <= fQuiz; q++) {
            row += `
                <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="fQuiz" data-index="${q}"></td>
            `;
        }

        // Finals Activities
        for (let a = 1; a <= fAct; a++) {
            row += `
                <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="fAct" data-index="${a}"></td>
            `;
        }

        // Finals Exam
        row += `
            <td><input type="number" class="form-control form-control-sm text-center grade-input" data-col-type="fExam"></td>
        `;

        // Finals Grade
        row += `
            <td class="text-center fw-bold text-dark bg-light grade-display" data-col-type="fGrade">0</td>
        `;

        // Final Rating
        row += `
            <td class="text-center fw-bold text-primary final-grade-col">0</td>
        `;

        row += `</tr>`;

        gradesheetTbody.innerHTML += row;
    }

});

document.addEventListener("input", function (e) {
    if (!e.target.classList.contains("grade-input")) return;

    const row = e.target.closest("tr");

    calculateMidterm(row);
    calculateFinals(row);
    calculateFinalRating(row);
});

/* ============================================================
   MIDTERM GRADE CALCULATION (20% Quiz, 30% Act, 50% Exam)
============================================================ */
function calculateMidterm(row) {
    let quizScores = [];
    let actScores = [];
    let examScore = 0;

    row.querySelectorAll('input[data-col-type="mQuiz"]').forEach(q => {
        if (q.value !== "") quizScores.push(parseFloat(q.value));
    });

    row.querySelectorAll('input[data-col-type="mAct"]').forEach(a => {
        if (a.value !== "") actScores.push(parseFloat(a.value));
    });

    const examInput = row.querySelector('input[data-col-type="mExam"]');
    if (examInput && examInput.value !== "") {
        examScore = parseFloat(examInput.value);
    }

    const quizAvg = quizScores.length ? (quizScores.reduce((a, b) => a + b, 0) / quizScores.length) : 0;
    const actAvg = actScores.length ? (actScores.reduce((a, b) => a + b, 0) / actScores.length) : 0;

    const midtermGrade = (quizAvg * 0.20) + (actAvg * 0.30) + (examScore * 0.50);

    row.querySelector('[data-col-type="mGrade"]').textContent = midtermGrade.toFixed(2);
}

/* ============================================================
   FINALS GRADE CALCULATION (20% Quiz, 30% Act, 50% Exam)
============================================================ */
function calculateFinals(row) {
    let quizScores = [];
    let actScores = [];
    let examScore = 0;

    row.querySelectorAll('input[data-col-type="fQuiz"]').forEach(q => {
        if (q.value !== "") quizScores.push(parseFloat(q.value));
    });

    row.querySelectorAll('input[data-col-type="fAct"]').forEach(a => {
        if (a.value !== "") actScores.push(parseFloat(a.value));
    });

    const examInput = row.querySelector('input[data-col-type="fExam"]');
    if (examInput && examInput.value !== "") {
        examScore = parseFloat(examInput.value);
    }

    const quizAvg = quizScores.length ? (quizScores.reduce((a, b) => a + b, 0) / quizScores.length) : 0;
    const actAvg = actScores.length ? (actScores.reduce((a, b) => a + b, 0) / actScores.length) : 0;

    const finalsGrade = (quizAvg * 0.20) + (actAvg * 0.30) + (examScore * 0.50);

    row.querySelector('[data-col-type="fGrade"]').textContent = finalsGrade.toFixed(2);
}

/* ============================================================
   FINAL RATING = (Midterm Grade + Finals Grade) / 2
============================================================ */
function calculateFinalRating(row) {
    const m = parseFloat(row.querySelector('[data-col-type="mGrade"]').textContent) || 0;
    const f = parseFloat(row.querySelector('[data-col-type="fGrade"]').textContent) || 0;

    const finalRating = (m + f) / 2;

    row.querySelector('.final-grade-col').textContent = finalRating.toFixed(2);
}
</script>

