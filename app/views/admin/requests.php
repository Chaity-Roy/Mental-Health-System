<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>Manage Counseling Requests</h1>
    <p class="mb-4">Review and respond to user requests</p>

    <!-- Filter Tabs -->
    <div class="mb-3" style="display: flex; gap: 1rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem;">
        <a href="<?php echo URL_ROOT; ?>/admin/requests"
            class="<?php echo !$data['currentStatus'] ? 'btn btn-primary' : 'btn btn-outline'; ?>">
            All Requests
        </a>
        <a href="<?php echo URL_ROOT; ?>/admin/requests?status=pending"
            class="<?php echo $data['currentStatus'] === 'pending' ? 'btn btn-warning' : 'btn btn-outline'; ?>">
            Pending
        </a>
        <a href="<?php echo URL_ROOT; ?>/admin/requests?status=approved"
            class="<?php echo $data['currentStatus'] === 'approved' ? 'btn btn-info' : 'btn btn-outline'; ?>">
            Approved
        </a>
        <a href="<?php echo URL_ROOT; ?>/admin/requests?status=completed"
            class="<?php echo $data['currentStatus'] === 'completed' ? 'btn btn-success' : 'btn btn-outline'; ?>">
            Completed
        </a>
        <a href="<?php echo URL_ROOT; ?>/admin/requests?status=rejected"
            class="<?php echo $data['currentStatus'] === 'rejected' ? 'btn btn-danger' : 'btn btn-outline'; ?>">
            Rejected
        </a>
    </div>

    <?php
    if (isset($_SESSION['flash_request_success'])):
        $flash = $_SESSION['flash_request_success'];
        ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
            <?php echo $flash['message']; ?>
        </div>
        <?php
        unset($_SESSION['flash_request_success']);
    endif;
    ?>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($data['requests'])): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['requests'] as $request): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($request['subject']); ?></strong>
                                </td>
                                <td>
                                    <?php if ($request['is_anonymous'] === 'yes'): ?>
                                        <span class="badge badge-secondary">Anonymous</span>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($request['full_name'] ?? 'Unknown'); ?><br>
                                        <small
                                            style="color: #6b7280;"><?php echo htmlspecialchars($request['email'] ?? ''); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php
                                    echo $request['status'] == 'completed' ? 'success' :
                                        ($request['status'] == 'pending' ? 'warning' :
                                            ($request['status'] == 'approved' ? 'info' : 'danger'));
                                    ?>">
                                        <?php echo ucfirst($request['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo $request['is_anonymous'] === 'yes' ? 'Anonymous' : 'Identified'; ?>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($request['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/admin/viewRequest/<?php echo $request['request_id']; ?>"
                                        class="btn btn-sm btn-primary">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center" style="padding: 3rem;">
                    <h3 style="color: #6b7280;">No requests found</h3>
                    <p style="color: #9ca3af;">
                        <?php echo $data['currentStatus'] ? 'No ' . $data['currentStatus'] . ' requests at the moment.' : 'No requests have been submitted yet.'; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>