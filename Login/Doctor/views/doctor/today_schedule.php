<!DOCTYPE html>
<html>
<head>
    <title>Today's Schedule</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function checkin(appointment_id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php?action=checkin_ajax", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    var res = JSON.parse(this.responseText);
                    if(res.success) location.reload();
                    else alert("Check-in failed");
                }
            }
            xhr.send("appointment_id=" + appointment_id);
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Today's Appointments</h2>
    <table border="1">
        <tr><th>Time</th><th>Patient</th><th>Reason</th><th>Status</th><th>Actions</th></tr>
        <?php foreach($appointments as $apt): ?>
        <tr>
            <td><?= $apt['appointment_time'] ?></td>
            <td><a href="index.php?action=patient_notes&patient_id=<?= $apt['patient_user_id'] ?>"><?= htmlspecialchars($apt['patient_name']) ?></a></td>
            <td><?= htmlspecialchars($apt['reason']) ?></td>
            <td><?= $apt['status'] ?></td>
            <td>
                <?php if($apt['status'] == 'pending'): ?>
                    <a href="index.php?action=confirm_appointment&id=<?= $apt['id'] ?>">Confirm</a> |
                    <a href="index.php?action=reject_appointment&id=<?= $apt['id'] ?>">Reject</a>
                <?php elseif($apt['status'] == 'confirmed'): ?>
                    <button onclick="checkin(<?= $apt['id'] ?>)">Check In (AJAX)</button>
                <?php elseif($apt['status'] == 'checked_in'): ?>
                    <a href="index.php?action=add_consultation&id=<?= $apt['id'] ?>">Complete & Add Notes</a>
                <?php endif; ?>
                <?php if($apt['status'] != 'cancelled' && $apt['status'] != 'completed' && $apt['status'] != 'checked_in'): ?>
                    <a href="index.php?action=no_show_appointment&id=<?= $apt['id'] ?>">No-Show</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>