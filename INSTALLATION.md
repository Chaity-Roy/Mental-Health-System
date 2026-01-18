# Mental Health Management System - Installation Guide

## Prerequisites

Before installing the Mental Health Management System, ensure you have the following:

- **Web Server**: Apache (with mod_rewrite enabled) or Nginx
- **PHP**: Version 7.4 or higher
- **MySQL/MariaDB**: Version 5.7 or higher
- **phpMyAdmin**: (Optional but recommended for database management)

## Installation Steps

### Step 1: Setup Web Server

#### For XAMPP/WAMP/MAMP Users:

1. Download and install XAMPP/WAMP/MAMP
2. Start Apache and MySQL services

#### For Production Server:

1. Ensure Apache and MySQL are installed and running
2. Enable mod_rewrite: `sudo a2enmod rewrite`

### Step 2: Copy Project Files

1. Clone or download the project
2. Copy the `mental-health-system` folder to your web server directory:
   - XAMPP: `C:/xampp/htdocs/mental-health-system`
   - WAMP: `C:/wamp64/www/mental-health-system`
   - MAMP: `/Applications/MAMP/htdocs/mental-health-system`
   - Linux: `/var/www/html/mental-health-system`

### Step 3: Create Database

1. Open phpMyAdmin in your browser:

   - XAMPP: `http://localhost/phpmyadmin`
   - Production: `http://yourdomain.com/phpmyadmin`

2. Create a new database:

   - Click on "New" in the left sidebar
   - Database name: `mental_health_db`
   - Collation: `utf8mb4_general_ci`
   - Click "Create"

3. Import the database schema:
   - Select the `mental_health_db` database
   - Click on the "Import" tab
   - Click "Choose File" and select `database/schema.sql`
   - Click "Go" to import

### Step 4: Configure Database Connection

1. Open the file: `config/database.php`
2. Update the database credentials if needed:

```php
define('DB_HOST', 'localhost');      // Database host
define('DB_USER', 'root');           // Database username
define('DB_PASS', '');               // Database password (empty for localhost)
define('DB_NAME', 'mental_health_db'); // Database name
```

**Note**: For production, use secure credentials and never use 'root' user.

### Step 5: Configure Application Settings

1. Open the file: `config/config.php`
2. Update the URL settings based on your setup:

```php
// For localhost with subfolder
define('URL_ROOT', '/mental-health-system/public');
define('URL_SUBFOLDER', '/mental-health-system');

// For production (domain root)
// define('URL_ROOT', '/public');
// define('URL_SUBFOLDER', '');
```

### Step 6: Set Folder Permissions (Linux/Mac only)

```bash
chmod -R 755 /var/www/html/mental-health-system
chmod -R 777 /var/www/html/mental-health-system/public/uploads
```

### Step 7: Configure Apache .htaccess (if needed)

The project includes `.htaccess` files. Ensure `AllowOverride All` is set in your Apache configuration.

For Ubuntu/Linux, edit:

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

Add inside `<VirtualHost>`:

```apache
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

Restart Apache:

```bash
sudo systemctl restart apache2
```

### Step 8: Access the Application

1. Open your web browser
2. Navigate to:
   - Local: `http://localhost/mental-health-system/public`
   - Production: `http://yourdomain.com`

### Step 9: Login Credentials

#### Default Admin Account:

- **Email**: admin@mentalhealth.com
- **Password**: admin123

#### Create User Account:

- Click "Register" to create a new user account
- Fill in the registration form

## Troubleshooting

### Issue: 404 Page Not Found

**Solution**:

1. Check if mod_rewrite is enabled
2. Verify .htaccess files are in place
3. Check URL_ROOT in config.php

### Issue: Database Connection Error

**Solution**:

1. Verify MySQL service is running
2. Check database credentials in `config/database.php`
3. Ensure database `mental_health_db` exists

### Issue: Blank Page

**Solution**:

1. Enable error reporting in `config/config.php`
2. Check PHP error logs
3. Verify all files are uploaded correctly

### Issue: CSS/JS Not Loading

**Solution**:

1. Check URL_ROOT path in `config/config.php`
2. Verify file permissions
3. Clear browser cache

## Security Recommendations for Production

1. **Change Default Admin Password**:

   - Login as admin
   - Go to Profile > Change Password
   - Use a strong password

2. **Update Database Credentials**:

   - Create a dedicated MySQL user
   - Grant only necessary privileges
   - Use strong password

3. **Disable Error Display**:

   - In `config/config.php`, set:

   ```php
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

4. **Enable HTTPS**:

   - Install SSL certificate
   - Force HTTPS in .htaccess

5. **Set Secure Session Settings**:
   - Add to `config/config.php`:
   ```php
   ini_set('session.cookie_httponly', 1);
   ini_set('session.use_only_cookies', 1);
   ini_set('session.cookie_secure', 1);
   ```

## System Requirements

- **Minimum PHP Version**: 7.4
- **Recommended PHP Extensions**:

  - PDO
  - PDO_MySQL
  - mbstring
  - openssl
  - json

- **Disk Space**: At least 50MB free
- **Memory**: Minimum 128MB PHP memory limit

## Support

For issues or questions:

- Check the documentation
- Review error logs
- Verify configuration settings

## Next Steps

1. Login as admin
2. Add mental health resources
3. Configure system settings
4. Test user registration and request submission
5. Review and respond to test requests

---

**Important**: Always backup your database before making any changes or updates to the system.
