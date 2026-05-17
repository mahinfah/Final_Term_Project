<!DOCTYPE html>
<html>
<head>
    <title>Leave Dates</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Mark Unavailable Dates</h2>
    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <form method="post">
        <input type="date" name="leave_date" required>
        <input type="text" name="reason" placeholder="Reason" required>
        <button type="submit" name="add_leave">Add Leave</button>
    </form>
    <h3>Existing Leave Dates</h3>
    <table border="1">
        <tr><th>Date</th><th>Reason</th><th>Action</th></tr>
        <?php foreach($leaves as $leave): ?>
        <tr>
            <td><?= $leave['leave_date'] ?></td>
            <td><?= htmlspecialchars($leave['reason']) ?></td>
            <td><a href="?action=leave_dates&delete=<?= $leave['id'] ?>" onclick="return confirm('Delete?')">Remove</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>