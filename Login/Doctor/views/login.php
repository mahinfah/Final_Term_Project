<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Login - Hospital System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <h2>🏥 Hospital Portal Login</h2>
        <?php if (isset($error) && $error !== ''): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['registered'])): ?>
            <div class="success">Registration successful! Please login.</div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label>Select Role</label>
                <select name="role" required>
                    <option value="">-- Select --</option>
                    <option value="patient">Patient</option>
                    <option value="doctor">Doctor</option>
                    <option value="receptionist">Receptionist</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <p style="margin-top:15px;">New Patient? <a href="register.php">Register here</a></p>
        <p style="font-size:12px; color:#888;">Doctor demo: doctor@test.com / password</p>
    </div>
</div>
</body>
</html>