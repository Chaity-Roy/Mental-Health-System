# Quick Start Guide - Mental Health Management System

## 🚀 5-Minute Setup Guide

### Step 1: Prerequisites Check

- [ ] XAMPP/WAMP/MAMP installed
- [ ] Apache and MySQL running
- [ ] Web browser ready

### Step 2: Database Setup (2 minutes)

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create database: `mental_health_db`
3. Import file: `database/schema.sql`

### Step 3: Configure (1 minute)

1. Open: `config/database.php`
2. Verify settings:
   ```php
   DB_HOST = 'localhost'
   DB_USER = 'root'
   DB_PASS = '' (empty for localhost)
   DB_NAME = 'mental_health_db'
   ```

### Step 4: Access Application (30 seconds)

Open browser: `http://localhost/mental-health-system/public`

### Step 5: Login (30 seconds)

**Admin Login:**

- Email: `admin@mentalhealth.com`
- Password: `admin123`

---

## ✅ First Actions After Login

### As Admin:

1. Change default password (Security → Profile)
2. Add mental health resources (Resources → Create)
3. Review system settings

### As New User:

1. Click "Register"
2. Fill registration form
3. Login with credentials
4. Explore dashboard
5. Submit test request

---

## 🎯 Test the System

1. **Create User Account** → Register new user
2. **Submit Request** → Create counseling request
3. **Login as Admin** → Review request
4. **Respond to Request** → Update status and add response
5. **Check User View** → See admin response

---

## 🎨 Color Theme Reference

The system uses white and gradient green:

- Primary: `#10b981` (Emerald Green)
- Gradient: `#10b981` → `#059669`
- Background: White (`#ffffff`)

---

## 📁 Important Files

| File                  | Purpose            |
| --------------------- | ------------------ |
| `public/index.php`    | Entry point        |
| `config/config.php`   | App settings       |
| `config/database.php` | DB connection      |
| `database/schema.sql` | Database structure |

---

## 🔧 Common Issues & Quick Fixes

**Issue: 404 Error**

- Check: `.htaccess` files present
- Fix: Enable mod_rewrite in Apache

**Issue: Database Error**

- Check: MySQL is running
- Fix: Verify credentials in `config/database.php`

**Issue: Blank Page**

- Check: PHP errors in logs
- Fix: Check file permissions

**Issue: CSS Not Loading**

- Check: URL_ROOT in `config/config.php`
- Fix: Clear browser cache

---

## 📱 Quick Feature Access

### For Users:

- Dashboard: `/user/dashboard`
- New Request: `/request/create`
- My Requests: `/request/my-requests`
- Resources: `/resource/index`
- Profile: `/user/profile`

### For Admin:

- Dashboard: `/admin/dashboard`
- Requests: `/admin/requests`
- Users: `/admin/users`
- Resources: `/admin/resources`
- Feedback: `/admin/feedback`

---

## 🎓 Learn More

- **Full Installation**: See `INSTALLATION.md`
- **User Manual**: See `USER_GUIDE.md`
- **Project Details**: See `PROJECT_SUMMARY.md`
- **README**: See `README.md`

---

## 🎉 You're Ready!

The system is now ready to use. Start managing mental health support requests!

**Remember**:

- Change default admin password immediately
- Add relevant mental health resources
- Test all features before production use

---

**Need Help?** Check the documentation files or review the troubleshooting section in INSTALLATION.md

_Happy Mental Health Supporting! 💚_
