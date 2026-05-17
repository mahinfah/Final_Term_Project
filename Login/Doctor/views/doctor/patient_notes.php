<?php
$patient_history = [];
$searched = false;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
    $patient_id = (int)$_GET['patient_id'];
    $patient_history = $consultNoteModel->getByPatient($doctor_data['id'], $patient_id);
    $searched = true;
}
?>
<h2>Patient Consultation History</h2>
<form method="get" action="">
    <label>Enter Patient ID:</label>
    <input type="number" name="patient_id" value="<?php echo isset($_GET['patient_id']) ? htmlspecialchars($_GET['patient_id']) : ''; ?>" required>
    <button type="submit">View History</button>
</form>
<?php if ($searched): ?>
    <?php if (count($patient_history) > 0): ?>
        <h3>Past Consultations</h3>
        <?php foreach ($patient_history as $note): ?>
            <div class="note-entry">
                <strong>Date of Visit: <?php echo date('F j, Y', strtotime($note['appointment_date'])); ?></strong><br>
                <strong>Symptoms:</strong> <?php echo nl2br(htmlspecialchars($note['symptoms'])); ?><br>
                <strong>Diagnosis:</strong> <?php echo nl2br(htmlspecialchars($note['diagnosis'])); ?><br>
                <strong>Prescription:</strong> <?php echo nl2br(htmlspecialchars($note['prescription'])); ?><br>
                <?php if ($note['follow_up_date']): ?>
                    <strong>Follow-up Date:</strong> <?php echo $note['follow_up_date']; ?><br>
                <?php endif; ?>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No consultation notes found for patient ID <?php echo (int)$_GET['patient_id']; ?>.</p>
    <?php endif; ?>
<?php endif; ?>