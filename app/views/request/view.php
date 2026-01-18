<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-8" style="margin: 0 auto;">
            <a href="<?php echo URL_ROOT; ?>/request/my-requests" class="btn btn-secondary mb-3">
                ← Back to My Requests
            </a>

            <div class="card">
                <div class="card-header">Request Details</div>
                <div class="card-body">
                    <div class="d-flex justify-between align-center mb-3">
                        <h3 style="margin: 0;"><?php echo htmlspecialchars($data['request']['subject']); ?></h3>
                        <span class="badge badge-<?php
                        echo $data['request']['status'] == 'completed' ? 'success' :
                            ($data['request']['status'] == 'pending' ? 'warning' :
                                ($data['request']['status'] == 'approved' ? 'info' : 'danger'));
                        ?>" style="font-size: 1rem; padding: 0.5rem 1rem;">
                            <?php echo ucfirst($data['request']['status']); ?>
                        </span>
                    </div>

                    <div class="mb-3" style="padding: 1rem; background-color: #f9fafb; border-radius: 8px;">
                        <p style="margin: 0; color: #6b7280;">
                            <strong>Submitted:</strong>
                            <?php echo date('F d, Y \a\t h:i A', strtotime($data['request']['created_at'])); ?>
                        </p>
                        <p style="margin: 0.5rem 0 0; color: #6b7280;">
                            <strong>Type:</strong>
                            <?php echo $data['request']['is_anonymous'] === 'yes' ? 'Anonymous' : 'Identified'; ?>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <p style="white-space: pre-wrap; color: #374151;">
                            <?php echo htmlspecialchars($data['request']['description']); ?>
                        </p>
                    </div>

                    <?php if ($data['request']['admin_response']): ?>
                        <div
                            style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #10b981;">
                            <h5 style="color: #065f46; margin-bottom: 1rem;">📝 Response from Mental Health Team</h5>
                            <p style="white-space: pre-wrap; color: #065f46; margin: 0;">
                                <?php echo htmlspecialchars($data['request']['admin_response']); ?>
                            </p>
                            <small style="color: #047857; display: block; margin-top: 1rem;">
                                Updated: <?php echo date('F d, Y \a\t h:i A', strtotime($data['request']['updated_at'])); ?>
                            </small>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <strong>Status Update:</strong> Your request is being reviewed by our mental health team. You
                            will be notified once there is an update.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>