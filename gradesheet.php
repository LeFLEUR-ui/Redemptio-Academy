<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redemptio Academy</title>
    
    <meta name="application-name" content="Redemptio Academy Management System">
    <meta name="description" content="A dynamic frontend interface for academic subject and gradesheet management, featuring real-time updates and Bootstrap modals for user actions.">
    <meta name="keywords" content="Gradesheet, Subject Management, Dynamic Table, JavaScript, Bootstrap 5, CRUD, Grade Calculation">
    <meta name="author" content="Fabricante, Marvin Russel Y. - BSCS501">

    <meta name="feature-1" content="Dynamic Gradesheet: Allows adjustment of Quiz/Activity columns.">
    <meta name="feature-2" content="Weighted Grade Calculation: Quiz (20%), Activity (30%), Exam (50%) with 50/50 period split.">
    <meta name="feature-3" content="Subject Table Management: Includes real-time row deletion.">
    <meta name="feature-4" content="Subject Edit Logic: Populates and updates table rows via modal.">
    <meta name="feature-5" content="Confirmation Modals: Custom Bootstrap modals used for Delete and Update actions.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container-fluid px-5 py-5">
        <?php include_once 'partials/tables/subjectTable.php';?>
        <?php include_once 'partials/tables/gradesheetTable.php';?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>