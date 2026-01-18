<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-between align-center mb-4">
        <h1>User Management</h1>
    </div>

    <?php
    if (isset($_SESSION['flash_success'])):
        $flash = $_SESSION['flash_success'];
        ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
            <?php echo $flash['message']; ?>
        </div>
        <?php
        unset($_SESSION['flash_success']);
    endif;
    ?>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($data['users'])): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $user['role'] === 'admin' ? 'danger' : 'info'; ?>">
                                        <?php echo ucfirst($user['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $user['status'] === 'active' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($user['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                        <?php if ($user['status'] === 'active'): ?>
                                            <a href="<?php echo URL_ROOT; ?>/admin/blockUser/<?php echo $user['user_id']; ?>" 
                                               class="btn btn-sm btn-warning"
                                               onclick="return confirm('Block this user?');">Block</a>
                                        <?php else: ?>
                                            <a href="<?php echo URL_ROOT; ?>/admin/activateUser/<?php echo $user['user_id']; ?>" 
                                               class="btn btn-sm btn-success">Activate</a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">You</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center" style="color: #6b7280; padding: 2rem 0;">No users found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
