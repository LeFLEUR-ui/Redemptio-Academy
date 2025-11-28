function inputFieldHTML(studentNo, name, value, label) {
    return `
        <td class='p-1 text-center' data-label='${label}'>
            <input type='number' name='grades[${studentNo}][${name}]' value='${value}' min='0' max='100'
                   class='w-16 h-8 text-center text-sm border border-gray-300 rounded focus:border-ra-primary focus:ring-ra-primary'
                   onchange="updateCalculatedGrades(this, '${studentNo}')" data-grade-key="${name}" data-student-no="${studentNo}" />
        </td>
    `;
}

window.loadGradesheet = function(subjectId) {
    const currentSubject = subjectsData.find(s => s.id === subjectId);
    const studentsGrades = allStudentsGrades[subjectId] || [];

    const gradesheetSection = document.getElementById('gradesheet-section');
    if (!currentSubject) {
        if (gradesheetSection) gradesheetSection.classList.add('hidden');
        return;
    }

    const titleElement = document.getElementById('gradesheet-title');
    const idElement = document.getElementById('gradesheet-subject-id');
    const tbody = document.getElementById('gradesheet-table-body');

    if (titleElement) titleElement.innerHTML = `Edit Gradesheet: ${currentSubject.code} - ${currentSubject.name}`;
    if (idElement) idElement.value = subjectId;
    if (gradesheetSection) gradesheetSection.classList.remove('hidden');

    let html = '';

    studentsGrades.forEach(student => {
        const grades = calculate_final_grade(student);

        html += `
            <tr class="hover:bg-gray-50 transition duration-100" id="student-row-${student.student_no}">
                <td class="px-3 py-2 text-sm text-gray-600 font-medium whitespace-nowrap" data-label="Student No.">${student.student_no}</td>
                <td class="px-3 py-2 text-sm text-gray-800 font-semibold whitespace-nowrap" data-label="Student Name">${student.name}</td>

                ${inputFieldHTML(student.student_no, 'midterm_q1', student.midterm_q1, 'Midterm Quiz 1')}
                ${inputFieldHTML(student.student_no, 'midterm_a1', student.midterm_a1, 'Midterm Activity 1')}
                ${inputFieldHTML(student.student_no, 'midterm_exam', student.midterm_exam, 'Midterm Exam')}
                <td class="p-1 text-center text-sm font-bold bg-blue-50" data-label="Midterm Grade" id="midterm-grade-${student.student_no}">${grades.midterm}</td>

                ${inputFieldHTML(student.student_no, 'finals_q1', student.finals_q1, 'Finals Quiz 1')}
                ${inputFieldHTML(student.student_no, 'finals_a1', student.finals_a1, 'Finals Activity 1')}
                ${inputFieldHTML(student.student_no, 'finals_exam', student.finals_exam, 'Finals Exam')}
                <td class="p-1 text-center text-sm font-bold bg-green-50" data-label="Finals Grade" id="finals-grade-${student.student_no}">${grades.finals}</td>

                <td class="p-1 text-center text-lg font-extrabold text-ra-primary bg-gray-50" data-label="Final Grade" id="final-grade-${student.student_no}">${grades.final}</td>
            </tr>
        `;
    });
    if (tbody) tbody.innerHTML = html;
};

window.updateCalculatedGrades = function(_inputElement, studentNo) {
    const studentRow = document.getElementById(`student-row-${studentNo}`);
    if (!studentRow) return;

    const currentGrades = {};
    const inputFields = studentRow.querySelectorAll('input[type="number"]');
    inputFields.forEach(input => {
        const gradeKey = input.getAttribute('data-grade-key');
        currentGrades[gradeKey] = parseInt(input.value) || 0;
    });

    const newGrades = calculate_final_grade(currentGrades);

    const midtermEl = document.getElementById(`midterm-grade-${studentNo}`);
    const finalsEl = document.getElementById(`finals-grade-${studentNo}`);
    const finalEl = document.getElementById(`final-grade-${studentNo}`);

    if (midtermEl) midtermEl.textContent = newGrades.midterm;
    if (finalsEl) finalsEl.textContent = newGrades.finals;
    if (finalEl) finalEl.textContent = newGrades.final;
}

document.addEventListener('DOMContentLoaded', () => {
    renderSubjectsTable();

    const urlParams = new URLSearchParams(window.location.search);
    const selectedSubjectId = urlParams.get('subject_id');
    if (selectedSubjectId) {
        loadGradesheet(parseInt(selectedSubjectId));
    }
});

