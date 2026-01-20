<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12" style="max-width: 800px; margin: 0 auto;">
            <a href="<?php echo URL_ROOT; ?>/admin/resources" class="btn btn-outline mb-3">← Back to Resources</a>
            
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; color: white;">Create New Resource</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($data['errors']['create'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $data['errors']['create']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/admin/createResource" method="POST">
                        <div class="form-group">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" required
                                class="form-control <?php echo isset($data['errors']['title']) ? 'error' : ''; ?>"
                                value="<?php echo $data['resource_title']; ?>"
                                placeholder="Enter resource title">
                            <?php if (isset($data['errors']['title'])): ?>
                                <span class="form-error"><?php echo $data['errors']['title']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Category *</label>
                            <select name="category" required
                                class="form-control <?php echo isset($data['errors']['category']) ? 'error' : ''; ?>">
                                <option value="">Select Category</option>
                                <option value="General" <?php echo $data['category'] === 'General' ? 'selected' : ''; ?>>General</option>
                                <option value="Anxiety" <?php echo $data['category'] === 'Anxiety' ? 'selected' : ''; ?>>Anxiety</option>
                                <option value="Depression" <?php echo $data['category'] === 'Depression' ? 'selected' : ''; ?>>Depression</option>
                                <option value="Stress" <?php echo $data['category'] === 'Stress' ? 'selected' : ''; ?>>Stress</option>
                                <option value="Self-Care" <?php echo $data['category'] === 'Self-Care' ? 'selected' : ''; ?>>Self-Care</option>
                                <option value="Relationships" <?php echo $data['category'] === 'Relationships' ? 'selected' : ''; ?>>Relationships</option>
                                <option value="Wellness" <?php echo $data['category'] === 'Wellness' ? 'selected' : ''; ?>>Wellness</option>
                            </select>
                            <?php if (isset($data['errors']['category'])): ?>
                                <span class="form-error"><?php echo $data['errors']['category']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Content *</label>
                            <textarea name="content" required rows="10"
                                class="form-control <?php echo isset($data['errors']['content']) ? 'error' : ''; ?>"
                                placeholder="Enter resource content"><?php echo $data['content']; ?></textarea>
                            <?php if (isset($data['errors']['content'])): ?>
                                <span class="form-error"><?php echo $data['errors']['content']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" required class="form-control">
                                <option value="draft" <?php echo $data['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo $data['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create Resource</button>
                            <a href="<?php echo URL_ROOT; ?>/admin/resources" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
