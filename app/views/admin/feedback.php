<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>User Feedback</h1>
    <p class="mb-4">Review feedback submitted by users</p>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($data['feedbacks'])): ?>
                <?php foreach ($data['feedbacks'] as $feedback): ?>
                    <div class="mb-3 p-3" style="border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                        <div class="d-flex justify-between align-center mb-2">
                            <strong>
                                <?php echo $feedback['full_name'] ? htmlspecialchars($feedback['full_name']) : 'Anonymous'; ?>
                            </strong>
                            <small style="color: #6b7280;">
                                <?php echo date('M d, Y \a\t h:i A', strtotime($feedback['created_at'])); ?>
                            </small>
                        </div>
                        <p style="margin: 0; color: #374151;">
                            <?php echo nl2br(htmlspecialchars($feedback['message'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center" style="color: #6b7280; padding: 2rem 0;">No feedback submitted yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
