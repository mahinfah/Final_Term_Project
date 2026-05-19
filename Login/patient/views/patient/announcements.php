<?php
$anns = $announcementModel->getForRole('patient');
?>
<h2>Announcements</h2>
<?php foreach($anns as $a): ?>
<div>
    <h3><?php echo htmlspecialchars($a['title']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($a['body'])); ?></p>
    <small>Posted by <?php echo $a['author_name']; ?> on <?php echo $a['published_at']; ?></small>
</div><hr>
<?php endforeach; ?>