<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12" style="max-width: 800px; margin: 0 auto;">
            <a href="<?php echo URL_ROOT; ?>/resource/index" class="btn btn-outline mb-3">← Back to Resources</a>
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-between align-center">
                        <span class="badge badge-info"><?php echo htmlspecialchars($data['resource']['category']); ?></span>
                        <small style="color: #6b7280;">
                            <?php echo date('F d, Y', strtotime($data['resource']['created_at'])); ?>
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <h1 style="margin-bottom: 1.5rem; color: #10b981;">
                        <?php echo htmlspecialchars($data['resource']['title']); ?>
                    </h1>
                    
                    <div style="line-height: 1.8; color: #374151;">
                        <?php echo nl2br(htmlspecialchars($data['resource']['content'])); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
