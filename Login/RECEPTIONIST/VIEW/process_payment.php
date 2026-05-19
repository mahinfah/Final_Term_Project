<?php
session_start();

if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? '') !== 'receptionist') {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/paymentLoad.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Process Payment</title>
</head>
<body>

    <a href="receptionist_dashboard.php">← Back to Dashboard</a>
    <h1>Process Payment</h1>
    <hr>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <?php
            $parts   = explode(':', $message, 2);
            $msgType = $parts[0];
            $msgText = $parts[1];
        ?>
        <p style="color: <?php echo $msgType === 'success' ? 'green' : 'red'; ?>">
            <?php echo htmlspecialchars($msgText); ?>
        </p>
    <?php endif; ?>

    <!-- Outstanding Bills -->
    <h2>Outstanding Bills</h2>

    <?php if (empty($bills)): ?>
        <p>No outstanding bills found.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Bill ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            <?php foreach ($bills as $b): ?>
                <tr>
                    <td><?php echo $b['id']; ?></td>
                    <td><?php echo htmlspecialchars($b['patient_name']); ?></td>
                    <td><?php echo $b['appointment_date']; ?></td>
                    <td><?php echo htmlspecialchars($b['reason']); ?></td>
                    <td>$<?php echo number_format($b['amount'], 2); ?></td>
                    <td><a href="?bill_id=<?php echo $b['id']; ?>">Pay Now</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <hr>

    <!-- Pay Form -->
    <?php if ($bill): ?>
        <h2>Pay Bill #<?php echo $bill['id']; ?></h2>

        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <td><strong>Patient</strong></td>
                <td><?php echo htmlspecialchars($bill['patient_name']); ?></td>
            </tr>
            <tr>
                <td><strong>Phone</strong></td>
                <td><?php echo htmlspecialchars($bill['phone']); ?></td>
            </tr>
            <tr>
                <td><strong>Doctor</strong></td>
                <td>Dr. <?php echo htmlspecialchars($bill['doctor_name']); ?></td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td><?php echo $bill['appointment_date']; ?></td>
            </tr>
            <tr>
                <td><strong>Time</strong></td>
                <td><?php echo date('h:i A', strtotime($bill['appointment_time'])); ?></td>
            </tr>
            <tr>
                <td><strong>Reason</strong></td>
                <td><?php echo htmlspecialchars($bill['reason']); ?></td>
            </tr>
            <tr>
                <td><strong>Amount</strong></td>
                <td>$<?php echo number_format($bill['amount'], 2); ?></td>
            </tr>
        </table>

        <br>

        <form method="POST" action="">
            <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">

            <label>Payment Method:</label><br>
            <select name="payment_method">
                <option value="">-- Select Method --</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="online">Online</option>
            </select>

            <br><br>

            <button type="submit">Mark as Paid</button>
        </form>

    <?php endif; ?>

</body>
</html>
