<?php
$search = $_GET['search'] ?? '';
$spec = $_GET['specialization'] ?? '';
$min = $_GET['min_fee'] ?? '';
$max = $_GET['max_fee'] ?? '';
$filter_availability = isset($_GET['filter_availability']) && $_GET['filter_availability'] == 'on';
$availability_date = $_GET['availability_date'] ?? date('Y-m-d');

$doctors = $doctorModel->getAllApproved($search, $spec, $min, $max);

if($filter_availability) {
    $filtered = [];
    foreach($doctors as $d) {
        $slots = $appointmentModel->getAvailableSlots($d['id'], $availability_date);
        if(!empty($slots)) $filtered[] = $d;
    }
    $doctors = $filtered;
}
$specializations = $doctorModel->getSpecializations();
?>
<h2>Find Doctors</h2>
<form method="get">
    <input type="hidden" name="page" value="doctors">
    <input type="text" name="search" placeholder="Name or specialization" value="<?php echo htmlspecialchars($search); ?>">
    <select name="specialization">
        <option value="">All</option>
        <?php foreach($specializations as $s): ?>
            <option value="<?php echo $s['id']; ?>" <?php echo ($spec == $s['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <input type="number" name="min_fee" placeholder="Min fee" value="<?php echo $min; ?>">
    <input type="number" name="max_fee" placeholder="Max fee" value="<?php echo $max; ?>">
    <label>
        <input type="checkbox" name="filter_availability" <?php echo $filter_availability ? 'checked' : ''; ?>>
        Available on
    </label>
    <input type="date" name="availability_date" value="<?php echo $availability_date; ?>">
    <button type="submit">Search</button>
    <a href="?page=doctors">Reset</a>
</form>

<?php foreach($doctors as $d): 
    $rating = $doctorModel->getAverageRating($d['id']);
?>
<div style="border:1px solid #ccc; margin:10px; padding:10px;">
    <strong>Dr. <?php echo htmlspecialchars($d['name']); ?></strong> (<?php echo $d['specialization_name']; ?>)<br>
    Fee: <?php echo $d['consultation_fee']; ?> | Exp: <?php echo $d['experience_years']; ?> yrs<br>
    Rating: <?php echo round($rating['avg_rating'],1); ?> (<?php echo $rating['total']; ?> reviews)<br>
    <a href="?page=doctor_detail&id=<?php echo $d['id']; ?>">View Profile</a>
    <?php if($filter_availability): ?>
        <span style="background:green;color:white;padding:2px 5px;">✓ Available</span>
    <?php endif; ?>
</div>
<?php endforeach; ?>