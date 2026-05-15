<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add'])) {
        $dependentModel->add($patient_data['id'], $_POST['name'], $_POST['dob'], $_POST['relationship'], $_POST['blood_group']);
    }
    if(isset($_POST['update'])) {
        $dependentModel->update($_POST['dependent_id'], $patient_data['id'], $_POST['name'], $_POST['dob'], $_POST['relationship'], $_POST['blood_group']);
    }
    if(isset($_POST['delete'])) {
        $dependentModel->delete($_POST['dependent_id'], $patient_data['id']);
    }
    header("Location: ?page=dependents");
    exit;
}
$dependents = $dependentModel->getByPatient($patient_data['id']);
?>
<h2>Family Members</h2>
<form method="post">
    <h3>Add New</h3>
    <input type="text" name="name" placeholder="Name" required>
    <input type="date" name="dob">
    <input type="text" name="relationship" placeholder="Relationship">
    <select name="blood_group">
        <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
        <option>O+</option><option>O-</option><option>AB+</option><option>AB-</option>
    </select>
    <button type="submit" name="add">Add</button>
</form>

<?php foreach($dependents as $d): ?>
<div>
    <form method="post" style="display:inline-block;">
        <input type="hidden" name="dependent_id" value="<?php echo $d['id']; ?>">
        <input type="text" name="name" value="<?php echo htmlspecialchars($d['name']); ?>" required>
        <input type="date" name="dob" value="<?php echo $d['date_of_birth']; ?>">
        <input type="text" name="relationship" value="<?php echo htmlspecialchars($d['relationship']); ?>">
        <select name="blood_group">
            <?php $bg_opts = ['A+','A-','B+','B-','O+','O-','AB+','AB-']; ?>
            <?php foreach($bg_opts as $bg): ?>
                <option <?php echo ($d['blood_group'] == $bg) ? 'selected' : ''; ?>><?php echo $bg; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete" onclick="return confirm('Delete this family member?')">Delete</button>
    </form>
</div>
<?php endforeach; ?>