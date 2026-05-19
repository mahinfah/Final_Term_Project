<?php
$upcoming = $appointmentModel->getUpcoming($patient_data['id']);
$past = $appointmentModel->getPast($patient_data['id']);

if(isset($_GET['cancel'])) {
    $appointmentModel->cancel($_GET['cancel'], $patient_data['id']);
    header("Location: ?page=appointments");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reschedule'])) {
    $appointmentModel->reschedule($_POST['appointment_id'], $patient_data['id'], $_POST['new_date'], $_POST['new_time']);
    echo "<p class='success'>Reschedule request sent.</p>";
}
?>
<h2>Upcoming Appointments</h2>
<?php foreach($upcoming as $a): ?>
<div>
    <strong>Dr. <?php echo htmlspecialchars($a['doctor_name']); ?></strong> -
    <?php echo $a['appointment_date']; ?> <?php echo date('h:i A', strtotime($a['appointment_time'])); ?>
    (Status: <?php echo $a['status']; ?>)<br>
    Reason: <?php echo htmlspecialchars($a['reason']); ?><br>
    <a href="?page=appointments&cancel=<?php echo $a['id']; ?>" onclick="return confirm('Cancel this appointment?')">Cancel</a>
    <form method="post" style="display:inline;">
        <input type="hidden" name="appointment_id" value="<?php echo $a['id']; ?>">
        <input type="date" name="new_date" required>
        <input type="time" name="new_time" required>
        <button type="submit" name="reschedule">Reschedule</button>
    </form>
</div><hr>
<?php endforeach; ?>

<h2>Past Appointments</h2>
<?php foreach($past as $a): ?>
<div>
    <strong>Dr. <?php echo htmlspecialchars($a['doctor_name']); ?></strong> -
    <?php echo $a['appointment_date']; ?> (<?php echo $a['status']; ?>)<br>
    <?php if($a['has_notes']): ?>
        <a href="?page=medical_history&view_notes=<?php echo $a['id']; ?>">View Consultation Notes</a>
    <?php endif; ?>
</div><hr>
<?php endforeach; ?>