function regenerateGradesheetColumns(settings) {
    const table = document.querySelector('#gradesheet-table table');
    const thead = document.querySelector('#gradesheet-table thead');
    const tbody = document.getElementById('gradesheet-table-body');
    const subjectId = document.getElementById('gradesheet-subject-id').value || 'placeholder_id';

    if (!table || !thead || !tbody) return;

    const quizCountMidterm = settings.midtermQuizzes;
    const activityCountMidterm = settings.midtermActivities;
    const quizCountFinals = settings.finalsQuizzes;
    const activityCountFinals = settings.finalsActivities;

    const midtermColspan = quizCountMidterm + activityCountMidterm + 2;
    const finalsColspan = quizCountFinals + activityCountFinals + 2;

    thead.innerHTML = '';

    let row1 = `<tr>
        <th rowspan="2" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">Student No.</th>
        <th rowspan="2" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-3/12">Student Name</th>
        <th colspan="${midtermColspan}" class="px-3 py-3 text-center text-xs font-semibold text-white bg-blue-600 uppercase tracking-wider border-l border-r border-blue-700">Midterm</th>
        <th colspan="${finalsColspan}" class="px-3 py-3 text-center text-xs font-semibold text-white bg-green-600 uppercase tracking-wider border-r border-green-700">Finals</th>
        <th rowspan="2" class="px-3 py-3 text-center text-xs font-extrabold text-gray-700 uppercase tracking-wider w-1/12 border-l">Final Grade</th>
    </tr>`;

    let row2 = `<tr>`;
    for (let i = 1; i <= quizCountMidterm; i++) row2 += `<th class="py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-200">Q${i}</th>`;
    for (let i = 1; i <= activityCountMidterm; i++) row2 += `<th class="py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-200">A${i}</th>`;
    row2 += `<th class="py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-200">Exam</th>`;
    row2 += `<th class="py-2 text-center text-xs font-bold text-gray-800 bg-blue-100 border-r border-gray-200">Midterm Grade</th>`;
    for (let i = 1; i <= quizCountFinals; i++) row2 += `<th class="py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-200">Q${i}</th>`;
    for (let i = 1; i <= activityCountFinals; i++) row2 += `<th class="py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-200">A${i}</th>`;
    row2 += `<th class="py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-200">Exam</th>`;
    row2 += `<th class="py-2 text-center text-xs font-bold text-gray-800 bg-green-100 border-r border-gray-200">Finals Grade</th>`;
    row2 += `</tr>`;

    thead.insertAdjacentHTML('beforeend', row1);
    thead.insertAdjacentHTML('beforeend', row2);

    const students = getStudentsForSubject(subjectId);
    tbody.innerHTML = ''; 
    const bodyHtml = createInputFields(students, settings);
    tbody.insertAdjacentHTML('beforeend', bodyHtml);
}

function createInputFields(students, settings) {
    let html = '';

    students.forEach((student, studentIndex) => {
        html += `<tr id="student-row-${student.student_id}" class="${studentIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50'} hover:bg-gray-100 transition duration-100">`;
        html += `<td class="px-3 py-2 whitespace-nowrap text-sm font-mono text-gray-900">${student.student_id}</td>`;
        html += `<td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">${student.name}</td>`;

        const terms = [
            { prefix: 'midterm', quizzes: settings.midtermQuizzes, activities: settings.midtermActivities, bgClass: 'text-blue-700' },
            { prefix: 'finals', quizzes: settings.finalsQuizzes, activities: settings.finalsActivities, bgClass: 'text-green-700' }
        ];

        terms.forEach(term => {
            // QUIZZES
            for (let i = 1; i <= term.quizzes; i++) {
                const key = `${term.prefix}_quiz_${i}`;
                html += `
                    <td class="p-1 text-center border-r border-gray-200">
                        <input 
                            type="number" 
                            min="0" 
                            name="grade[${student.student_id}][${key}]"
                            value="" 
                            placeholder="Pts"
                            data-grade-key="${key}"
                            data-student-no="${student.student_id}"
                            onchange="updateCalculatedGrades(this, '${student.student_id}')"
                            class="w-12 h-6 text-xs text-center border border-gray-300 rounded focus:ring-ra-primary focus:border-ra-primary"
                        >
                    </td>`;
            }

            // ACTIVITIES
            for (let i = 1; i <= term.activities; i++) {
                const key = `${term.prefix}_activity_${i}`;
                html += `
                    <td class="p-1 text-center border-r border-gray-200">
                        <input 
                            type="number" 
                            min="0" 
                            name="grade[${student.student_id}][${key}]"
                            value="" 
                            placeholder="Pts"
                            data-grade-key="${key}"
                            data-student-no="${student.student_id}"
                            onchange="updateCalculatedGrades(this, '${student.student_id}')"
                            class="w-12 h-6 text-xs text-center border border-gray-300 rounded focus:ring-ra-primary focus:border-ra-primary"
                        >
                    </td>`;
            }

            // EXAM
            const examKey = `${term.prefix}_exam`;
            html += `
                <td class="p-1 text-center border-r border-gray-200">
                    <input 
                        type="number" 
                        min="0" 
                        name="grade[${student.student_id}][${examKey}]"
                        value="" 
                        placeholder="Pts"
                        data-grade-key="${examKey}"
                        data-student-no="${student.student_id}"
                        onchange="updateCalculatedGrades(this, '${student.student_id}')"
                        class="w-12 h-6 text-xs text-center border border-gray-300 rounded focus:ring-ra-primary focus:border-ra-primary"
                    >
                </td>`;

            // TERM GRADE
            html += `
                <td class="px-3 py-2 text-center text-sm font-bold ${term.bgClass} bg-opacity-20 border-r border-gray-200"
                    id="${term.prefix}-grade-${student.student_id}">
                    0.00
                </td>`;
        });

        // FINAL GRADE
        html += `
            <td class="px-3 py-2 text-center text-sm font-extrabold text-gray-900 border-l border-gray-200"
                id="final-grade-${student.student_id}">
                0.00
            </td>`;

        html += `</tr>`;
    });

    return html;
}
