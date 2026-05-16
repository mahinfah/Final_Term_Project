<!DOCTYPE html>
<html>
<head><title>Dashboard</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<div class="container">
    <h2>Doctor Dashboard</h2>
    <p>Welcome, Dr. <?= htmlspecialchars($_SESSION['user_id']) ?></p>
    <ul>
        <li><a href="index.php?action=profile">Manage Profile</a></li>
        <li><a href="index.php?action=availability">Weekly Availability</a></li>
        <li><a href="index.php?action=leave_dates">Leave Dates</a></li>
        <li><a href="index.php?action=today_schedule">Today's Schedule</a></li>
        <li><a href="index.php?action=weekly_calendar">Weekly Calendar</a></li>
        <li><a href="index.php?action=reviews">Patient Reviews</a></li>
        <li><a href="index.php?action=earnings">Earnings Report</a></li>
        <li><a href="index.php?action=statistics">Statistics</a></li>
        <li><a href="index.php?action=followups">Upcoming Follow-ups</a></li>
        <li><a href="index.php?action=messages">Messages</a></li>
    </ul>
    <p>Today: Pending <?= $pending ?> | Confirmed <?= $confirmed ?> | Total Completed <?= $completed ?></p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>