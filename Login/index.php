<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fixed credentials
    if ($username === "webtech" && $password === "1234") {

        $_SESSION["role"] = $role;
        $_SESSION["user"] = $username;

        // Role-based redirect
        switch ($role) {
            case "admin":
                header("Location: admin.php");
                exit();
            case "doctor":
                header("Location: doctor.php");
                exit();
            case "patient":
                header("Location: patient.php");
                exit();
            case "receptionist":
                header("Location: receptionist.php");
                exit();
            default:
                $error = "Please select a valid role.";
        }

    } else {
        $error = "Invalid username or password!";
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
            width: 300px;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        h2 { text-align: center; }

        .form-row { margin-bottom: 15px;
         }

        label { display: block; 
        font-weight: bold;
         margin-bottom: 5px; }

        input, select {
            width: 100%;
            padding: 8px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover { background: darkblue; }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .register-links {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Hospital Login</h2>

    <?php if ($error != "") echo "<div class='error'>$error</div>"; ?>

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
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-row">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="register-links">
        <p>Create Account:</p>
        <a href="register_admin.php">Admin</a> |
        <a href="register_doctor.php">Doctor</a> |
        <a href="register_patient.php">Patient</a> |
        <a href="register_receptionist.php">Receptionist</a>
    </div>
</div>

</body>
</html>