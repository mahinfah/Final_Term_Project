<?php
$stats = $earningModel->getStats($doctor_data['id']);
?>
<h2>Appointment Statistics</h2>
<ul>
    <li>✅ Total Completed Appointments: <strong><?php echo $stats['completed']; ?></strong></li>
    <li>❌ Total Cancelled Appointments: <strong><?php echo $stats['cancelled']; ?></strong></li>
    <li>🚫 Total No-Show Appointments: <strong><?php echo $stats['no_show']; ?></strong></li>
    <li>📉 No-Show Rate: <strong><?php echo $stats['no_show_rate']; ?>%</strong></li>
    <li>📅 Busiest Day of Week: <strong><?php echo $stats['busiest_day']; ?></strong></li>
    <li>⏰ Busiest Hour: <strong><?php echo $stats['busiest_hour']; ?></strong></li>
</ul>