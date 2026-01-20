<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-between align-center mb-4">
        <h1>Mental Health Resources</h1>
        <a href="<?php echo URL_ROOT; ?>/admin/createResource" class="btn btn-primary">+ Add New Resource</a>
    </div>

    <?php
    if (isset($_SESSION['flash_resource_success'])):
        $flash = $_SESSION['flash_resource_success'];
        ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
            <?php echo $flash['message']; ?>
        </div>
        <?php
        unset($_SESSION['flash_resource_success']);
    endif;
    ?>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($data['resources'])): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['resources'] as $resource): ?>
                            <tr>
                                <td><?php echo $resource['resource_id']; ?></td>
                                <td><?php echo htmlspecialchars($resource['title']); ?></td>
                                <td>
                                    <span class="badge badge-info">
                                        <?php echo htmlspecialchars($resource['category']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $resource['status'] === 'published' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($resource['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($resource['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/resource/viewResource/<?php echo $resource['resource_id']; ?>" 
                                       class="btn btn-sm btn-info" target="_blank">View</a>
                                    <a href="<?php echo URL_ROOT; ?>/admin/deleteResource/<?php echo $resource['resource_id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this resource?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center" style="color: #6b7280; padding: 2rem 0;">No resources found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
