<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn    = conn_open();
$message = '';
$bills   = [];
$bill    = null;

// ✅ Load all outstanding bills
$bills = getOutstandingBills($conn);

// ✅ View single bill
if (isset($_GET['bill_id']) && !empty($_GET['bill_id'])) {
    $bill = getBillById($conn, $_GET['bill_id']);
}

// ✅ Mark as paid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_id        = $_POST['bill_id'];
    $payment_method = $_POST['payment_method'];

    if (empty($payment_method)) {
        $message = "error:Please select a payment method";
    } else {
        $result = markBillAsPaid($conn, $bill_id, $payment_method);
        if ($result) {
            $message = "success:Payment processed successfully";
            // ✅ Refresh bills and redirect to receipt
            header("Location: payment_receipt.php?bill_id=" . $bill_id);
            exit;
        } else {
            $message = "error:Something went wrong";
        }
    }
}

$bills = getOutstandingBills($conn);


conn_close($conn);