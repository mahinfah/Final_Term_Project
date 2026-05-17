<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Patient Conversations</h2>
    <?php foreach($conversations as $conv): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <strong><?= htmlspecialchars($conv['patient_name']) ?></strong><br>
            Last message: <?= nl2br(htmlspecialchars($conv['last_message'])) ?><br>
            <a href="index.php?action=messages&patient_id=<?= $conv['patient_user_id'] ?>">View Conversation</a>
        </div>
    <?php endforeach; ?>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>