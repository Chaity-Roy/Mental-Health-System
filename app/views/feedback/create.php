<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>Submit Feedback</h1>
    <p class="mb-4">Help us improve our services by sharing your experience</p>

    <div class="row">
        <div class="col-6" style="margin: 0 auto;">
            <div class="card">
                <div class="card-header">Your Feedback</div>
                <div class="card-body">
                    <?php if (isset($data['errors']['create'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $data['errors']['create']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/feedback/create" method="POST">
                        <div class="form-group">
                            <label class="form-label">Your Message *</label>
                            <textarea name="message"
                                class="form-control <?php echo isset($data['errors']['message']) ? 'error' : ''; ?>"
                                rows="8"
                                placeholder="Share your thoughts, suggestions, or experiences with our mental health services..."
                                required><?php echo htmlspecialchars($data['message']); ?></textarea>
                            <?php if (isset($data['errors']['message'])): ?>
                                <span class="form-error"><?php echo $data['errors']['message']; ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($this->isLoggedIn()): ?>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="is_anonymous" id="is_anonymous">
                                <label for="is_anonymous">Submit anonymously</label>
                            </div>
                        <?php endif; ?>

                        <div class="alert alert-info mt-3">
                            <strong>Thank you!</strong> Your feedback helps us improve our mental health support
                            services.
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                            <?php if ($this->isLoggedIn()): ?>
                                <a href="<?php echo URL_ROOT; ?>/user/dashboard" class="btn btn-secondary">Cancel</a>
                            <?php else: ?>
                                <a href="<?php echo URL_ROOT; ?>" class="btn btn-secondary">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>