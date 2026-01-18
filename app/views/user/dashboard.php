<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>Welcome, <?php echo $_SESSION['full_name']; ?>! 👋</h1>
    <p class="mb-4">Here's an overview of your mental health journey</p>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?php echo $data['stats']['total_requests']; ?></div>
            <div class="stat-label">Total Requests</div>
        </div>

        <div class="stat-card" style="border-left-color: #f59e0b;">
            <div class="stat-value" style="color: #f59e0b;"><?php echo $data['stats']['pending_requests']; ?></div>
            <div class="stat-label">Pending Requests</div>
        </div>

        <div class="stat-card" style="border-left-color: #10b981;">
            <div class="stat-value" style="color: #10b981;"><?php echo $data['stats']['completed_requests']; ?></div>
            <div class="stat-label">Completed Requests</div>
        </div>

        <div class="stat-card" style="border-left-color: #3b82f6;">
            <div class="stat-value" style="color: #3b82f6;"><?php echo $data['unreadNotifications']; ?></div>
            <div class="stat-label">Unread Notifications</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-6">
            <div class="card">
                <div class="card-header">Quick Actions</div>
                <div class="card-body">
                    <a href="<?php echo URL_ROOT; ?>/request/create" class="btn btn-primary btn-block mb-2">
                        Submit New Request
                    </a>
                    <a href="<?php echo URL_ROOT; ?>/request/my-requests" class="btn btn-outline btn-block mb-2">
                        View My Requests
                    </a>
                    <a href="<?php echo URL_ROOT; ?>/resource/index" class="btn btn-outline btn-block mb-2">
                        Browse Resources
                    </a>
                    <a href="<?php echo URL_ROOT; ?>/feedback/create" class="btn btn-outline btn-block">
                        Submit Feedback
                    </a>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">Recent Requests</div>
                <div class="card-body">
                    <?php if (!empty($data['recentRequests'])): ?>
                        <?php foreach ($data['recentRequests'] as $request): ?>
                            <div class="mb-3" style="padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb;">
                                <h5 style="margin-bottom: 0.5rem; font-size: 1rem;">
                                    <?php echo htmlspecialchars($request['subject']); ?>
                                </h5>
                                <div class="d-flex justify-between align-center">
                                    <span class="badge badge-<?php
                                    echo $request['status'] == 'completed' ? 'success' :
                                        ($request['status'] == 'pending' ? 'warning' :
                                            ($request['status'] == 'approved' ? 'info' : 'danger'));
                                    ?>">
                                        <?php echo ucfirst($request['status']); ?>
                                    </span>
                                    <small style="color: #6b7280;">
                                        <?php echo date('M d, Y', strtotime($request['created_at'])); ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <a href="<?php echo URL_ROOT; ?>/request/my-requests" class="btn btn-sm btn-outline btn-block mt-3">
                            View All Requests
                        </a>
                    <?php else: ?>
                        <p style="color: #6b7280; text-align: center; padding: 2rem 0;">
                            No requests yet. Start by submitting your first request.
                        </p>
                        <a href="<?php echo URL_ROOT; ?>/request/create" class="btn btn-primary btn-block">
                            Submit First Request
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mental Health Tips -->
    <div class="card mt-4 mb-4">
        <div class="card-header">Mental Health Tips 💡</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <h5 style="color: #10b981;">Practice Self-Care</h5>
                    <p style="color: #6b7280;">Take time for activities you enjoy and that help you relax.</p>
                </div>
                <div class="col-4">
                    <h5 style="color: #10b981;">Stay Connected</h5>
                    <p style="color: #6b7280;">Maintain healthy relationships with friends and family.</p>
                </div>
                <div class="col-4">
                    <h5 style="color: #10b981;">Seek Help</h5>
                    <p style="color: #6b7280;">Don't hesitate to reach out when you need support.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>