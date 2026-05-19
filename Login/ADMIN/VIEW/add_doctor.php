<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../CONTROLLER/addDoctorLoad.php';

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
    <title>Add Doctor</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 50px;
    }
    h1 {
        color: #333;
    }
    form {
        background-color: #fff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 500px;
    }
    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
    input, select, textarea {
        width: 100%;
        padding: 20px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    button {
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #218838;
    }
   
</style>
<body>

    <a href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>Add New Doctor</h1>
    <hr>

    <!-- Message -->
    <?php if (!empty($msgText)): ?>
        <p style="color: <?php echo $msgType === 'success' ? 'green' : 'red'; ?>">
            <?php echo $msgText; ?>
        </p>
    <?php endif; ?>
<div type="container" class="container">


    <form method="POST" action="">

        <h3>Account Information</h3>

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

        <h3>Doctor Profile</h3>

        <p>
            <label>Specialization:</label><br>
            <select name="specialization_id">
                <option value="">-- Select Specialization --</option>
                <?php foreach ($specializations as $spec): ?>
                    <option value="<?php echo $spec['id']; ?>">
                        <?php echo $spec['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>License Number:</label><br>
            <input type="text" name="license_number" placeholder="Enter license number">
        </p>

        <p>
            <label>Experience Years:</label><br>
            <input type="number" name="experience_years" placeholder="Enter years of experience">
        </p>

        <p>
            <label>Consultation Fee:</label><br>
            <input type="number" name="consultation_fee" placeholder="Enter consultation fee">
        </p>

        <p>
            <label>Bio:</label><br>
            <textarea name="bio" rows="4" cols="30" placeholder="Enter doctor bio"></textarea>
        </p>

        <p>
            <button type="submit">Add Doctor</button>
        </p>

    </form>
</div>
</body>
</html>