<?php
require_once 'models/User.php';
require_once 'models/Patient.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $blood_group = $_POST['blood_group'];
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $emergency_name = trim($_POST['emergency_name']);
    $emergency_phone = trim($_POST['emergency_phone']);
    $medical_history = trim($_POST['medical_history']);

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $error = "Name, Email, Password and Phone are required.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $user = new User();
        $user_id = $user->register($name, $email, $password, $phone);
        if ($user_id) {
            $patient = new Patient();
            $patient->create($user_id, $dob, $blood_group, $gender, $address, $emergency_name, $emergency_phone, $medical_history);
            header("Location: index.php?registered=1");
            exit;
        } else {
            $error = "Registration failed. Email may already exist.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 30px; }
        .register-box {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        h2 { text-align: center; }
        .form-row { margin-bottom: 12px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #218838; }
        .error {
            color: red;
            background: #ffe6e6;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 3px;
            text-align: center;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="register-box">
    <h2>Patient Registration</h2>
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-row">
            <label>Full Name *</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-row">
            <label>Email *</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-row">
            <label>Password (min 6 characters) *</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-row">
            <label>Phone *</label>
            <input type="text" name="phone" required>
        </div>
        <div class="form-row">
            <label>Date of Birth</label>
            <input type="date" name="dob">
        </div>
        <div class="form-row">
            <label>Blood Group</label>
            <select name="blood_group">
                <option value="">-- Select --</option>
                <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                <option>O+</option><option>O-</option><option>AB+</option><option>AB-</option>
            </select>
        </div>
        <div class="form-row">
            <label>Gender</label>
            <select name="gender">
                <option value="">-- Select --</option>
                <option>Male</option><option>Female</option><option>Other</option>
            </select>
        </div>
        <div class="form-row">
            <label>Address</label>
            <textarea name="address" rows="2"></textarea>
        </div>
        <div class="form-row">
            <label>Emergency Contact Name</label>
            <input type="text" name="emergency_name">
        </div>
        <div class="form-row">
            <label>Emergency Contact Phone</label>
            <input type="text" name="emergency_phone">
        </div>
        <div class="form-row">
            <label>Medical History Notes</label>
            <textarea name="medical_history" rows="3"></textarea>
        </div>
        <button type="submit">Register</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="index.php">Login here</a>
    </div>
</div>
</body>
</html>