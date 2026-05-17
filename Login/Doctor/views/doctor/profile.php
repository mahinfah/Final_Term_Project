<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $photo_path = $doctor_data['photo_path']; // keep old if no new
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $target_dir = "../uploads/doctors/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $ext;
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo_path = $target_file;
        }
    }
    $doctorModel->updateProfile(
        $doctor_data['id'],
        $_POST['bio'],
        $_POST['consultation_fee'],
        $photo_path,
        $_POST['license_number'],
        $_POST['experience_years'],
        $_POST['specialization_id']
    );
    
    $doctor_data = $doctorModel->getByUserId($_SESSION['user_id']);
    echo '<p class="success">Profile updated successfully.</p>';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    if (strlen($_POST['new_password']) >= 6) {
        $user->changePassword($_SESSION['user_id'], $_POST['new_password']);
        echo '<p class="success">Password changed.</p>';
    } else {
        echo '<p class="error">Password must be at least 6 characters.</p>';
    }
}
?>
<h2>Doctor Profile</h2>
<form method="post" enctype="multipart/form-data">
    <?php if ($doctor_data['photo_path']): ?>
        <img src="../<?php echo $doctor_data['photo_path']; ?>" width="120" style="border-radius:50%;"><br>
    <?php endif; ?>
    <label>Profile Photo:</label> <input type="file" name="photo"><br>
    <label>Bio:</label><br>
    <textarea name="bio" rows="4" cols="50"><?php echo htmlspecialchars($doctor_data['bio']); ?></textarea><br>
    <label>Consultation Fee (BDT):</label> <input type="number" name="consultation_fee" value="<?php echo $doctor_data['consultation_fee']; ?>" step="50"><br>
    <label>License Number:</label> <input type="text" name="license_number" value="<?php echo htmlspecialchars($doctor_data['license_number']); ?>"><br>
    <label>Years of Experience:</label> <input type="number" name="experience_years" value="<?php echo $doctor_data['experience_years']; ?>"><br>
    <label>Specialization:</label>
    <select name="specialization_id">
        <?php foreach ($specializations as $spec): ?>
            <option value="<?php echo $spec['id']; ?>" <?php echo ($doctor_data['specialization_id'] == $spec['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($spec['name']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <button type="submit" name="update_profile">Update Profile</button>
</form>
<hr>
<h3>Change Password</h3>
<form method="post">
    <input type="password" name="new_password" placeholder="New Password" required>
    <button type="submit" name="change_password">Change Password</button>
</form>