<?php
session_start();
require_once __DIR__ . '/models/User.php';


if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'patient':
            header('Location: controllers/PatientController.php');
            exit;
        case 'admin':
            header('Location: admin.php');
            exit;
        case 'doctor':
            header('Location: doctor.php');
            exit;
        case 'receptionist':
            header('Location: receptionist.php');
            exit;
        default:
            session_destroy();
            header('Location: index.php');
            exit;
    }
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

            switch ($role) {
                case 'patient':
                    header('Location: controllers/PatientController.php');
                    exit;
                case 'admin':
                    header('Location: admin.php');
                    exit;
                case 'doctor':
                    header('Location: doctor.php');
                    exit;
                case 'receptionist':
                    header('Location: receptionist.php');
                    exit;
                default:
                    $error = 'Invalid role selected.';
            }
        } else {
            $error = 'Invalid email, password, or role mismatch.';
        }
    }
}


include __DIR__ . '/views/login.php';
?>