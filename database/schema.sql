-- Mental Health Management System Database Schema
-- Created: January 2026

-- Create Database
CREATE DATABASE IF NOT EXISTS mental_health_db;

USE mental_health_db;

-- Table 1: Users (stores both users and admins)
CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('active', 'blocked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Table 2: Counseling Requests
CREATE TABLE IF NOT EXISTS requests (
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    subject VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    is_anonymous ENUM('yes', 'no') DEFAULT 'no',
    status ENUM(
        'pending',
        'approved',
        'rejected',
        'completed'
    ) DEFAULT 'pending',
    admin_response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Table 3: Feedback
CREATE TABLE IF NOT EXISTS feedback (
    feedback_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Table 4: Mental Health Resources
CREATE TABLE IF NOT EXISTS resources (
    resource_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50),
    created_by INT,
    status ENUM('published', 'draft') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users (user_id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_created_at (created_at)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Table 5: Notifications
CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read ENUM('yes', 'no') DEFAULT 'no',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_is_read (is_read),
    INDEX idx_created_at (created_at)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Table 6: Activity Logs (Optional - for tracking user and admin activities)
CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_timestamp (timestamp)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Insert Default Admin Account
-- Password: admin123 (hashed using password_hash in PHP)
INSERT INTO
    users (
        full_name,
        email,
        password_hash,
        role,
        status
    )
VALUES (
        'System Administrator',
        'admin@mentalhealth.com',
        '$2y$12$DgYkMxd1LE6.II0EkGJKVuvehTDamkTKeD0AR8Thdx5bFtNn32EPG',
        'admin',
        'active'
    )
ON DUPLICATE KEY UPDATE
    password_hash = '$2y$12$DgYkMxd1LE6.II0EkGJKVuvehTDamkTKeD0AR8Thdx5bFtNn32EPG';

-- Insert Sample Mental Health Resources
INSERT INTO
    resources (
        title,
        content,
        category,
        created_by,
        status
    )
VALUES (
        'Understanding Mental Health',
        'Mental health includes our emotional, psychological, and social well-being. It affects how we think, feel, and act.',
        'General',
        1,
        'published'
    ),
    (
        'Managing Stress and Anxiety',
        'Stress and anxiety are normal responses to challenging situations. Learn effective coping strategies.',
        'Anxiety',
        1,
        'published'
    ),
    (
        'Importance of Self-Care',
        'Self-care is essential for maintaining good mental health. It includes activities that help you relax and recharge.',
        'Self-Care',
        1,
        'published'
    );