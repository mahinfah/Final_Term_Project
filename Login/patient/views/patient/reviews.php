<?php
$pastApps = $appointmentModel->getPast($patient_data['id']);
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_review'])) {
        $reviewModel->add($_POST['appointment_id'], $patient_data['id'], $_POST['doctor_id'], $_POST['rating'], $_POST['review_text']);
    }
    if(isset($_POST['update_review'])) {
        $reviewModel->update($_POST['review_id'], $_POST['rating'], $_POST['review_text']);
    }
    if(isset($_POST['delete_review'])) {
        $reviewModel->delete($_POST['review_id'], $patient_data['id']);
    }
    header("Location: ?page=reviews");
    exit;
}
?>
<h2>My Reviews</h2>
<?php foreach($pastApps as $app): 
    $existing = $reviewModel->getByAppointment($app['id'], $patient_data['id']);
?>
<div>
    <strong>Dr. <?php echo htmlspecialchars($app['doctor_name']); ?></strong> (<?php echo $app['appointment_date']; ?>)<br>
    <?php if($existing): ?>
        Current rating: ★ <?php echo $existing['rating']; ?><br>
        Review: <?php echo htmlspecialchars($existing['review_text']); ?><br>
        <form method="post" style="display:inline-block;">
            <input type="hidden" name="review_id" value="<?php echo $existing['id']; ?>">
            <input type="number" name="rating" min="1" max="5" value="<?php echo $existing['rating']; ?>" required>
            <textarea name="review_text"><?php echo htmlspecialchars($existing['review_text']); ?></textarea>
            <button type="submit" name="update_review">Update</button>
            <button type="submit" name="delete_review" onclick="return confirm('Delete this review?')">Delete</button>
        </form>
    <?php else: ?>
        <form method="post">
            <input type="hidden" name="appointment_id" value="<?php echo $app['id']; ?>">
            <input type="hidden" name="doctor_id" value="<?php echo $app['doctor_db_id']; ?>">
            <input type="number" name="rating" placeholder="Rating 1-5" required>
            <textarea name="review_text" placeholder="Your review"></textarea>
            <button type="submit" name="add_review">Add Review</button>
        </form>
    <?php endif; ?>
</div><hr>
<?php endforeach; ?>