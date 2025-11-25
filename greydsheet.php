<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Redemptio Academy Gradesheet</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white p-8">

<div class="max-w-4xl mx-auto py-4">

    <!-- Title -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold border-b border-black inline-block px-4 pb-1">Redemptio Academy</h2>
    </div>

    <!-- SUBJECT TABLE -->
    <div class="mb-10">
        <div class="flex justify-end mb-2">
            <button type="button" onclick="addSubjectRow()"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 text-sm rounded">
                Add Subject
            </button>
        </div>

        <table class="min-w-full divide-y divide-gray-200 border border-gray-400" id="subjectTable">
            <thead class="bg-gray-50">
                <tr>
                    <?php
                    $subjectHeaders = [
                        'ACADEMIC YEAR','TERM NO','COURSE CODE','SUBJECT','SECTION','NUMBER OF STUDENTS','VIEW GRADESHEET'
                    ];
                    foreach ($subjectHeaders as $header):
                    ?>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-300">
                            <?= $header ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </div>

    <!-- STUDENT GRADESHEET -->
    <div>
        <div class="flex justify-start mb-2">
            <button type="button" id="editGradesheetBtn"
                class="bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-1 px-3 text-sm rounded border border-gray-500">
                Edit Gradesheet
            </button>
        </div>

        <table class="min-w-full divide-y divide-gray-200 border border-gray-400" id="studentTable">
            <thead class="bg-gray-50">
                <tr>
                    <?php
                    $gradeHeaders = [
                        'STUDENT NUMBER', 'STUDENT NAME', 
                        'QUIZ', 'ACTIVITY1', 'EXAM', 'MIDTERM',
                        'QUIZ', 'ACTIVITY1', 'EXAM', 'FINALS',
                        'FINAL GRADE'
                    ];
                    foreach ($gradeHeaders as $header):
                    ?>
                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-300">
                            <?= $header ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php for ($i=0;$i<11;$i++): ?>
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-500 border-r border-gray-300"></td>
                    <?php endfor; ?>
                </tr>
            </tbody>
        </table>

        <!-- EXPORT EXCEL BUTTON -->
        <div class="flex justify-end mt-4">
            <button type="button"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 text-sm rounded shadow">
                Export as Excel
            </button>
        </div>
    </div>

</div>

<!-- MODAL FOR QUIZ/ACTIVITY INPUT -->
<div id="gradesheetModal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h3 class="text-lg font-bold mb-4 text-center">Adjust Quiz/Activity Count</h3>
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700">Midterm Quizzes</label>
            <input type="number" id="midtermQuizzes" min="1" value="1" class="border px-2 py-1 w-full text-xs">
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700">Midterm Activities</label>
            <input type="number" id="midtermActivities" min="1" value="1" class="border px-2 py-1 w-full text-xs">
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700">Finals Quizzes</label>
            <input type="number" id="finalsQuizzes" min="1" value="1" class="border px-2 py-1 w-full text-xs">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Finals Activities</label>
            <input type="number" id="finalsActivities" min="1" value="1" class="border px-2 py-1 w-full text-xs">
        </div>
        <div class="flex justify-center space-x-2">
            <button id="closeModal" class="bg-gray-300 hover:bg-gray-400 px-3 py-1 rounded text-sm">Cancel</button>
            <button id="saveModal" class="bg-blue-500 hover:bg-blue-700 px-3 py-1 rounded text-white text-sm">Save</button>
        </div>
    </div>
</div>


<script>
let midtermQuizzes = 1, midtermActivities = 1, finalsQuizzes = 1, finalsActivities = 1;

// Modal controls
const modal = document.getElementById("gradesheetModal");
const editBtn = document.getElementById("editGradesheetBtn");
const closeBtn = document.getElementById("closeModal");
const saveBtn = document.getElementById("saveModal");

editBtn.addEventListener("click", () => modal.classList.remove("hidden"));
closeBtn.addEventListener("click", () => modal.classList.add("hidden"));
saveBtn.addEventListener("click", () => {
    midtermQuizzes = parseInt(document.getElementById("midtermQuizzes").value) || 1;
    midtermActivities = parseInt(document.getElementById("midtermActivities").value) || 1;
    finalsQuizzes = parseInt(document.getElementById("finalsQuizzes").value) || 1;
    finalsActivities = parseInt(document.getElementById("finalsActivities").value) || 1;
    modal.classList.add("hidden");
});

