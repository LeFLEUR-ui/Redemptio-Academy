<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

function createMergedCell($sheet, $colStart, $colEnd, $rowStart, $rowEnd, $text, $style) {
    $startCell = Coordinate::stringFromColumnIndex($colStart + 1) . $rowStart;
    $endCell = Coordinate::stringFromColumnIndex($colEnd + 1) . $rowEnd;
    $sheet->setCellValue($startCell, $text);
    if ($colStart != $colEnd || $rowStart != $rowEnd) {
        $sheet->mergeCells("{$startCell}:{$endCell}");
    }
    $sheet->getStyle("{$startCell}:{$endCell}")->applyFromArray($style);
}

function addColumns($sheet, $row, $startCol, $labels, $style) {
    $col = $startCol;
    foreach ($labels as $label) {
        $cell = Coordinate::stringFromColumnIndex($col + 1) . $row;
        $sheet->setCellValue($cell, $label);
        $sheet->getStyle($cell)->applyFromArray($style);
        $col++;
    }
    return $col;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_excel'])) {
    $fileName = $_POST['file_name'] ?? "GradeSheet";
    $studentsCount = (int)($_POST['students_count'] ?? 0);
    $midtermQuizCount = (int)($_POST['midterm_quizzes'] ?? 0);
    $midtermActivityCount = (int)($_POST['midterm_activities'] ?? 0);
    $finalsQuizCount = (int)($_POST['finals_quizzes'] ?? 0);
    $finalsActivityCount = (int)($_POST['finals_activities'] ?? 0);

    $students = [];
    $studentIDs = $_POST['student_id'] ?? [];
    $studentNames = $_POST['student_name'] ?? [];

    for ($i = 0; $i < $studentsCount; $i++) {
        $students[$i]['id'] = $studentIDs[$i] ?? '';
        $students[$i]['name'] = $studentNames[$i] ?? '';

        $students[$i]['midterm_quizzes'] = [];
        for ($q = 1; $q <= $midtermQuizCount; $q++) {
            $students[$i]['midterm_quizzes'][] = $_POST['midterm_quiz_'.$q][$i] ?? '';
        }
        $students[$i]['midterm_activities'] = [];
        for ($a = 1; $a <= $midtermActivityCount; $a++) {
            $students[$i]['midterm_activities'][] = $_POST['midterm_activity_'.$a][$i] ?? '';
        }
        $students[$i]['midterm_exam'] = $_POST['midterm_exam'][$i] ?? '';

        $students[$i]['finals_quizzes'] = [];
        for ($q = 1; $q <= $finalsQuizCount; $q++) {
            $students[$i]['finals_quizzes'][] = $_POST['finals_quiz_'.$q][$i] ?? '';
        }
        $students[$i]['finals_activities'] = [];
        for ($a = 1; $a <= $finalsActivityCount; $a++) {
            $students[$i]['finals_activities'][] = $_POST['finals_activity_'.$a][$i] ?? '';
        }
        $students[$i]['finals_exam'] = $_POST['finals_exam'][$i] ?? '';
    }

    // --- Spreadsheet Generation ---
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Grade Sheet');

    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
        ],
    ];

    createMergedCell($sheet, 0, 0, 1, 3, "Student ID", $headerStyle);
    createMergedCell($sheet, 1, 1, 1, 3, "Student Name", $headerStyle);

    $midtermStart = 2;
    $midtermEnd = $midtermStart + $midtermQuizCount + $midtermActivityCount + 2 - 1;
    createMergedCell($sheet, $midtermStart, $midtermEnd, 1, 1, "Midterm", $headerStyle);

    $finalsStart = $midtermEnd + 1;
    $finalsEnd = $finalsStart + $finalsQuizCount + $finalsActivityCount + 2 - 1;
    createMergedCell($sheet, $finalsStart, $finalsEnd, 1, 1, "Finals", $headerStyle);

    // Midterm headers
    $col = $midtermStart;
    if ($midtermQuizCount > 0) createMergedCell($sheet, $col, $col+$midtermQuizCount-1, 2, 2, "Quizzes", $headerStyle);
    $col += $midtermQuizCount;
    if ($midtermActivityCount > 0) createMergedCell($sheet, $col, $col+$midtermActivityCount-1, 2, 2, "Activities", $headerStyle);
    $col += $midtermActivityCount;
    createMergedCell($sheet, $col, $midtermEnd, 2, 2, "Exam", $headerStyle);

    // Finals headers
    $col = $finalsStart;
    if ($finalsQuizCount > 0) createMergedCell($sheet, $col, $col+$finalsQuizCount-1, 2, 2, "Quizzes", $headerStyle);
    $col += $finalsQuizCount;
    if ($finalsActivityCount > 0) createMergedCell($sheet, $col, $col+$finalsActivityCount-1, 2, 2, "Activities", $headerStyle);
    $col += $finalsActivityCount;
    createMergedCell($sheet, $col, $finalsEnd, 2, 2, "Exam", $headerStyle);

    // Row 3 subheaders
    $row3 = 3;
    $col = $midtermStart;
    addColumns($sheet, $row3, $col, array_map(fn($i)=>"Quiz #$i", range(1,$midtermQuizCount)), $headerStyle);
    $col += $midtermQuizCount;
    addColumns($sheet, $row3, $col, array_map(fn($i)=>"Activity #$i", range(1,$midtermActivityCount)), $headerStyle);
    $col += $midtermActivityCount;
    addColumns($sheet, $row3, $col, ["Exam","Computed Grade"], $headerStyle);

    $col = $finalsStart;
    addColumns($sheet, $row3, $col, array_map(fn($i)=>"Quiz #$i", range(1,$finalsQuizCount)), $headerStyle);
    $col += $finalsQuizCount;
    addColumns($sheet, $row3, $col, array_map(fn($i)=>"Activity #$i", range(1,$finalsActivityCount)), $headerStyle);
    $col += $finalsActivityCount;
    addColumns($sheet, $col, $col, ["Exam","Computed Grade"], $headerStyle);

    // Column widths
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(25);
    for ($c = 2; $c <= $finalsEnd; $c++) {
        $colChar = Coordinate::stringFromColumnIndex($c+1);
        $sheet->getColumnDimension($colChar)->setWidth(10);
    }

    // Fill data
    $startRow = 4;
    foreach($students as $i => $student) {
        $row = $startRow + $i;
        $sheet->setCellValue("A$row", $student['id']);
        $sheet->setCellValue("B$row", $student['name']);

        $col = 3;
        foreach($student['midterm_quizzes'] as $grade) { $sheet->setCellValueByColumnAndRow($col+1, $row, $grade); $col++; }
        foreach($student['midterm_activities'] as $grade) { $sheet->setCellValueByColumnAndRow($col+1, $row, $grade); $col++; }
        $sheet->setCellValueByColumnAndRow($col+1, $row, $student['midterm_exam']); $col++;
        $startColLetter = Coordinate::stringFromColumnIndex($midtermStart+1);
        $endColLetter = Coordinate::stringFromColumnIndex($col-1);
        $sheet->setCellValueByColumnAndRow($col+1, $row, "=AVERAGE($startColLetter$row:$endColLetter$row)"); $col++;

        foreach($student['finals_quizzes'] as $grade) { $sheet->setCellValueByColumnAndRow($col+1, $row, $grade); $col++; }
        foreach($student['finals_activities'] as $grade) { $sheet->setCellValueByColumnAndRow($col+1, $row, $grade); $col++; }
        $sheet->setCellValueByColumnAndRow($col+1, $row, $student['finals_exam']); $col++;
        $startColLetter = Coordinate::stringFromColumnIndex($finalsStart+1);
        $endColLetter = Coordinate::stringFromColumnIndex($col-1);
        $sheet->setCellValueByColumnAndRow($col+1, $row, "=AVERAGE($startColLetter$row:$endColLetter$row)");
    }

    $filename = $fileName . "_" . time() . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}