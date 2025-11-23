<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Excel Grade Sheet Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { font-size: 1.0rem; }
        .form-label { font-size: 1.0rem; font-weight: bold; margin-top: 5px; }
        .form-control { font-size: 1.0rem; padding: 0.4rem 0.6rem; }
        .btn-lg { font-size: 1.1rem; padding: 0.75rem 1.25rem; }
        .section-header { padding: 8px; margin-top: 15px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; color: #343a40; }
        .card-sm { padding: 10px; }
        .input-group-sm > .form-control, .form-control-sm { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
    </style>
</head>
<body class="bg-light text-dark">
    <div class="container py-4" style="max-width: 700px;">
        <h2 class="text-center mb-4 pb-2 border-bottom">STI grading sheet tool</h2>

        <form method="POST" action="">
            <div class="section-header mb-3 rounded-top">
                <h5 class="mb-0 fw-bold">Midterm Period Configuration</h5>
            </div>
            <div class="p-3 border rounded-bottom mb-4 bg-white shadow-sm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Number of Midterm Quizzes:</label>
                        <input type="number" name="midterm_quizzes" min="0" value="3" required class="form-control text-center">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Number of Midterm Activities:</label>
                        <input type="number" name="midterm_activities" min="0" value="2" required class="form-control text-center">
                    </div>
                </div>
            </div>

            <div class="section-header mb-3 rounded-top">
                <h5 class="mb-0 fw-bold">Finals Period Configuration</h5>
            </div>
            <div class="p-3 border rounded-bottom mb-4 bg-white shadow-sm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Number of Finals Quizzes:</label>
                        <input type="number" name="finals_quizzes" min="0" value="3" required class="form-control text-center">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Number of Finals Activities:</label>
                        <input type="number" name="finals_activities" min="0" value="2" required class="form-control text-center">
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label">Number of Students:</label>
                <input type="number" name="students_count" min="1" value="5" required class="form-control form-control-lg text-center bg-info bg-opacity-10">
            </div>

            <div class="mb-3">
                <label for="file_name" class="form-label">Excel File Name:</label>
                <input type="text" id="file_name" name="file_name" value="GradeSheet" required class="form-control">
            </div>

            <input type="submit" name="generate_table" value="Step 2: Generate Student Input Table" class="btn btn-outline-primary btn-lg w-100">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['generate_table'])):
            $studentsCount = (int)$_POST['students_count'];
            $midtermQuizCount = (int)$_POST['midterm_quizzes'];
            $midtermActivityCount = (int)$_POST['midterm_activities'];
            $finalsQuizCount = (int)$_POST['finals_quizzes'];
            $finalsActivityCount = (int)$_POST['finals_activities'];
            $fileName = htmlspecialchars($_POST['file_name']);
        ?>

        <hr class="my-5">

        <h2 class="text-center mb-4">Step 2: Enter Student Grades</h2>
        <p class="text-muted text-center">You are entering data for <?php echo $studentsCount; ?> students.</p>
        
        <form method="POST" action="generate_excel.php">
            <input type="hidden" name="students_count" value="<?php echo $studentsCount;?>">
            <input type="hidden" name="midterm_quizzes" value="<?php echo $midtermQuizCount;?>">
            <input type="hidden" name="midterm_activities" value="<?php echo $midtermActivityCount;?>">
            <input type="hidden" name="finals_quizzes" value="<?php echo $finalsQuizCount;?>">
            <input type="hidden" name="finals_activities" value="<?php echo $finalsActivityCount;?>">
            <input type="hidden" name="file_name" value="<?php echo $fileName;?>">

            <?php for($s=1;$s<=$studentsCount;$s++): ?>
                <div class="card card-sm mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white fw-bold">Student #<?php echo $s; ?> Details</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Student ID:</label>
                                <input type="text" name="student_id[]" required class="form-control form-control-sm" placeholder="ID">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Student Name:</label>
                                <input type="text" name="student_name[]" required class="form-control form-control-sm" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="mb-4 p-2 border rounded bg-light">
                            <h6 class="pb-1 border-bottom border-dark text-primary">Midterm Scores</h6>
                            <label class="form-label mb-1">Quizzes:</label>
                            <div class="row g-1 mb-3">
                                <?php for($i=1;$i<=$midtermQuizCount;$i++): ?>
                                    <div class="col">
                                        <input type="number" name="midterm_quiz_<?php echo $i;?>[]" required class="form-control form-control-sm text-center" placeholder="Q<?php echo $i;?>">
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <label class="form-label mb-1">Activities:</label>
                            <div class="row g-1 mb-3">
                                <?php for($i=1;$i<=$midtermActivityCount;$i++): ?>
                                    <div class="col">
                                        <input type="number" name="midterm_activity_<?php echo $i;?>[]" required class="form-control form-control-sm text-center" placeholder="A<?php echo $i;?>">
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <div class="row g-1 mt-3 p-2 bg-warning bg-opacity-25 rounded">
                                <label class="form-label col-12 mb-1 fw-bold text-dark">Midterm Exam Score:</label>
                                <div class="col-12">
                                    <input type="number" name="midterm_exam[]" required class="form-control form-control-sm text-center">
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border rounded bg-light">
                            <h6 class="pb-1 border-bottom border-dark text-danger">Finals Scores</h6>
                            <label class="form-label mb-1">Quizzes:</label>
                            <div class="row g-1 mb-3">
                                <?php for($i=1;$i<=$finalsQuizCount;$i++): ?>
                                    <div class="col">
                                        <input type="number" name="finals_quiz_<?php echo $i;?>[]" required class="form-control form-control-sm text-center" placeholder="Q<?php echo $i;?>">
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <label class="form-label mb-1">Activities:</label>
                            <div class="row g-1 mb-3">
                                <?php for($i=1;$i<=$finalsActivityCount;$i++): ?>
                                    <div class="col">
                                        <input type="number" name="finals_activity_<?php echo $i;?>[]" required class="form-control form-control-sm text-center" placeholder="A<?php echo $i;?>">
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <div class="row g-1 mt-3 p-2 bg-danger bg-opacity-25 rounded">
                                <label class="form-label col-12 mb-1 fw-bold text-dark">Finals Exam Score:</label>
                                <div class="col-12">
                                    <input type="number" name="finals_exam[]" required class="form-control form-control-sm text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>

            <input type="submit" name="generate_excel" value="Step 3: Generate Excel File" class="btn btn-outline-success btn-lg w-100 mt-4">
        </form>

        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
