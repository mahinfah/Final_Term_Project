<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../../index.php");
    exit;
}

require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn    = conn_open();
$bill_id = $_GET['bill_id'] ?? '';
$bill    = getBillById($conn, $bill_id);
conn_close($conn);

if (!$bill) {
    echo "Bill not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <!-- Buttons hidden on print -->
    <div class="no-print">
        <a href="process_payment.php">← Back to Payments</a>
        &nbsp;&nbsp;
        <button onclick="window.print()">Print Receipt</button>
        <hr>
    </div>

    <!-- Receipt Content -->
    <h2 align="center">Hospital Payment Receipt</h2>
    <p align="center">Printed on: <?php echo date('d M Y, h:i A'); ?></p>

    <hr>

    <table cellpadding="6">
        <tr>
            <td><strong>Receipt No</strong></td>
            <td>#<?php echo $bill['id']; ?></td>
        </tr>
        <tr>
            <td><strong>Patient Name</strong></td>
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
    </table>

    <hr>

    <table cellpadding="6">
        <tr>
            <td><strong>Appointment Date</strong></td>
            <td><?php echo $bill['appointment_date']; ?></td>
        </tr>
        <tr>
            <td><strong>Appointment Time</strong></td>
            <td><?php echo date('h:i A', strtotime($bill['appointment_time'])); ?></td>
        </tr>
        <tr>
            <td><strong>Reason</strong></td>
            <td><?php echo htmlspecialchars($bill['reason']); ?></td>
        </tr>
    </table>

    <hr>

    <table cellpadding="6">
        <tr>
            <td><strong>Amount Paid</strong></td>
            <td>$<?php echo number_format($bill['amount'], 2); ?></td>
        </tr>
        <tr>
            <td><strong>Payment Method</strong></td>
            <td><?php echo ucfirst($bill['payment_method']); ?></td>
        </tr>
        <tr>
            <td><strong>Payment Status</strong></td>
            <td><?php echo ucfirst($bill['payment_status']); ?></td>
        </tr>
        <tr>
            <td><strong>Paid At</strong></td>
            <td><?php echo $bill['paid_at']; ?></td>
        </tr>
    </table>

    <hr>

    <p align="center">Thank you for your payment!</p>

</body>
</html>