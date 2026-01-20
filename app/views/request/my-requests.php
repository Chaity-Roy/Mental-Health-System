<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1>My Counseling Requests</h1>
            <p>Track and manage your submitted requests</p>
        </div>
        <a href="<?php echo URL_ROOT; ?>/request/create" class="btn btn-primary">
            Submit New Request
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
                            <th>Status</th>
                            <th>Type</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['requests'] as $request): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($request['subject']); ?></strong>
                                    <br>
                                    <small style="color: #6b7280;">
                                        <?php echo substr(htmlspecialchars($request['description']), 0, 80); ?>...
                                    </small>
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
                                    <?php if ($request['is_anonymous'] === 'yes'): ?>
                                        <span class="badge badge-secondary">Anonymous</span>
                                    <?php else: ?>
                                        <span class="badge badge-info">Identified</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($request['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/request/view/<?php echo $request['request_id']; ?>"
                                        class="btn btn-sm btn-outline">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center" style="padding: 3rem;">
                    <h3 style="color: #6b7280;">No requests yet</h3>
                    <p style="color: #9ca3af; margin-bottom: 2rem;">
                        You haven't submitted any counseling requests yet.
                    </p>
                    <a href="<?php echo URL_ROOT; ?>/request/create" class="btn btn-primary">
                        Submit Your First Request
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>