// Add Subject + Auto Student Row
function addSubjectRow() {
    const subjectTable = document.querySelector("#subjectTable tbody");
    const row = `<tr>
        <td class="px-3 py-2 text-sm border-r border-gray-300 text-blue-700"><input type="text" name="new_subjects[][academic_year]" class="border px-2 py-1 text-xs w-full"></td>
        <td class="px-3 py-2 text-sm border-r border-gray-300"><input type="text" name="new_subjects[][term_no]" class="border px-2 py-1 text-xs w-full"></td>
        <td class="px-3 py-2 text-sm border-r border-gray-300"><input type="text" name="new_subjects[][course_code]" class="border px-2 py-1 text-xs w-full"></td>
        <td class="px-3 py-2 text-sm border-r border-gray-300"><input type="text" name="new_subjects[][subject]" class="border px-2 py-1 text-xs w-full"></td>
        <td class="px-3 py-2 text-sm border-r border-gray-300"><input type="text" name="new_subjects[][section]" class="border px-2 py-1 text-xs w-full"></td>
        <td class="px-3 py-2 text-sm border-r border-gray-300"><input type="number" name="new_subjects[][students]" class="border px-2 py-1 text-xs w-full"></td>
        <td class="px-3 py-2 text-right text-sm"><a href="#" class="text-blue-600 hover:text-blue-900">View</a></td>
    </tr>`;
    subjectTable.insertAdjacentHTML("beforeend", row);
    addEmptyStudentRow();
}

// Empty student row
function addEmptyStudentRow() {
    const studentTable = document.querySelector("#studentTable tbody");
    let row = `<tr>
        <td class="px-2 py-2 text-xs border-r border-gray-300"><input type="text" name="new_students[][student_number]" class="border px-1 py-1 text-xs w-full"></td>
        <td class="px-2 py-2 text-xs border-r border-gray-300"><input type="text" name="new_students[][student_name]" class="border px-1 py-1 text-xs w-full"></td>`;
    for (let i=0;i<9;i++){
        row+=`<td class="px-2 py-2 text-xs border-r border-gray-300"><input type="text" name="new_students[][col${i}]" class="border px-1 py-1 text-xs w-full"></td>`;
    }
    row+="</tr>";
    studentTable.insertAdjacentHTML("beforeend", row);
}

// Dynamic grade calculation
document.addEventListener("input", function(e){
    if(!e.target.closest("#studentTable")) return;
    const row = e.target.closest("tr");
    const inputs = row.querySelectorAll("input");

    // Midterm quizzes & activities
    let quiz1Total = 0;
    for(let i=0;i<midtermQuizzes;i++){ quiz1Total += parseFloat(inputs[2+i]?.value)||0; }
    let act1Total = 0;
    for(let i=0;i<midtermActivities;i++){ act1Total += parseFloat(inputs[2+midtermQuizzes+i]?.value)||0; }
    let exam1 = parseFloat(inputs[2+midtermQuizzes+midtermActivities]?.value)||0;
    const midterm = (quiz1Total/midtermQuizzes*0.3)+(act1Total/midtermActivities*0.2)+(exam1*0.5);

    // Finals quizzes & activities
    let quiz2Total = 0;
    for(let i=0;i<finalsQuizzes;i++){ quiz2Total += parseFloat(inputs[6+i]?.value)||0; }
    let act2Total = 0;
    for(let i=0;i<finalsActivities;i++){ act2Total += parseFloat(inputs[6+finalsQuizzes+i]?.value)||0; }
    let exam2 = parseFloat(inputs[6+finalsQuizzes+finalsActivities]?.value)||0;
    const finals = (quiz2Total/finalsQuizzes*0.3)+(act2Total/finalsActivities*0.2)+(exam2*0.5);

    // Assign values and color coding
    inputs[5].value = midterm?midterm.toFixed(2):"";
    inputs[9].value = finals?finals.toFixed(2):"";
    inputs[5].style.color = midterm>=75?"green":"red";
    inputs[9].style.color = finals>=75?"green":"red";

    if(midterm && finals){
        const finalGrade = (midterm+finals)/2;
        inputs[10].value = finalGrade.toFixed(2);
        inputs[10].style.color = finalGrade>=75?"green":"red";
    }else{
        inputs[10].value="";
        inputs[10].style.color="black";
    }
});
</script>

</body>
</html>
