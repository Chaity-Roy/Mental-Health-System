<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12" style="max-width: 450px; margin: 3rem auto;">
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; color: white;">Login to Your Account</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Display flash message
                    if (isset($_SESSION['flash_register_success'])):
                        $flash = $_SESSION['flash_register_success'];
                        ?>
                        <div class="alert alert-<?php echo $flash['type']; ?>">
                            <?php echo $flash['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['flash_register_success']);
                    endif;
                    ?>

                    <?php if (isset($data['errors']['login'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $data['errors']['login']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/auth/login" method="POST">
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
                                placeholder="Enter your password">
                            <?php if (isset($data['errors']['password'])): ?>
                                <span class="form-error"><?php echo $data['errors']['password']; ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p style="margin: 0;">Don't have an account? <a
                            href="<?php echo URL_ROOT; ?>/auth/register">Register here</a></p>
                </div>
            </div>

            <!-- Demo accounts removed from login page as requested -->
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>