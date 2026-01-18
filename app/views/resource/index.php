<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>Mental Health Resources</h1>
    <p class="mb-4">Explore our collection of helpful mental health resources and articles</p>

    <?php if (!empty($data['resources'])): ?>
        <div class="row">
            <?php foreach ($data['resources'] as $resource): ?>
                <div class="col-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-between align-center mb-2">
                                <span class="badge badge-info"><?php echo htmlspecialchars($resource['category']); ?></span>
                                <small style="color: #6b7280;">
                                    <?php echo date('M d, Y', strtotime($resource['created_at'])); ?>
                                </small>
                            </div>
                            <h3 class="card-title" style="margin-bottom: 1rem;">
                                <?php echo htmlspecialchars($resource['title']); ?>
                            </h3>
                            <p class="card-text">
                                <?php echo substr(htmlspecialchars($resource['content']), 0, 150); ?>...
                            </p>
                            <a href="<?php echo URL_ROOT; ?>/resource/viewResource/<?php echo $resource['resource_id']; ?>" 
                               class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center">
                <p style="color: #6b7280; padding: 2rem 0;">No resources available at the moment.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
