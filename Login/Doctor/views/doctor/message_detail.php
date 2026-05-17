<!DOCTYPE html>
<html>
<head>
    <title>Conversation</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Conversation</h2>
    <div style="height:300px; overflow-y:scroll; border:1px solid #ccc; padding:10px;">
        <?php foreach($messages as $msg): ?>
            <p><strong><?= ($msg['sender_id'] == $_SESSION['user_id']) ? 'You' : 'Patient' ?>:</strong> <?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <small><?= $msg['created_at'] ?></small><hr>
        <?php endforeach; ?>
    </div>
    <form method="post" action="index.php?action=send_message">
        <input type="hidden" name="receiver_id" value="<?= $_GET['patient_id'] ?>">
        <textarea name="message" rows="3" required></textarea>
        <button type="submit">Send</button>
    </form>
    <a href="index.php?action=messages">Back</a>
</div>
</body>
</html>