<?php
$conversations = $messageModel->getConversations($user_data['id']);
$selected_patient_id = isset($_GET['with']) ? (int)$_GET['with'] : null;
$messages = [];
$patient_name = '';
if ($selected_patient_id) {
    $messages = $messageModel->getMessages($user_data['id'], $selected_patient_id);
    $messageModel->markRead($user_data['id'], $selected_patient_id);
    // Get patient name
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->bind_param("i", $selected_patient_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) $patient_name = $row['name'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $receiver = (int)$_POST['receiver_id'];
    $msg = trim($_POST['message']);
    if (!empty($msg)) {
        $messageModel->sendMessage($user_data['id'], $receiver, null, $msg);
        header("Location: ?page=messages&with=" . $receiver);
        exit;
    }
}
?>
<h2>Patient Messages</h2>
<div style="display:flex;">
    <div style="width:30%; border-right:1px solid #ccc; padding-right:10px;">
        <h3>Conversations</h3>
        <?php if (count($conversations) > 0): ?>
            <ul style="list-style:none; padding-left:0;">
                <?php foreach ($conversations as $conv): ?>
                    <li style="margin-bottom:10px;">
                        <a href="?page=messages&with=<?php echo $conv['id']; ?>">
                            <strong><?php echo htmlspecialchars($conv['name']); ?></strong><br>
                            <small><?php echo htmlspecialchars(substr($conv['last_message'], 0, 50)); ?> ...</small>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No conversations yet.</p>
        <?php endif; ?>
    </div>
    <div style="width:70%; padding-left:20px;">
        <?php if ($selected_patient_id): ?>
            <h3>Chat with <?php echo htmlspecialchars($patient_name); ?></h3>
            <div style="height:400px; overflow-y:auto; border:1px solid #ddd; padding:10px; background:#f9f9f9;">
                <?php foreach ($messages as $msg): ?>
                    <div style="margin-bottom:15px; <?php echo ($msg['sender_id'] == $user_data['id']) ? 'text-align:right;' : ''; ?>">
                        <div style="display:inline-block; max-width:70%; background:<?php echo ($msg['sender_id'] == $user_data['id']) ? '#007bff' : '#e9ecef'; ?>; color:<?php echo ($msg['sender_id'] == $user_data['id']) ? 'white' : 'black'; ?>; padding:8px 12px; border-radius:15px;">
                            <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                        </div>
                        <br><small><?php echo date('h:i A, M j', strtotime($msg['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
            <form method="post" style="margin-top:15px;">
                <input type="hidden" name="receiver_id" value="<?php echo $selected_patient_id; ?>">
                <textarea name="message" rows="2" style="width:80%;" placeholder="Type your message..."></textarea>
                <button type="submit" name="send_message">Send</button>
            </form>
        <?php else: ?>
            <p>Select a patient from the left to start messaging.</p>
        <?php endif; ?>
    </div>
</div>