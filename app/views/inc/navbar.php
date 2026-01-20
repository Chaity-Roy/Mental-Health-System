<nav class="navbar">
    <div class="navbar-container container">
        <a href="<?php echo URL_ROOT; ?>" class="navbar-brand">
            Mental Health System
        </a>

        <button class="navbar-toggle" id="navbarToggle">
            ☰
        </button>

        <ul class="navbar-menu" id="navbarMenu">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="<?php echo URL_ROOT; ?>/admin/dashboard">Dashboard</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/admin/users">Users</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/admin/requests">Requests</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/admin/resources">Resources</a></li>
                <?php else: ?>
                    <li><a href="<?php echo URL_ROOT; ?>/user/dashboard">Dashboard</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/request/create">New Request</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/request/my-requests">My Requests</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/resource/index">Resources</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/feedback/create">Feedback</a></li>
                <?php endif; ?>
                <li><a href="<?php echo URL_ROOT; ?>/auth/logout">Logout (<?php echo $_SESSION['full_name']; ?>)</a></li>
            <?php else: ?>
                <li><a href="<?php echo URL_ROOT; ?>">Home</a></li>
                <li><a href="<?php echo URL_ROOT; ?>/auth/login">Login</a></li>
                <li><a href="<?php echo URL_ROOT; ?>/auth/register">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>