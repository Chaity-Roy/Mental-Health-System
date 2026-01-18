<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>Admin Dashboard</h1>
    <p class="mb-4">System Overview and Management</p>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?php echo $data['userStats']['total_users']; ?></div>
            <div class="stat-label">Total Users</div>
        </div>

        <div class="stat-card" style="border-left-color: #f59e0b;">
            <div class="stat-value" style="color: #f59e0b;"><?php echo $data['requestStats']['pending_requests']; ?>
            </div>
            <div class="stat-label">Pending Requests</div>
        </div>

        <div class="stat-card" style="border-left-color: #10b981;">
            <div class="stat-value" style="color: #10b981;"><?php echo $data['requestStats']['completed_requests']; ?>
            </div>
            <div class="stat-label">Completed Requests</div>
        </div>

        <div class="stat-card" style="border-left-color: #3b82f6;">
            <div class="stat-value" style="color: #3b82f6;"><?php echo $data['resourceCount']; ?></div>
            <div class="stat-label">Published Resources</div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Requests -->
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex justify-between align-center">
                    <span>Recent Counseling Requests</span>
                    <a href="<?php echo URL_ROOT; ?>/admin/requests" class="btn btn-sm btn-outline"
                        style="background: white;">View All</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($data['recentRequests'])): ?>
                        <?php foreach ($data['recentRequests'] as $request): ?>
                            <div class="mb-3" style="padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb;">
                                <h5 style="margin-bottom: 0.5rem; font-size: 1rem;">
                                    <?php echo htmlspecialchars($request['subject']); ?>
                                </h5>
                                <div class="d-flex justify-between align-center">
                                    <span>
                                        <?php if ($request['is_anonymous'] === 'yes'): ?>
                                            <small style="color: #6b7280;">Anonymous</small>
                                        <?php else: ?>
                                            <small style="color: #6b7280;">
                                                <?php echo htmlspecialchars($request['full_name'] ?? 'Unknown'); ?>
                                            </small>
                                        <?php endif; ?>
                                    </span>
                                    <span class="badge badge-<?php
                                    echo $request['status'] == 'completed' ? 'success' :
                                        ($request['status'] == 'pending' ? 'warning' :
                                            ($request['status'] == 'approved' ? 'info' : 'danger'));
                                    ?>">
                                        <?php echo ucfirst($request['status']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No requests yet</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex justify-between align-center">
                    <span>Recent User Registrations</span>
                    <a href="<?php echo URL_ROOT; ?>/admin/users" class="btn btn-sm btn-outline"
                        style="background: white;">View All</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($data['recentUsers'])): ?>
                        <?php foreach ($data['recentUsers'] as $user): ?>
                            <div class="mb-3" style="padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb;">
                                <h5 style="margin-bottom: 0.5rem; font-size: 1rem;">
                                    <?php echo htmlspecialchars($user['full_name']); ?>
                                </h5>
                                <div class="d-flex justify-between align-center">
                                    <small style="color: #6b7280;">
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </small>
                                    <span
                                        class="badge badge-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($user['status']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No users yet</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mt-4 mb-4">
        <div class="card-header">Quick Actions</div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <a href="<?php echo URL_ROOT; ?>/admin/requests?status=pending" class="btn btn-warning btn-block">
                        Review Pending Requests
                    </a>
                </div>
                <div class="col-3">
                    <a href="<?php echo URL_ROOT; ?>/admin/users" class="btn btn-primary btn-block">
                        Manage Users
                    </a>
                </div>
                <div class="col-3">
                    <a href="<?php echo URL_ROOT; ?>/admin/createResource" class="btn btn-success btn-block">
                        Add New Resource
                    </a>
                </div>
                <div class="col-3">
                    <a href="<?php echo URL_ROOT; ?>/admin/feedback" class="btn btn-info btn-block">
                        View Feedback
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>