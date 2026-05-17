<?php
$availability = $doctorModel->getAvailability($doctor_data['id']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_availability'])) {
    foreach ($availability as $av) {
        $day = $av['day_of_week'];
        $start = $POST['start_time' . $day] ?? '09:00';
        $end = $POST['end_time' . $day] ?? '17:00';
        $duration = (int)($POST['duration' . $day] ?? 30);
        $is_available = isset($POST['available' . $day]) ? 1 : 0;
        $doctorModel->updateAvailability($doctor_data['id'], $day, $start, $end, $duration, $is_available);
    }
    echo '<p class="success">Availability saved.</p>';
    // Refresh
    $availability = $doctorModel->getAvailability($doctor_data['id']);
}
?>
<h2>Weekly Availability</h2>
<form method="post">
    <table class="table">
        <thead>
            <tr><th>Day</th><th>Start Time</th><th>End Time</th><th>Slot (min)</th><th>Available</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php foreach ($availability as $av): ?>
                <tr>
                    <td><?php echo $av['day_of_week']; ?></td>
                    <td><input type="time" name="start_time_<?php echo $av['day_of_week']; ?>" value="<?php echo substr($av['start_time'], 0, 5); ?>"></td>
                    <td><input type="time" name="end_time_<?php echo $av['day_of_week']; ?>" value="<?php echo substr($av['end_time'], 0, 5); ?>"></td>
                    <td><input type="number" name="duration_<?php echo $av['day_of_week']; ?>" value="<?php echo $av['slot_duration_minutes']; ?>" min="15" step="15"></td>
                    <td><input type="checkbox" name="available_<?php echo $av['day_of_week']; ?>" <?php echo $av['is_available'] ? 'checked' : ''; ?>></td>
                    <td>—</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" name="save_availability">Save All</button>
</form>