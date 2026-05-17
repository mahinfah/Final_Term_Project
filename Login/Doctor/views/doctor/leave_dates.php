<?php
$leaves = $doctorModel->getLeaveDates($doctor_data['id']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_leave'])) {
        $doctorModel->addLeaveDate($doctor_data['id'], $_POST['leave_date'], $_POST['reason']);
        echo '<p class="success">Leave date added.</p>';
    } elseif (isset($_POST['remove_leave'])) {
        $doctorModel->removeLeaveDate($_POST['leave_id'], $doctor_data['id']);
        echo '<p class="success">Leave removed.</p>';
    }
    // Refresh
    $leaves = $doctorModel->getLeaveDates($doctor_data['id']);
}
?>
<h2>Leave / Unavailable Dates</h2>
<form method="post">
    <label>Leave Date:</label> <input type="date" name="leave_date" required>
    <label>Reason (optional):</label> <input type="text" name="reason">
    <button type="submit" name="add_leave">Add Leave</button>
</form>
<h3>Current Leaves</h3>
<?php if (count($leaves) > 0): ?>
    <ul>
        <?php foreach ($leaves as $leave): ?>
            <li><?php echo $leave['leave_date']; ?> - <?php echo htmlspecialchars($leave['reason'] ?: 'No reason'); ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                    <button type="submit" name="remove_leave">Remove</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No leave dates set.</p>
<?php endif; ?>