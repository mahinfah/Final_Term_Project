<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientModel->update($_SESSION['user_id'],
        $patient_data['date_of_birth'],
        $patient_data['blood_group'],
        $patient_data['gender'],
        $patient_data['address'],
        $patient_data['emergency_contact_name'],
        $patient_data['emergency_contact_phone'],
        $_POST['medical_history']
    );
    echo "<p class='success'>Medical history saved.</p>";
}

if(isset($_GET['view_notes'])) {
    $notes = $appointmentModel->getConsultationNotes($_GET['view_notes'], $patient_data['id']);
    if($notes) {
        echo "<h3>Consultation Notes</h3>";
        echo "<p><strong>Diagnosis:</strong> " . nl2br(htmlspecialchars($notes['diagnosis'])) . "</p>";
        echo "<p><strong>Prescription:</strong> " . nl2br(htmlspecialchars($notes['prescription'])) . "</p>";
        if($notes['follow_up_date']) echo "<p><strong>Follow-up:</strong> {$notes['follow_up_date']}</p>";
    } else {
        echo "<p>No notes found.</p>";
    }
    echo "<p><a href='?page=medical_history'>Back</a></p>";
    exit;
}
?>
<h2>Medical History</h2>
<form method="post">
    <textarea name="medical_history" rows="5"><?php echo htmlspecialchars($patient_data['medical_history_notes']); ?></textarea><br>
    <button type="submit">Save Notes</button>
</form>