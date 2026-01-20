<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>Submit Counseling Request</h1>
    <p class="mb-4">Share your concerns and we'll provide support and guidance</p>
    
    <div class="row">
        <div class="col-8" style="margin: 0 auto;">
            <div class="card">
                <div class="card-header">New Request</div>
                <div class="card-body">
                    <?php if (isset($data['errors']['create'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $data['errors']['create']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo URL_ROOT; ?>/request/create" method="POST">
                        <div class="form-group">
                            <label class="form-label">Subject *</label>
                            <input 
                                type="text" 
                                name="subject" 
                                class="form-control <?php echo isset($data['errors']['subject']) ? 'error' : ''; ?>"
                                value="<?php echo htmlspecialchars($data['subject']); ?>"
                                placeholder="Brief description of your concern"
                                required
                            >
                            <?php if (isset($data['errors']['subject'])): ?>
                                <span class="form-error"><?php echo $data['errors']['subject']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea 
                                name="description" 
                                class="form-control <?php echo isset($data['errors']['description']) ? 'error' : ''; ?>"
                                rows="8"
                                placeholder="Please describe your situation in detail. The more information you provide, the better we can assist you."
                                required
                            ><?php echo htmlspecialchars($data['description']); ?></textarea>
                            <?php if (isset($data['errors']['description'])): ?>
                                <span class="form-error"><?php echo $data['errors']['description']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="checkbox-wrapper">
                            <input 
                                type="checkbox" 
                                name="is_anonymous" 
                                id="is_anonymous"
                                <?php echo $data['is_anonymous'] === 'yes' ? 'checked' : ''; ?>
                            >
                            <label for="is_anonymous">Submit anonymously (your identity will be hidden)</label>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <strong>Privacy Notice:</strong> Your information is confidential and will only be accessible to authorized mental health professionals.
                        </div>
                        
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                            <a href="<?php echo URL_ROOT; ?>/user/dashboard" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>
