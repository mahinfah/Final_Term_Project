<?php
$bills = $billingModel->getByPatient($patient_data['id']);
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay'])) {
    $billingModel->submitPaymentIntent($_POST['bill_id'], $patient_data['id'], $_POST['payment_method']);
    header("Location: ?page=billing");
    exit;
}
?>
<h2>Billing History</h2>
<table border="1" cellpadding="5">
    <thead>
        <tr><th>Date</th><th>Doctor</th><th>Amount</th><th>Status</th><th>Action</th></tr>
    </thead>
    <tbody>
    <?php foreach($bills as $b): ?>
        <tr>
            <td><?php echo $b['appointment_date']; ?></td>
            <td><?php echo htmlspecialchars($b['doctor_name']); ?></td>
            <td><?php echo $b['amount']; ?></td>
            <td><?php echo $b['payment_status']; ?></td>
            <td>
                <?php if($b['payment_status'] == 'pending'): ?>
                    <form method="post">
                        <input type="hidden" name="bill_id" value="<?php echo $b['id']; ?>">
                        <select name="payment_method">
                            <option>cash</option><option>card</option><option>online</option>
                        </select>
                        <button type="submit" name="pay">Pay</button>
                    </form>
                <?php else: ?>
                    Paid
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>