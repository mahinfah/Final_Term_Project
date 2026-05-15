<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['update_profile'])) {
        $profile_pic = null;
        if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $target_dir = "../uploads/profiles/";
            if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
            $target_file = $target_dir . $filename;
            if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $profile_pic = $target_file;
            }
        }
        $user->updateProfile($_SESSION['user_id'], $_POST['name'], $_POST['phone'], $profile_pic);
        $patientModel->update($_SESSION['user_id'], $_POST['dob'], $_POST['blood_group'], $_POST['gender'], $_POST['address'], $_POST['emergency_name'], $_POST['emergency_phone'], $_POST['medical_history']);
        echo "<p class='success'>Profile updated.</p>";
        $user_data = $user->getUserById($_SESSION['user_id']);
        $patient_data = $patientModel->getByUserId($_SESSION['user_id']);
    }
    if(isset($_POST['change_password'])) {
        if(strlen($_POST['new_password']) >= 6) {
            $user->changePassword($_SESSION['user_id'], $_POST['new_password']);
            echo "<p class='success'>Password changed.</p>";
        } else echo "<p class='error'>Password must be 6+ chars.</p>";
    }
}
?>
<h2>My Profile</h2>
<form method="post" enctype="multipart/form-data">
    <?php if($user_data['profile_pic']): ?>
        <img src="../<?php echo $user_data['profile_pic']; ?>" width="50"><br>
    <?php endif; ?>
    <label>Profile Picture:</label> <input type="file" name="profile_pic"><br>
    <label>Full Name:</label> <input type="text" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required><br>
    <label>Phone:</label> <input type="text" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>" required><br>
    <label>Date of Birth:</label> <input type="date" name="dob" value="<?php echo $patient_data['date_of_birth']; ?>"><br>
    <label>Blood Group:</label> <select name="blood_group">
        <?php $bg=['A+','A-','B+','B-','O+','O-','AB+','AB-']; foreach($bg as $b) echo "<option ".($patient_data['blood_group']==$b?'selected':'').">$b</option>"; ?>
    </select><br>
    <label>Gender:</label> <select name="gender">
        <option <?php echo $patient_data['gender']=='Male'?'selected':''; ?>>Male</option>
        <option <?php echo $patient_data['gender']=='Female'?'selected':''; ?>>Female</option>
        <option <?php echo $patient_data['gender']=='Other'?'selected':''; ?>>Other</option>
    </select><br>
    <label>Address:</label> <textarea name="address"><?php echo htmlspecialchars($patient_data['address']); ?></textarea><br>
    <label>Emergency Contact Name:</label> <input type="text" name="emergency_name" value="<?php echo htmlspecialchars($patient_data['emergency_contact_name']); ?>"><br>
    <label>Emergency Phone:</label> <input type="text" name="emergency_phone" value="<?php echo htmlspecialchars($patient_data['emergency_contact_phone']); ?>"><br>
    <label>Medical History Notes:</label> <textarea name="medical_history"><?php echo htmlspecialchars($patient_data['medical_history_notes']); ?></textarea><br>
    <button type="submit" name="update_profile">Update Profile</button>
</form>
<hr>
<h3>Change Password</h3>
<form method="post">
    <input type="password" name="new_password" placeholder="New Password" required>
    <button type="submit" name="change_password">Change</button>
</form>