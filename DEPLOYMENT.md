# Deployment Checklist - Mental Health Management System

## Pre-Deployment Checklist

### ✅ Development Complete

- [x] All 12 phases implemented
- [x] All features tested
- [x] Documentation complete
- [x] Security measures in place

### 📋 Before Going Live

#### 1. Security Configuration

- [ ] Change default admin password
- [ ] Update database credentials in `config/database.php`
- [ ] Set strong MySQL password
- [ ] Disable error display in production
  ```php
  // In config/config.php
  error_reporting(0);
  ini_set('display_errors', 0);
  ```
- [ ] Enable HTTPS (SSL certificate)
- [ ] Set secure session cookies
- [ ] Review file permissions

#### 2. Database Setup

- [ ] Backup existing database (if any)
- [ ] Create production database
- [ ] Import schema.sql
- [ ] Verify admin account created
- [ ] Test database connection
- [ ] Set up automated backups

#### 3. Configuration Updates

- [ ] Update URL_ROOT in `config/config.php`
- [ ] Update URL_SUBFOLDER if needed
- [ ] Set correct timezone
- [ ] Configure email settings (if applicable)
- [ ] Review session timeout settings

#### 4. Server Requirements

- [ ] PHP 7.4+ installed
- [ ] MySQL 5.7+ running
- [ ] Apache mod_rewrite enabled
- [ ] PDO extension enabled
- [ ] PHP memory limit adequate (128MB+)
- [ ] File upload permissions set

#### 5. File System

- [ ] All files uploaded to server
- [ ] .htaccess files in place
- [ ] Correct folder permissions
  - 755 for folders
  - 644 for files
  - 777 for uploads folder
- [ ] Remove development files

#### 6. Testing on Production

- [ ] Test user registration
- [ ] Test user login
- [ ] Test admin login
- [ ] Submit test request
- [ ] Test admin response
- [ ] Test resource viewing
- [ ] Test feedback submission
- [ ] Test on mobile devices
- [ ] Test on different browsers

#### 7. Content Setup

- [ ] Add real mental health resources
- [ ] Update default admin email
- [ ] Add contact information
- [ ] Review all static text
- [ ] Add privacy policy (if required)
- [ ] Add terms of service (if required)

#### 8. Performance

- [ ] Enable caching (if needed)
- [ ] Optimize images
- [ ] Minify CSS/JS (optional)
- [ ] Test load times
- [ ] Set up CDN (if needed)

#### 9. Monitoring

- [ ] Set up error logging
- [ ] Monitor server logs
- [ ] Set up uptime monitoring
- [ ] Plan backup strategy
- [ ] Set up maintenance schedule

#### 10. Documentation

- [ ] Update README with production URL
- [ ] Document admin procedures
- [ ] Create backup/restore guide
- [ ] Document troubleshooting steps

---

## Production Configuration

### config/config.php (Production)

```php
// Disable error display
error_reporting(0);
ini_set('display_errors', 0);

// Production URLs
define('URL_ROOT', '/public');  // Or your domain path
define('URL_SUBFOLDER', '');

// Secure sessions
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Only if HTTPS
```

### config/database.php (Production)

```php
define('DB_HOST', 'your_host');
define('DB_USER', 'your_user');      // NOT root
define('DB_PASS', 'strong_password');
define('DB_NAME', 'mental_health_db');
```

### Apache Virtual Host Example

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/mental-health-system/public

    <Directory /var/www/html/mental-health-system/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

# HTTPS (recommended)
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/mental-health-system/public

    SSLEngine on
    SSLCertificateFile /path/to/cert.pem
    SSLCertificateKeyFile /path/to/privkey.pem

    <Directory /var/www/html/mental-health-system/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

---

## Post-Deployment Tasks

### Immediate (Day 1)

- [ ] Verify all pages load correctly
- [ ] Test complete user workflow
- [ ] Test complete admin workflow
- [ ] Check mobile responsiveness
- [ ] Monitor error logs

### First Week

- [ ] Monitor user registrations
- [ ] Check for any errors
- [ ] Gather initial feedback
- [ ] Optimize slow queries
- [ ] Review security logs

### Ongoing

- [ ] Weekly database backups
- [ ] Monthly security audits
- [ ] Update content regularly
- [ ] Monitor user feedback
- [ ] Plan feature updates

---

## Security Hardening (Production)

### 1. Remove Development Files

```bash
rm -f phpinfo.php
rm -f test.php
rm -rf .git
```

### 2. Secure File Permissions

```bash
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 600 config/database.php
chmod 600 config/config.php
```

### 3. MySQL Security

```sql
-- Create dedicated user
CREATE USER 'mhms_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON mental_health_db.* TO 'mhms_user'@'localhost';
FLUSH PRIVILEGES;

-- Remove root access from config
```

### 4. Enable HTTPS

```bash
# Install Let's Encrypt SSL (free)
sudo certbot --apache -d yourdomain.com
```

### 5. Add Security Headers

Add to .htaccess:

```apache
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000"
</IfModule>
```

---

## Backup Strategy

### Database Backup (Automated)

```bash
#!/bin/bash
# backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/path/to/backups"
DB_NAME="mental_health_db"
DB_USER="your_user"
DB_PASS="your_password"

mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/backup_$DATE.sql
gzip $BACKUP_DIR/backup_$DATE.sql

# Keep only last 30 days
find $BACKUP_DIR -name "backup_*.sql.gz" -mtime +30 -delete
```

Schedule with cron:

```bash
# Daily at 2 AM
0 2 * * * /path/to/backup-db.sh
```

---

## Monitoring Setup

### Error Logging

```php
// In config/config.php (production)
ini_set('log_errors', 1);
ini_set('error_log', APP_ROOT . '/logs/error.log');
```

### Create logs directory

```bash
mkdir logs
chmod 777 logs
```

---

## Rollback Plan

If issues occur:

1. Keep backup of working version
2. Document all changes
3. Have rollback script ready
4. Test rollback procedure

---

## Support Contacts

**Emergency Contacts:**

- System Admin: [email]
- Database Admin: [email]
- Hosting Support: [contact]

**Escalation:**

1. Check error logs
2. Review recent changes
3. Contact system admin
4. Restore from backup if needed

---

## Success Criteria

✅ System accessible at production URL  
✅ All features working correctly  
✅ No errors in logs  
✅ Good performance (< 2s load time)  
✅ Mobile responsive  
✅ Secure (HTTPS enabled)  
✅ Backups running  
✅ Monitoring active

---

## Deployment Complete! 🎉

Once all items are checked:

1. Announce system launch
2. Provide training to admins
3. Share user guide with users
4. Monitor closely for first week
5. Gather and address feedback

---

**Good luck with your deployment!** 💚

_Remember: Always test on staging before production!_
