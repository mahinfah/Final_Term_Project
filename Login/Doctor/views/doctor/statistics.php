<!DOCTYPE html>
<html>
<head>
    <title>Appointment Statistics</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Statistics</h2>
    <p>Completed: <?= $totals['completed'] ?></p>
    <p>Cancelled: <?= $totals['cancelled'] ?></p>
    <p>No-Show: <?= $totals['noshow'] ?> (<?= $noshow_rate ?>%)</p>
    <h3>Busiest Days</h3>
    <ul>
        <?php foreach($busy_days as $day): ?>
            <li><?= $day['day'] ?>: <?= $day['cnt'] ?> appointments</li>
        <?php endforeach; ?>
    </ul>
    <h3>Busiest Times</h3>
    <ul>
        <?php foreach($busy_times as $time): ?>
            <li><?= $time['hour'] ?>:00 - <?= $time['hour']+1 ?>:00 → <?= $time['cnt'] ?> appointments</li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>