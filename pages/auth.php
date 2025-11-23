<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

if ($email === "admin@example.com" && $password === "1234" && $role === "admin") {
    header("Location: dashboard.php");
    exit;
} else {
    $_SESSION['login_error'] = "Invalid credentials. Please try again.";
    header("Location: login.php");
    exit;
}
?>