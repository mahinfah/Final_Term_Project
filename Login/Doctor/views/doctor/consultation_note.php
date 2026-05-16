<!DOCTYPE html>
<html>
<head><title>Add Consultation Notes</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<div class="container">
    <h2>Consultation Notes</h2>
    <p><strong>Patient:</strong> <?= htmlspecialchars($appointment['patient_name']) ?></p>
    <p><strong>Date/Time:</strong> <?= $appointment['appointment_date'] ?> <?= $appointment['appointment_time'] ?></p>
    <form method="post">
        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
        <label>Symptoms:</label><textarea name="symptoms" rows="3" required></textarea>
        <label>Diagnosis:</label><textarea name="diagnosis" rows="3" required></textarea>
        <label>Prescription:</label><textarea name="prescription" rows="3" required></textarea>
        <label>Follow-up Date (optional):</label><input type="date" name="follow_up_date">
        <button type="submit">Save & Complete</button>
    </form>
</div>
</body>
</html>