<?php
if (isset($_GET['appointment_id'])) {
    $appointment_id = (int)$_GET['appointment_id'];
    
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("SELECT patient_id FROM appointments WHERE id = ? AND doctor_id = ?");
    $stmt->bind_param("ii", $appointment_id, $doctor_data['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        echo "<p class='error'>Invalid appointment.</p>";
        exit;
    }
    $patient_id = $res->fetch_assoc()['patient_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_notes'])) {
        $consultNoteModel->add(
            $appointment_id,
            $doctor_data['id'],
            $patient_id,
            $_POST['symptoms'],
            $_POST['diagnosis'],
            $_POST['prescription'],
            $_POST['follow_up_date']
        );
        $appointmentModel->updateStatus($appointment_id, 'completed', $doctor_data['id']);
        echo "<p class='success'>Consultation notes saved and appointment marked completed.</p>";
        
        echo '<p><a href="?page=today_schedule">Back to Today\'s Schedule</a></p>';
    } else {
        ?>
        <h2>Add Consultation Notes</h2>
        <form method="post">
            <label>Symptoms:</label><br>
            <textarea name="symptoms" rows="3" cols="50" required></textarea><br>
            <label>Diagnosis:</label><br>
            <textarea name="diagnosis" rows="3" cols="50" required></textarea><br>
            <label>Prescription:</label><br>
            <textarea name="prescription" rows="4" cols="50" required></textarea><br>
            <label>Follow-up Date (optional):</label> <input type="date" name="follow_up_date"><br><br>
            <button type="submit" name="save_notes">Save & Complete</button>
            <a href="?page=today_schedule">Cancel</a>
        </form>
        <?php
    }
} else {
    echo "<p>Please select an appointment from <a href='?page=today_schedule'>Today's Schedule</a> or <a href='?page=pending_requests'>Pending Requests</a> to add consultation notes.</p>";
}
?>