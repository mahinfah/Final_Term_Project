<?php
session_start();
require_once 'models/User.php';

$error = "";

if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'patient') {
    header("Location: controllers/PatientController.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $email = $_POST["email"];      
    $password = $_POST["password"];

    $user = new User();
    $logged_in_user = $user->login($email, $password);

    if ($logged_in_user && $logged_in_user['role'] == $role && $logged_in_user['is_active'] == 1) {
        $_SESSION["user_id"] = $logged_in_user['id'];
        $_SESSION["role"] = $logged_in_user['role'];
        $_SESSION["username"] = $logged_in_user['name'];

        
        switch ($role) {
            case "admin":
                header("Location: admin.php");
                exit();
            case "doctor":
                header("Location: doctor.php");
                exit();
            case "patient":
                header("Location: controllers/PatientController.php");
                exit();
            case "receptionist":
                header("Location: receptionist.php");
                exit();
            default:
                $error = "Please select a valid role.";
        }
    } else {
        $error = "Invalid email/password or role mismatch!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 50px;
        }

        .login-box {
            background: white;
            width: 350px;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        h2 { text-align: center; }

        .form-row { margin-bottom: 15px; }

        label { display: block; font-weight: bold; margin-bottom: 5px; }

        input, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover { background: #0056b3; }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            background: #ffe6e6;
            padding: 5px;
            border-radius: 3px;
        }

        .register-links {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Hospital Login</h2>

    <?php if ($error != ""): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-row">
            <label>Select Role:</label>
            <select name="role" required>
                <option value="">-- Select --</option>
                <option value="admin">Admin</option>
                <option value="doctor">Doctor</option>
                <option value="patient">Patient</option>
                <option value="receptionist">Receptionist</option>
            </select>
        </div>

        <div class="form-row">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-row">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="register-links">
        <p>New Patient? <a href="register.php">Register here</a></p>
        <!-- For other roles, accounts must be created by Admin -->
    </div>
</div>

</body>
</html>