<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Follow-ups</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Follow-up Appointments</h2>
    <table border="1">
        <tr><th>Patient</th><th>Last Visit</th><th>Follow-up Date</th><th>Diagnosis</th></tr>
        <?php foreach($followups as $fu): ?>
        <tr>
            <td><?= htmlspecialchars($fu['patient_name']) ?></td>
            <td><?= $fu['last_visit'] ?></td>
            <td><?= $fu['follow_up_date'] ?></td>
            <td><?= htmlspecialchars($fu['diagnosis']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>