<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/reviewsLoad.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Reviews</title>
</head>
<body>

    <a href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>Doctor Reviews and Ratings</h1>
    <hr>

    <?php if (empty($reviews)): ?>
        <p>No reviews found.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Doctor Name</th>
                <th>Patient Name</th>
                <th>Appointment ID</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date</th>
            </tr>
            <?php foreach ($reviews as $r): ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td>Dr. <?php echo $r['doctor_name']; ?></td>
                    <td><?php echo $r['patient_name']; ?></td>
                    <td><?php echo $r['appointment_id']; ?></td>
                    <td><?php echo $r['rating']; ?> / 5</td>
                    <td><?php echo $r['review_text']; ?></td>
                    <td><?php echo $r['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>