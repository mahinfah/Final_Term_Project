<!DOCTYPE html>
<html>
<head>
    <title>Weekly Availability</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Set Weekly Availability</h2>
    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <form method="post">
        <table border="1">
            <tr><th>Day</th><th>Available?</th><th>Start Time</th><th>End Time</th><th>Slot Duration (min)</th></tr>
            <?php
            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            foreach($days as $day):
                $row = $avail[$day] ?? null;
            ?>
            <tr>
                <td><?= $day ?></td>
                <td><input type="checkbox" name="available_<?= $day ?>" <?= ($row && $row['is_available']) ? 'checked' : '' ?>></td>
                <td><input type="time" name="start_<?= $day ?>" value="<?= $row['start_time'] ?? '' ?>"></td>
                <td><input type="time" name="end_<?= $day ?>" value="<?= $row['end_time'] ?? '' ?>"></td>
                <td><input type="number" name="duration_<?= $day ?>" value="<?= $row['slot_duration_minutes'] ?? 30 ?>"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Save Availability</button>
    </form>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>