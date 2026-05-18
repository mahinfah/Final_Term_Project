<?php
session_start();

if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? '') !== 'receptionist') {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/registerPatientLoad.php';

$msgType = '';
$msgText = '';
if (!empty($message)) {
    $parts   = explode(':', $message, 2);
    $msgType = $parts[0];
    $msgText = $parts[1];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Patient</title>
</head>
<body>

    <a href="receptionist_dashboard.php">← Back to Dashboard</a>
    <h1>Register New Patient</h1>
    <hr>

    <!-- Message -->
    <?php if (!empty($msgText)): ?>
        <p style="color: <?php echo $msgType === 'success' ? 'green' : 'red'; ?>">
            <?php echo $msgText; ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="">

        <h3>Basic Information</h3>

        <p>
            <label>Full Name:</label><br>
            <input type="text" name="name" placeholder="Enter full name">
        </p>

        <p>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="Enter email">
        </p>

        <p>
            <label>Password:</label><br>
            <input type="password" name="password" placeholder="Enter password">
        </p>

        <p>
            <label>Phone:</label><br>
            <input type="text" name="phone" placeholder="Enter phone number">
        </p>

        <h3>Patient Details</h3>

        <p>
            <label>Date of Birth:</label><br>
            <input type="date" name="dob">
        </p>

        <p>
            <label>Blood Group:</label><br>
            <select name="blood_group">
                <option value="">-- Select Blood Group --</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </p>

        <p>
            <label>Gender:</label><br>
            <select name="gender">
                <option value="">-- Select Gender --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </p>

        <p>
            <label>Address:</label><br>
            <textarea name="address" rows="3" cols="30" placeholder="Enter address"></textarea>
        </p>

        <h3>Emergency Contact</h3>

        <p>
            <label>Emergency Contact Name:</label><br>
            <input type="text" name="emergency_name" placeholder="Enter emergency contact name">
        </p>

        <p>
            <label>Emergency Contact Phone:</label><br>
            <input type="text" name="emergency_phone" placeholder="Enter emergency contact phone">
        </p>

        <h3>Medical Information</h3>

        <p>
            <label>Medical History Notes:</label><br>
            <textarea name="medical_history" rows="4" cols="30" placeholder="Enter any medical history notes"></textarea>
        </p>

        <p>
            <button type="submit">Register Patient</button>
        </p>

    </form>

</body>
</html>
