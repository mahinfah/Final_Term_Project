<?php $error = $error ?? ""; ?>

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

        <button type="submit" name="login">Login</button>
        <?php if(isset($_GET['registered'])) echo "<p class='success'>Registered! Please login.</p>"; ?>
    </form>

    <div class="register-links">
        <p>New Patient? <a href="views/register.php">Register here</a></p>
        <!-- For other roles, accounts must be created by Admin -->
    </div>
</div>

</body>
</html>
