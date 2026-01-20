<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12" style="max-width: 500px; margin: 3rem auto;">
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; color: white;">Create New Account</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($data['errors']['register'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $data['errors']['register']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/auth/register" method="POST">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name"
                                class="form-control <?php echo isset($data['errors']['full_name']) ? 'error' : ''; ?>"
                                value="<?php echo $data['full_name']; ?>" placeholder="Enter your full name">
                            <?php if (isset($data['errors']['full_name'])): ?>
                                <span class="form-error"><?php echo $data['errors']['full_name']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email"
                                class="form-control <?php echo isset($data['errors']['email']) ? 'error' : ''; ?>"
                                value="<?php echo $data['email']; ?>" placeholder="Enter your email">
                            <?php if (isset($data['errors']['email'])): ?>
                                <span class="form-error"><?php echo $data['errors']['email']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control <?php echo isset($data['errors']['password']) ? 'error' : ''; ?>"
                                placeholder="Enter password (min. 6 characters)">
                            <?php if (isset($data['errors']['password'])): ?>
                                <span class="form-error"><?php echo $data['errors']['password']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password"
                                class="form-control <?php echo isset($data['errors']['confirm_password']) ? 'error' : ''; ?>"
                                placeholder="Confirm your password">
                            <?php if (isset($data['errors']['confirm_password'])): ?>
                                <span class="form-error"><?php echo $data['errors']['confirm_password']; ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p style="margin: 0;">Already have an account? <a href="<?php echo URL_ROOT; ?>/auth/login">Login
                            here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>