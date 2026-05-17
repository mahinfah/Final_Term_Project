<?php
$period = isset($_GET['period']) ? $_GET['period'] : 'day';
$earnings = $earningModel->getEarnings($doctor_data['id'], $period);
?>
<h2>Earnings Report</h2>
<form method="get" style="margin-bottom:20px;">
    <label>Period:</label>
    <select name="period" onchange="this.form.submit()">
        <option value="day" <?php echo $period === 'day' ? 'selected' : ''; ?>>Daily</option>
        <option value="week" <?php echo $period === 'week' ? 'selected' : ''; ?>>Weekly</option>
        <option value="month" <?php echo $period === 'month' ? 'selected' : ''; ?>>Monthly</option>
    </select>
</form>

<?php if (count($earnings) > 0): ?>
    <table class="table">
        <thead><tr><th>Date</th><th>Completed Appointments</th><th>Total Earnings (BDT)</th></tr></thead>
        <tbody>
            <?php foreach ($earnings as $row): ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['completed']; ?></td>
                    <td><?php echo number_format($row['total'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No completed appointments in this period.</p>
<?php endif; ?>