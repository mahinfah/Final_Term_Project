<!DOCTYPE html>
<html>
<head>
    <title>Patient Consultation History</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Past Consultation Notes</h2>
    <?php foreach($notes as $note): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <strong>Date:</strong> <?= $note['appointment_date'] ?> <?= $note['appointment_time'] ?><br>
            <strong>Symptoms:</strong> <?= nl2br(htmlspecialchars($note['symptoms'])) ?><br>
            <strong>Diagnosis:</strong> <?= nl2br(htmlspecialchars($note['diagnosis'])) ?><br>
            <strong>Prescription:</strong> <?= nl2br(htmlspecialchars($note['prescription'])) ?><br>
            <?php if($note['follow_up_date']): ?>
                <strong>Follow-up:</strong> <?= $note['follow_up_date'] ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <a href="index.php?action=today_schedule">Back</a>
</div>
</body>
</html>