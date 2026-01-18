<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4 mb-4">
    <a href="<?php echo URL_ROOT; ?>/admin/requests" class="btn btn-secondary mb-3">← Back to Requests</a>

    <div class="row">
        <div class="col-8" style="margin: 0 auto;">
            <div class="card">
                <div class="card-header">Review & Respond to Request</div>
                <div class="card-body">
                    <div class="mb-4">
                        <h3><?php echo htmlspecialchars($data['request']['subject']); ?></h3>
                        <p style="color: #6b7280;">
                            <strong>Submitted by:</strong>
                            <?php if ($data['request']['is_anonymous'] === 'yes'): ?>
                                Anonymous
                            <?php else: ?>
                                <?php echo htmlspecialchars($data['request']['full_name'] ?? 'Unknown'); ?>
                                (<?php echo htmlspecialchars($data['request']['email'] ?? ''); ?>)
                            <?php endif; ?>
                        </p>
                        <p style="color: #6b7280;">
                            <strong>Date:</strong>
                            <?php echo date('F d, Y \a\t h:i A', strtotime($data['request']['created_at'])); ?>
                        </p>
                        <p style="color: #6b7280;">
                            <strong>Current Status:</strong>
                            <span class="badge badge-<?php
                            echo $data['request']['status'] == 'completed' ? 'success' :
                                ($data['request']['status'] == 'pending' ? 'warning' :
                                    ($data['request']['status'] == 'approved' ? 'info' : 'danger'));
                            ?>">
                                <?php echo ucfirst($data['request']['status']); ?>
                            </span>
                        </p>
                    </div>

                    <div class="mb-4" style="background-color: #f9fafb; padding: 1.5rem; border-radius: 8px;">
                        <h5>User's Message:</h5>
                        <p style="white-space: pre-wrap; color: #374151;">
                            <?php echo htmlspecialchars($data['request']['description']); ?>
                        </p>
                    </div>

                    <form
                        action="<?php echo URL_ROOT; ?>/admin/viewRequest/<?php echo $data['request']['request_id']; ?>"
                        method="POST">
                        <div class="form-group">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" <?php echo $data['request']['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="approved" <?php echo $data['request']['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                <option value="completed" <?php echo $data['request']['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="rejected" <?php echo $data['request']['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Your Response</label>
                            <textarea name="admin_response" class="form-control" rows="8"
                                placeholder="Provide guidance, support, or response to the user's request..."
                                required><?php echo htmlspecialchars($data['request']['admin_response'] ?? ''); ?></textarea>
                        </div>

                        <div class="alert alert-info">
                            <strong>Note:</strong> The user will be notified of your response and status update.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Request</button>
                            <a href="<?php echo URL_ROOT; ?>/admin/requests" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>