<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <h1>My Profile</h1>
    <p class="mb-4">Manage your account information</p>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">Profile Information</div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['flash_profile_success'])):
                        $flash = $_SESSION['flash_profile_success'];
                        ?>
                        <div class="alert alert-<?php echo $flash['type']; ?>">
                            <?php echo $flash['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['flash_profile_success']);
                    endif;
                    ?>

                    <?php if (isset($data['errors']['update'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $data['errors']['update']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/user/profile" method="POST">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name"
                                class="form-control <?php echo isset($data['errors']['full_name']) ? 'error' : ''; ?>"
                                value="<?php echo htmlspecialchars($data['user']['full_name']); ?>">
                            <?php if (isset($data['errors']['full_name'])): ?>
                                <span class="form-error"><?php echo $data['errors']['full_name']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email"
                                class="form-control <?php echo isset($data['errors']['email']) ? 'error' : ''; ?>"
                                value="<?php echo htmlspecialchars($data['user']['email']); ?>">
                            <?php if (isset($data['errors']['email'])): ?>
                                <span class="form-error"><?php echo $data['errors']['email']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Account Type</label>
                            <input type="text" class="form-control"
                                value="<?php echo ucfirst($data['user']['role']); ?>" readonly
                                style="background-color: #f9fafb;">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Member Since</label>
                            <input type="text" class="form-control"
                                value="<?php echo date('F d, Y', strtotime($data['user']['created_at'])); ?>" readonly
                                style="background-color: #f9fafb;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['flash_password_success'])):
                        $flash = $_SESSION['flash_password_success'];
                        ?>
                        <div class="alert alert-<?php echo $flash['type']; ?>">
                            <?php echo $flash['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['flash_password_success']);
                    endif;
                    ?>

                    <form id="changePasswordForm">
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                            <span class="form-error" id="error_current_password"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                            <span class="form-error" id="error_new_password"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                required>
                            <span class="form-error" id="error_confirm_password"></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    Account Actions
                </div>
                <div class="card-body">
                    <p style="color: #6b7280; margin-bottom: 1rem;">
                        Need to take a break? You can contact the administrator to deactivate your account.
                    </p>
                    <a href="<?php echo URL_ROOT; ?>/feedback/create" class="btn btn-outline btn-block">
                        Contact Administrator
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('error'));

        const formData = new FormData(this);
        const data = new URLSearchParams(formData).toString();

        fetch('<?php echo URL_ROOT; ?>/user/changePassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification('Password changed successfully!', 'success');
                    this.reset();
                } else {
                    for (let field in result.errors) {
                        const errorSpan = document.getElementById('error_' + field);
                        const inputField = document.getElementById(field);
                        if (errorSpan) {
                            errorSpan.textContent = result.errors[field];
                        }
                        if (inputField) {
                            inputField.classList.add('error');
                        }
                    }
                }
            })
            .catch(error => {
                showNotification('An error occurred. Please try again.', 'danger');
            });
    });
</script>

<?php require_once '../app/views/inc/footer.php'; ?>