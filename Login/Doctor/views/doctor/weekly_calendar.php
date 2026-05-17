<?php
$weekly = $appointmentModel->getWeeklySchedule($doctor_data['id']);
// Group by date
$grouped = [];
foreach ($weekly as $app) {
    $grouped[$app['appointment_date']][] = $app;
}
?>
<h2>Weekly Schedule (Next 7 Days)</h2>
<?php if (count($grouped) > 0): ?>
    <?php foreach ($grouped as $date => $apps): ?>
        <h3><?php echo date('l, F j, Y', strtotime($date)); ?></h3>
        <table class="table">
            <thead><tr><th>Time</th><th>Patient</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($apps as $app): ?>
                    <tr>
                        <td><?php echo date('h:i A', strtotime($app['appointment_time'])); ?></td>
                        <td><?php echo htmlspecialchars($app['patient_name']); ?></td>
                        <td><?php echo ucfirst($app['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php else: ?>
    <p>No upcoming appointments in the next 7 days.</p>
<?php endif; ?>