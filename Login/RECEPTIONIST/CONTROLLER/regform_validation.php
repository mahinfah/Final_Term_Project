<?php
session_start();

require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_close.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name       = $_POST['name'] ?? '';
    $email      = $_POST['email'] ?? '';
    $password   = $_POST['password'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $role       = $_POST['role'] ?? 'receptionist';
    $is_active  = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
    $action     = $_POST['action'] ?? '';
    

    $profilePicPath = '';
    $_SESSION['msg'] = "";

  

if ($action === "login") {
    header("Location: ../../index.php");
    exit;
}

    if (empty($name) || empty($email) || empty($password) || empty($phone)) {

        $_SESSION['msg'] = "All fields are required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['msg'] = "Invalid email address";

    } elseif (strlen($password) < 6) {

        $_SESSION['msg'] = "Password must be at least 6 characters";

    } elseif (!preg_match('/^\d{7,15}$/', $phone)) {

        $_SESSION['msg'] = "Invalid phone number";

    } else {

        $conn = conn_open();

        if ($conn) {

            if ($action === "insert") {

                try {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $result = insert_on_DB(
                        $name,
                        $email,
                        $password_hash,
                        $phone,
                        $role,
                        $profilePicPath,
                        $is_active,
                        $conn
                    );

                    if ($result) {
                        $_SESSION['msg'] = "Registration Successful";
                    } else {
                        $_SESSION['msg'] = "Database insertion failed";
                    }

                } catch (mysqli_sql_exception $e) {
                    // Likely duplicate email or other SQL error
                    $_SESSION['msg'] = "Email already exists";
                }

            }
             
            else {

                $_SESSION['msg'] = "Invalid action";

            }

            conn_close($conn);

        } else {

            $_SESSION['msg'] = "Database connection failed";

        }
    }
 header("Location: ../VIEW/registration_rep.php");

    exit;
}
?>
