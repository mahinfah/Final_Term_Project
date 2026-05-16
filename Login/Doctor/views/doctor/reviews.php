<!DOCTYPE html>
<html>
<head><title>Reviews</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<div class="container">
    <h2>Patient Reviews</h2>
    <?php foreach($reviews as $rev): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <strong><?= htmlspecialchars($rev['patient_name']) ?></strong> - Rating: <?= $rev['rating'] ?>/5<br>
        <?= nl2br(htmlspecialchars($rev['review_text'])) ?>
        <?php if($rev['reply']): ?>
            <div style="background:#eee; margin-top:10px;"><strong>Your reply:</strong> <?= nl2br(htmlspecialchars($rev['reply'])) ?></div>
        <?php else: ?>
            <form method="post" action="index.php?action=reply_review">
                <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                <textarea name="reply" rows="2" placeholder="Write a reply..."></textarea>
                <button type="submit">Send Reply</button>
            </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>