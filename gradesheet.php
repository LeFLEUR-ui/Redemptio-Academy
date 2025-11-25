<?php
// Default values
$midtermQuizzes = $_POST['midterm_quizzes'] ?? 2;
$midtermActivities = $_POST['midterm_activities'] ?? 1;
$finalsQuizzes = $_POST['finals_quizzes'] ?? 2;
$finalsActivities = $_POST['finals_activities'] ?? 1;
$numStudents = $_POST['num_students'] ?? 5;

$fileName = $_POST['file_name'] ?? "GradeSheet_WebProg";

// Prepare student data
$students = [];
if (isset($_POST['students'])) {
    $students = $_POST['students']; // preserve input
} else {
    for ($i = 0; $i < $numStudents; $i++) {
        $students[$i] = [
            "student_id" => "S" . (1000 + ($i+1)),
            "student_name" => ($i==0 ? "Marvin Cruz" : "Student Name ".($i+1)),
            "scores" => []
        ];
    }
}

// Determine total score columns
$totalScoreColumns =
    $midtermQuizzes + $midtermActivities + 1 +
    $finalsQuizzes + $finalsActivities + 1;

// Ensure score arrays are correct length
foreach ($students as $i => $student) {
    for ($j = 0; $j < $totalScoreColumns; $j++) {
        if (!isset($students[$i]['scores'][$j])) {
            $students[$i]['scores'][$j] = 90;
        }
    }
}

// Generate headers
$headers = [];
for ($i=1; $i<= $midtermQuizzes; $i++) $headers[] = "Midterm Quiz $i";
for ($i=1; $i<= $midtermActivities; $i++) $headers[] = "Midterm Act $i";
$headers[] = "Midterm Exam";

for ($i=1; $i<= $finalsQuizzes; $i++) $headers[] = "Finals Quiz $i";
for ($i=1; $i<= $finalsActivities; $i++) $headers[] = "Finals Act $i";
$headers[] = "Finals Exam";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Excel Grade Sheet Generator (Pure PHP)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            margin: 0;
        }
        .score-input:focus {
            outline: 2px solid #34d399;
            border-color: #34d399;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-4xl mx-auto bg-white p-10 shadow-xl border-t-8 border-green-600 rounded-lg">

    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800">Dynamic Excel Grade Sheet Generator (Pure PHP)</h2>
        <p class="text-gray-500">Configure grade columns and enter scores for export.</p>
    </div>

    <!-- Re-render form -->
    <form method="POST" class="space-y-6">

        <!-- Configuration -->
        <div class="pb-4 border-b">
            <p class="text-xl font-bold text-green-700 mb-2">1. Configuration</p>
            <label class="block font-medium text-gray-700">Output File Name:</label>
            <input type="text" name="file_name" value="<?= htmlspecialchars($fileName) ?>"
                class="w-full border p-2 rounded-md shadow-sm">
        </div>

        <!-- Grading Components -->
        <div class="pb-4 border-b">
            <p class="text-xl font-bold text-green-700 mb-4">2. Grading Components</p>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2 border-r pr-4">
                    <p class="font-semibold">Midterm Period</p>
                    <label>Quizzes:</label>
                    <input type="number" name="midterm_quizzes" value="<?= $midtermQuizzes ?>" min="0"
                        class="w-full border p-2 rounded-md">
                    <label>Activities:</label>
                    <input type="number" name="midterm_activities" value="<?= $midtermActivities ?>" min="0"
                        class="w-full border p-2 rounded-md">
                </div>

                <div class="space-y-2">
                    <p class="font-semibold">Finals Period</p>
                    <label>Quizzes:</label>
                    <input type="number" name="finals_quizzes" value="<?= $finalsQuizzes ?>" min="0"
                        class="w-full border p-2 rounded-md">
                    <label>Activities:</label>
                    <input type="number" name="finals_activities" value="<?= $finalsActivities ?>" min="0"
                        class="w-full border p-2 rounded-md">
                </div>
            </div>
        </div>

        <!-- Student Count -->
        <div class="pb-4 border-b">
            <p class="text-xl font-bold text-green-700 mb-4">3. Student Roster Size</p>
            <label>Total Students:</label>
            <input type="number" name="num_students" value="<?= $numStudents ?>" min="1" max="100"
                class="w-full border p-2 rounded-md">
        </div>

        <!-- Apply settings button -->
        <div class="text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full shadow">
                Apply Settings
            </button>
        </div>

        <!-- Student Score Table -->
        <p class="text-xl font-bold text-green-700 mt-8">4. Enter Scores</p>

        <div class="overflow-x-auto border rounded-lg shadow-inner">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-100">
                    <tr>
                        <th class="px-2 py-2 text-center text-xs font-semibold">#</th>
                        <th class="px-2 py-2 text-xs font-semibold">Student ID</th>
                        <th class="px-2 py-2 text-xs font-semibold">Student Name</th>

                        <?php foreach ($headers as $h): ?>
                            <th class="px-2 py-2 text-xs font-semibold text-center"><?= $h ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">

                <?php foreach ($students as $i => $student): ?>
                    <tr>
                        <td class="px-2 py-1 text-center"><?= $i+1 ?></td>

                        <td class="px-2">
                            <input type="text" name="students[<?= $i ?>][student_id]"
                                value="<?= htmlspecialchars($student['student_id']) ?>"
                                class="w-full border p-1 text-xs text-center rounded-sm">
                        </td>

                        <td class="px-2">
                            <input type="text" name="students[<?= $i ?>][student_name]"
                                value="<?= htmlspecialchars($student['student_name']) ?>"
                                class="w-full border p-1 text-xs rounded-sm">
                        </td>

                        <?php foreach ($student['scores'] as $j => $score): ?>
                            <td class="px-2">
                                <input type="number"
                                    name="students[<?= $i ?>][scores][<?= $j ?>]"
                                    value="<?= $score ?>"
                                    min="0" max="100"
                                    class="w-full border p-1 text-xs text-center rounded-sm">
                            </td>
                        <?php endforeach; ?>

                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- Export Button -->
        <div class="text-center mt-8 pt-4">
            <button type="submit"
                formaction="export_excel.php"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg">
                Download Dynamic Grade Sheet (.xlsx)
            </button>
        </div>

    </form>
</div>

</body>
</html>
