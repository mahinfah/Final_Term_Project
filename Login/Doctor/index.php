<?php
session_start();
require_once __DIR__ . '/models/User.php';


$script_name = $_SERVER['SCRIPT_NAME'];
$base_dir = dirname($script_name);  // e.g., /Final_Term_Project/Login/Doctor
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $base_dir;


if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'doctor') {
    header('Location: ' . $base_url . '/controllers/DoctorController.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($role) || empty($email) || empty($password)) {
        $error = 'Please fill all fields.';
    } else {
        $user = new User();
        $loggedInUser = $user->login($email, $password);

        if ($loggedInUser && $loggedInUser['role'] === $role && $loggedInUser['is_active'] == 1) {
            $_SESSION['user_id'] = $loggedInUser['id'];
            $_SESSION['role'] = $loggedInUser['role'];
            $_SESSION['username'] = $loggedInUser['name'];

            if ($role === 'doctor') {
                header('Location: ' . $base_url . '/controllers/DoctorController.php');
                exit;
            } else {
                $error = 'Invalid role selected.';
            }
        } else {
            $error = 'Invalid email, password, or role mismatch.';
        }
    }
}

include __DIR__ . '/views/login.php';
?>
