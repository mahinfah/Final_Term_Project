<?php
session_start();

// CORRECT PATHS based on your structure
require_once 'RECEPTIONIST/MODEL/db_connection.php';
require_once 'RECEPTIONIST/MODEL/db_manupulation.php';
require_once 'RECEPTIONIST/MODEL/db_close.php';

$_SESSION['msg'] = "";

$action = $_POST['action'] ?? '';

if ($action === "login") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($email) || empty($password) || empty($role)) {
        $_SESSION['msg'] = "Email, password, and role required";
        header("Location: index.php");
        exit;
    }

    $conn = conn_open();

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email='$email' AND password_hash='$password' AND role='$role'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $_SESSION['msg'] = "Login Successful";
            header("Location: RECEPTIONIST/VIEW/receptionist_dashboard.php");
            exit;
        } else {
            $_SESSION['msg'] = "Invalid login details";
        }

        conn_close($conn);
    } else {
        $_SESSION['msg'] = "Database connection failed";
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            width: 320px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: darkblue;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    
    <?php if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])): ?>
        <div class="error"><?php echo htmlspecialchars($_SESSION['msg']); ?></div>
        <?php $_SESSION['msg'] = ''; ?>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="action" value="login">
        
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
            <option value="receptionist">Receptionist</option>
        </select>

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>