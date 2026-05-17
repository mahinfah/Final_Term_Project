<?php
$reviews = $reviewModel->getByDoctor($doctor_data['id']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_review'])) {
    $review_id = (int)$_POST['review_id'];
    $reply = trim($_POST['reply']);
    if (!empty($reply)) {
        $reviewModel->addReply($review_id, $reply);
        echo '<p class="success">Reply posted.</p>';
        // Refresh reviews
        $reviews = $reviewModel->getByDoctor($doctor_data['id']);
    }
}
?>
<h2>Patient Reviews</h2>
<?php if (count($reviews) > 0): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="review-item">
            <strong><?php echo htmlspecialchars($review['patient_name']); ?></strong> 
            <span class="rating">★ <?php echo $review['rating']; ?>/5</span><br>
            <em><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></em><br>
            <small>Posted: <?php echo date('F j, Y', strtotime($review['created_at'])); ?></small><br>
            <?php if ($review['reply']): ?>
                <div class="doctor-reply">
                    <strong>Your reply:</strong> <?php echo nl2br(htmlspecialchars($review['reply'])); ?>
                </div>
            <?php else: ?>
                <form method="post" style="margin-top:10px;">
                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                    <textarea name="reply" rows="2" cols="50" placeholder="Write your reply..."></textarea><br>
                    <button type="submit" name="reply_review">Reply</button>
                </form>
            <?php endif; ?>
            <hr>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No reviews yet.</p>
<?php endif; ?>
<style>
.rating { color: gold; font-weight: bold; }
.doctor-reply { background: #f0f0f0; padding: 8px; margin-top: 5px; border-left: 3px solid #007bff; }
</style>