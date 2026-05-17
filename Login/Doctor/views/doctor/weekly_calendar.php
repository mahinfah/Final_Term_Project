<!DOCTYPE html>
<html>
<head>
    <title>Weekly Calendar</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Next 7 Days Appointments</h2>
    <table border="1">
        <tr><th>Date</th><th>Time</th><th>Patient</th><th>Reason</th><th>Status</th></tr>
        <?php foreach($appointments as $apt): ?>
        <tr>
            <td><?= $apt['appointment_date'] ?></td>
            <td><?= $apt['appointment_time'] ?></td>
            <td><?= htmlspecialchars($apt['patient_name']) ?></td>
            <td><?= htmlspecialchars($apt['reason']) ?></td>
            <td><?= $apt['status'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>