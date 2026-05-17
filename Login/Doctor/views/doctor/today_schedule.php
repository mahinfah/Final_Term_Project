<?php
$today_apps = $appointmentModel->getTodaySchedule($doctor_data['id']);
?>
<h2>Today's Schedule (<?php echo date('F j, Y'); ?>)</h2>
<?php if (count($today_apps) > 0): ?>
    <table class="table">
        <thead>
            <tr><th>Time</th><th>Patient</th><th>Reason</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($today_apps as $app): ?>
                <tr>
                    <td><?php echo date('h:i A', strtotime($app['appointment_time'])); ?></td>
                    <td><?php echo htmlspecialchars($app['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($app['reason']); ?></td>
                    <td><span class="status-<?php echo $app['status']; ?>"><?php echo ucfirst($app['status']); ?></span></td>
                    <td>
                        <?php if ($app['status'] === 'pending'): ?>
                            <a href="?page=pending_requests&action=confirm&id=<?php echo $app['id']; ?>">Confirm</a>
                        <?php elseif ($app['status'] === 'confirmed'): ?>
                            <button class="checkin-btn" data-id="<?php echo $app['id']; ?>">Check In</button>
                        <?php elseif ($app['status'] === 'checked_in'): ?>
                            <a href="?page=consultation_notes&appointment_id=<?php echo $app['id']; ?>">Add Notes</a>
                        <?php elseif ($app['status'] === 'completed'): ?>
                            Completed
                        <?php elseif ($app['status'] === 'cancelled'): ?>
                            Cancelled
                        <?php elseif ($app['status'] === 'no_show'): ?>
                            No-Show
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No appointments for today.</p>
<?php endif; ?>

<script>
document.querySelectorAll('.checkin-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        fetch('../controllers/AjaxController.php?action=check_in&id=' + id)
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
                else alert('Error checking in.');
            });
    });
});
</script>
<style>
.status-pending { color: orange; }
.status-confirmed { color: green; }
.status-checked_in { color: blue; }
.status-completed { color: darkgreen; }
.status-cancelled { color: red; }
.status-no_show { color: gray; }
</style>