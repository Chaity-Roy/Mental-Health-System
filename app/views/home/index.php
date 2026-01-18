<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/navbar.php'; ?>

<div class="hero">
    <div class="container">
        <h1>Welcome to Mental Health Management System</h1>
        <p>Your safe space for mental health support and counseling. We're here to help you on your journey to wellness.
        </p>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="d-flex justify-between align-center gap-2" style="justify-content: center; margin-top: 2rem;">
                <a href="<?php echo URL_ROOT; ?>/auth/register" class="btn btn-primary btn-lg">Get Started</a>
                <a href="<?php echo URL_ROOT; ?>/auth/login" class="btn btn-outline btn-lg"
                    style="background-color: white;">Login</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="container mt-4 mb-4">
    <h2 class="text-center mb-4">Our Services</h2>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #10b981;">🤝 Counseling Support</h3>
                    <p class="card-text">Submit counseling requests and receive professional guidance from our team of
                        mental health professionals.</p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #10b981;">🔒 Anonymous Requests</h3>
                    <p class="card-text">Your privacy matters. Submit requests anonymously whenever you need
                        confidential support.</p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #10b981;">📚 Resources</h3>
                    <p class="card-text">Access a wealth of mental health resources, articles, and tips to support your
                        wellness journey.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #10b981;">📊 Track Progress</h3>
                    <p class="card-text">Monitor your counseling requests and track the status of your mental health
                        journey.</p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #10b981;">💬 Feedback System</h3>
                    <p class="card-text">Share your experience and help us improve our services through anonymous or
                        identified feedback.</p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #10b981;">🔔 Notifications</h3>
                    <p class="card-text">Stay updated with real-time notifications about your requests and important
                        announcements.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <h2 style="color: #10b981;">Why Choose Us?</h2>
            <p style="max-width: 800px; margin: 1rem auto;">
                We understand that seeking help for mental health can be challenging. Our platform provides
                a secure, confidential, and supportive environment where you can express your concerns and
                receive the help you deserve. Your mental health matters, and we're committed to supporting
                you every step of the way.
            </p>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="<?php echo URL_ROOT; ?>/auth/register" class="btn btn-primary btn-lg mt-3">Join Us Today</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>