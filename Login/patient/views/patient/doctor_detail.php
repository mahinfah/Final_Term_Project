<?php
$id = $_GET['id'];
$doctor = $doctorModel->getById($id);
if(!$doctor) { echo "<p>Doctor not found.</p>"; exit; }
$rating = $doctorModel->getAverageRating($id);
$reviews = $doctorModel->getReviews($id);
$db = new Database();
$conn = $db->getConnection();
?>
<h2>Dr. <?php echo htmlspecialchars($doctor['name']); ?></h2>

<?php if($doctor['photo_path']): ?>
    <img src="../<?php echo $doctor['photo_path']; ?>" width="100" style="float:right;">
<?php else: ?>
    <img src="../assets/default-doctor.png" width="100" style="float:right;">
<?php endif; ?>

<p><strong>Specialization:</strong> <?php echo $doctor['specialization_name']; ?></p>
<p><strong>Experience:</strong> <?php echo $doctor['experience_years']; ?> years</p>
<p><strong>Fee:</strong> <?php echo $doctor['consultation_fee']; ?> BDT</p>
<p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($doctor['bio'])); ?></p>

<?php
$avail_days = $conn->query("SELECT day_of_week, start_time, end_time FROM doctor_availability WHERE doctor_id = $id AND is_available = 1 ORDER BY FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')");
if($avail_days->num_rows > 0): ?>
    <p><strong>Available Days:</strong></p>
    <ul>
    <?php while($day = $avail_days->fetch_assoc()): ?>
        <li><?php echo $day['day_of_week']; ?>: <?php echo date('h:i A', strtotime($day['start_time'])); ?> - <?php echo date('h:i A', strtotime($day['end_time'])); ?></li>
    <?php endwhile; ?>
    </ul>
<?php endif; ?>

<p><strong>Average Rating:</strong> <?php echo round($rating['avg_rating'],1); ?> (<?php echo $rating['total']; ?> reviews)</p>
<a href="?page=book_appointment&doctor_id=<?php echo $id; ?>">Book Appointment</a>

<h3>Patient Reviews</h3>
<?php foreach($reviews as $r): ?>
<div>
    <strong><?php echo htmlspecialchars($r['patient_name']); ?></strong> ★ <?php echo $r['rating']; ?><br>
    <?php echo nl2br(htmlspecialchars($r['review_text'])); ?><br>
    <small><?php echo $r['created_at']; ?></small>
</div><hr>
<?php endforeach; ?>