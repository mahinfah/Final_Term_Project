<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/totalRevenueLoad.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Total Revenue</title>
</head>
<body>

    <a href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>Total Revenue</h1>
    <hr>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Total Revenue Collected</th>
        </tr>
        <tr>
            <td align="center">
                <h2>$<?php echo number_format($totalRevenue, 2); ?></h2>
            </td>
        </tr>
    </table>

</body>
</html>