<?php
// Start session (needed for error messages)
session_start();

// Optional: Read login error from redirect
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : "";
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to The Grading System</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <style>
        body.dark .card {
        background-color: #2d3748 !important; /* dark gray */
        color: #f7fafc !important;
        }
        body.dark .card label,
        body.dark .card p,
        body.dark .card h2,
        body.dark .card h3,
        body.dark .form-check-label {
        color: #f7fafc !important;
        }

        body.dark select.form-select {
        background-color: #2d3748;
        color: #f7fafc;
        border-color: #4a5568;
        }
        body.dark .form-check-input {
        border-color: #cbd5e0;
        }
        body, .card, input, select, textarea, label, p, h1, h2, h3, h4, h5, h6 {
        transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }
        body {
        transition: background 0.6s ease;
        }
        :root {
        --primary: #4f46e5;
        --secondary: #10b981;
        }
        body {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        body.dark {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        color: #f7fafc;
        }
        ::placeholder {
        color: #6c757d;
        opacity: 1;
        }
        body.dark ::placeholder {
        color: #cbd5e0;
        opacity: 1;
        }
        body.dark input, body.dark select, body.dark textarea {
        color: #f7fafc;
        background-color: #2d3748;
        border-color: #4a5568;
        }
        body.dark input:focus,
         body.dark select:focus {
        background-color: #2d3748;
        color: #fff;
        border-color: var(--primary);
        }
    </style>
</head>

<body class="d-flex align-items-center" style="min-height: 100vh;">

  <div class="container d-flex flex-column justify-content-center py-4 px-3 px-sm-4 px-md-5" style="max-width: 600px;">

    <div class="text-center mb-5">
      <h2 class="mt-3 mb-2 fw-bold">Redemptio Academy</h2>
      <p class="text-muted">Access grading system online</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <div class="card shadow-sm">
      <div class="card-body p-4 p-sm-5">

        <form action="auth.php" method="POST" id="loginForm">

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Login as</label>
            <select class="form-select" id="role" name="role" required>
              <option value="">Select your role</option>
              <option value="admin">Administrator</option>
              <option value="professor">Professor</option>
            </select>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me">
              <label class="form-check-label" for="remember-me">Remember me</label>
            </div>
            <a href="#" class="text-primary text-decoration-none">Forgot password?</a>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2">Sign in</button>
        </form>

      </div>
    </div>
  </div>

  <!-- Dark Mode Toggle Button -->
  <button id="darkModeToggle" class="btn btn-secondary position-fixed top-0 end-0 m-3 rounded-circle">
    <i class="bi bi-moon" id="darkModeIcon"></i>
  </button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>

  <script>
    // Dark mode toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon = document.getElementById('darkModeIcon');
    const body = document.body;

    if (localStorage.getItem('darkMode') === 'true' ||
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      body.classList.add('dark');
      darkModeIcon.classList.replace('bi-moon', 'bi-sun');
    }

    darkModeToggle.addEventListener('click', () => {
      body.classList.toggle('dark');
      localStorage.setItem('darkMode', body.classList.contains('dark'));

      if (body.classList.contains('dark')) {
        darkModeIcon.classList.replace('bi-moon', 'bi-sun');
      } else {
        darkModeIcon.classList.replace('bi-sun', 'bi-moon');
      }
    });

    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const role = document.getElementById('role').value;

      if (!email || !password || !role) {
        e.preventDefault();
        alert('Please fill all fields');
      }
    });
  </script>
</body>
</html>
