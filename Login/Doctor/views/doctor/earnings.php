<!DOCTYPE html>
<html>
<head>
    <title>Earnings Report</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Earnings Report</h2>
    <a href="?action=earnings&period=day">Daily</a> |
    <a href="?action=earnings&period=week">Weekly</a> |
    <a href="?action=earnings&period=month">Monthly</a>
    <table border="1">
        <tr><th>Period</th><th>Completed Appointments</th><th>Total Earned</th></tr>
        <?php foreach($earnings as $row): ?>
        <tr>
            <td><?= $row['label'] ?></td>
            <td><?= $row['completed'] ?></td>
            <td>$<?= number_format($row['total_earned'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>