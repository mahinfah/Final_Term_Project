<?php
$pending = $appointmentModel->getPendingRequests($doctor_data['id']);

if (isset($_GET['action']) && isset($_GET['id'])) {
    $new_status = '';
    if ($_GET['action'] === 'confirm') $new_status = 'confirmed';
    elseif ($_GET['action'] === 'reject') $new_status = 'cancelled';
    elseif ($_GET['action'] === 'no_show') $new_status = 'no_show';
    if ($new_status) {
        $appointmentModel->updateStatus($_GET['id'], $new_status, $doctor_data['id']);
        header("Location: ?page=pending_requests");
        exit;
    }
}
?>
<h2>Pending Appointment Requests</h2>
<?php if (count($pending) > 0): ?>
    <table class="table">
        <thead><tr><th>Date</th><th>Time</th><th>Patient</th><th>Reason</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($pending as $req): ?>
                <tr>
                    <td><?php echo $req['appointment_date']; ?></td>
                    <td><?php echo date('h:i A', strtotime($req['appointment_time'])); ?></td>
                    <td><?php echo htmlspecialchars($req['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($req['reason']); ?></td>
                    <td>
                        <a href="?page=pending_requests&action=confirm&id=<?php echo $req['id']; ?>">Confirm</a> |
                        <a href="?page=pending_requests&action=reject&id=<?php echo $req['id']; ?>">Reject</a> |
                        <a href="?page=pending_requests&action=no_show&id=<?php echo $req['id']; ?>">No-Show</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No pending requests.</p>
<?php endif; ?>