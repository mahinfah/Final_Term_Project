<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/bookAppointmentLoad.php';

$msgType = '';
$msgText = '';
if (!empty($message)) {
    $parts   = explode(':', $message, 2);
    $msgType = $parts[0];
    $msgText = isset($parts[1]) ? $parts[1] : '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
</head>
<body>

    <a href="receptionist_dashboard.php">← Back to Dashboard</a>
    <h1>Book Appointment</h1>
    <hr>

    <!-- Message -->
    <?php if (!empty($msgText)): ?>
        <?php if ($msgType === 'success'): ?>
            <p style="color: green;"><?php echo htmlspecialchars($msgText); ?></p>
        <?php else: ?>
            <p style="color: red;"><?php echo htmlspecialchars($msgText); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="">

        <p>
            <label>Patient ID:</label><br>
            <input type="number" 
                   name="patient_id" 
                   placeholder="Enter patient ID"
                   value="<?php echo isset($_POST['patient_id']) ? $_POST['patient_id'] : ''; ?>">
        </p>

        <p>
            <label>Select Doctor:</label><br>
            <select name="doctor_id">
                <option value="">-- Select Doctor --</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?php echo $doctor['id']; ?>"
                        <?php echo (isset($_POST['doctor_id']) && $_POST['doctor_id'] == $doctor['id']) ? 'selected' : ''; ?>>
                        Dr. <?php echo htmlspecialchars($doctor['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>Date:</label><br>
            <input type="date" 
                   name="date" 
                   min="<?php echo date('Y-m-d'); ?>"
                   value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
        </p>

        <p>
            <label>Time:</label><br>
            <input type="time" 
                   name="time"
                   value="<?php echo isset($_POST['time']) ? $_POST['time'] : ''; ?>">
        </p>

        <p>
            <label>Reason:</label><br>
            <textarea name="reason" 
                      rows="3" 
                      cols="30"
                      placeholder="Enter reason for visit"><?php echo isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : ''; ?></textarea>
        </p>

        <p>
            <button type="submit">Book Appointment</button>
        </p>

    </form>

</body>
</html>