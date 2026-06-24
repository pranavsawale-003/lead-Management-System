-- ============================================================
-- Lead Management System
-- Lead Management System - Database Setup
-- Developer: Intern




-- ============================================================

-- Create database
CREATE DATABASE IF NOT EXISTS lead_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lead_management;

-- ============================================================
-- TABLE: users
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    role         ENUM('Admin','Team Lead','Sales Executive') NOT NULL DEFAULT 'Sales Executive',
    phone        VARCHAR(15),
    status       ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login   DATETIME,
    INDEX idx_email  (email),
    INDEX idx_role   (role),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: leads
-- ============================================================
CREATE TABLE IF NOT EXISTS leads (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    lead_name      VARCHAR(100) NOT NULL,
    company_name   VARCHAR(150),
    mobile         VARCHAR(15) NOT NULL,
    email          VARCHAR(150),
    source         ENUM('Website','Referral','Walk-in','Cold Call','Email','Social','Exhibition','Other') DEFAULT 'Website',
    status         ENUM('New','In Progress','Qualified','Follow-up','Converted','Lost') NOT NULL DEFAULT 'New',
    assigned_to    VARCHAR(100),
    assigned_user_id INT,
    remarks        TEXT,
    follow_up_date DATE,
    budget         VARCHAR(50),
    area           VARCHAR(100),
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    converted_at   DATETIME,
    INDEX idx_status      (status),
    INDEX idx_source      (source),
    INDEX idx_assigned    (assigned_to),
    INDEX idx_created     (created_at),
    FOREIGN KEY (assigned_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: follow_ups
-- ============================================================
CREATE TABLE IF NOT EXISTS follow_ups (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    lead_id      INT NOT NULL,
    user_id      INT,
    follow_up_date DATE NOT NULL,
    follow_up_time TIME,
    type         ENUM('Call','Email','Visit','Meeting') DEFAULT 'Call',
    status       ENUM('Pending','Completed','Cancelled') DEFAULT 'Pending',
    notes        TEXT,
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_lead_id      (lead_id),
    INDEX idx_follow_date  (follow_up_date),
    INDEX idx_status       (status),
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: activity_logs
-- ============================================================
CREATE TABLE IF NOT EXISTS activity_logs (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    activity     VARCHAR(100) NOT NULL,
    lead_id      INT,
    lead_name    VARCHAR(100),
    company      VARCHAR(150),
    user_id      INT,
    user_name    VARCHAR(100),
    notes        TEXT,
    logged_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_lead_id   (lead_id),
    INDEX idx_user_id   (user_id),
    INDEX idx_logged_at (logged_at),
    FOREIGN KEY (lead_id)  REFERENCES leads(id)  ON DELETE SET NULL,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- SEED DATA: users
-- ============================================================
INSERT INTO users (name, email, password, role, phone, status, created_at) VALUES
('Akash Sharma', 'admin@leadms.com',  MD5('admin123'), 'Admin',           '9876543210', 'Active', '2026-01-01 09:00:00'),
('Sneha Verma',  'sneha@leadms.com',  MD5('sales123'), 'Sales Executive', '9765432101', 'Active', '2026-01-15 09:00:00'),
('Rohit Patil',  'rohit@leadms.com',  MD5('lead123'),  'Team Lead',       '9654321012', 'Active', '2026-01-10 09:00:00'),
('Karan Mehta',  'karan@leadms.com',  MD5('sales123'), 'Sales Executive', '9543210123', 'Active', '2026-01-20 09:00:00')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- ============================================================
-- SEED DATA: leads
-- ============================================================
INSERT INTO leads (lead_name, company_name, mobile, email, source, status, assigned_to, remarks, follow_up_date, area, budget, created_at) VALUES
('Rajesh Patil',   'Tata Motors',        '9876543210', 'rajesh@tata.com',         'Website',   'New',         'Sneha Verma', 'Interested in fleet vehicles',            '2026-06-25', 'Pune',   '> ₹1Cr',     '2026-06-24 09:00:00'),
('Priya Joshi',    'Infosys',            '9765432109', 'priya@infosys.com',        'Referral',  'In Progress', 'Rohit Patil', 'Following up on IT services proposal',    '2026-06-26', 'Mumbai', '₹50L-1Cr',   '2026-06-23 10:00:00'),
('Amit Deshmukh',  'Wipro',              '9654321098', 'amit@wipro.com',           'Walk-in',   'Qualified',   'Sneha Verma', 'Budget confirmed, proposal sent',         '2026-06-27', 'Pune',   '₹25L-50L',   '2026-06-22 11:00:00'),
('Neha Kulkarni',  'HCL Technologies',   '9543210987', 'neha@hcl.com',            'Website',   'Follow-up',   'Karan Mehta', 'Second follow-up scheduled',              '2026-06-25', 'Nagpur', '₹25L-50L',   '2026-06-21 12:00:00'),
('Rohit Jadhav',   'Tech Mahindra',      '9432109876', 'rohit@techmahindra.com',   'Cold Call', 'Converted',   'Rohit Patil', 'Deal closed successfully',                NULL,         'Pune',   '₹50L-1Cr',   '2026-06-20 09:00:00'),
('Pooja Mehta',    'LTIMindtree',        '9321098765', 'pooja@ltimindtree.com',    'Email',     'New',         'Sneha Verma', 'Awaiting initial contact',                '2026-06-28', 'Mumbai', '< ₹25L',     '2026-06-19 14:00:00'),
('Vikram Singh',   'Cognizant',          '9210987654', 'vikram@cognizant.com',     'Referral',  'Lost',        'Karan Mehta', 'Went with competitor',                    NULL,         'Mumbai', '₹50L-1Cr',   '2026-06-18 10:00:00'),
('Aditya Verma',   'Persistent Systems', '9109876543', 'aditya@persistent.com',    'Website',   'In Progress', 'Rohit Patil', 'Demo scheduled for next period',            '2026-06-30', 'Pune',   '₹25L-50L',   '2026-06-17 15:00:00'),
('Sunita Nair',    'Infosys BPM',        '8998765432', 'sunita@infosysbpm.com',    'Social',    'Qualified',   'Sneha Verma', 'High value prospect',                     '2026-06-29', 'Nashik', '> ₹1Cr',     '2026-06-16 11:00:00'),
('Manoj Sharma',   'Capgemini',          '8887654321', 'manoj@capgemini.com',      'Cold Call', 'Follow-up',   'Karan Mehta', 'Requested product brochure',              '2026-06-26', 'Pune',   '< ₹25L',     '2026-06-15 16:00:00'),
('Kavita Desai',   'Accenture',          '8776543210', 'kavita@accenture.com',     'Website',   'New',         'Sneha Verma', 'New inquiry via contact form',            '2026-06-27', 'Mumbai', '₹25L-50L',   '2026-06-14 09:00:00'),
('Rajan Pillai',   'L&T Infotech',       '8665432109', 'rajan@lnt.com',            'Exhibition','Converted',   'Rohit Patil', 'Met at Tech Summit 2026',                 NULL,         'Aurangabad','₹50L-1Cr', '2026-06-13 14:00:00')
ON DUPLICATE KEY UPDATE status = VALUES(status);

-- ============================================================
-- SEED DATA: activity_logs
-- ============================================================
INSERT INTO activity_logs (activity, lead_name, company, user_name, notes, logged_at) VALUES
('Lead Created',       'Rajesh Patil',  'Tata Motors',        'Sneha Verma',  'Lead added via website form',         '2026-06-24 10:05:00'),
('Lead Assigned',      'Priya Joshi',   'Infosys',            'Akash Sharma', 'Assigned to Rohit Patil',             '2026-06-24 10:12:00'),
('Lead Updated',       'Amit Deshmukh', 'Wipro',              'Sneha Verma',  'Status changed: New → Qualified',     '2026-06-24 10:30:00'),
('Follow-up Added',    'Neha Kulkarni', 'HCL Technologies',   'Karan Mehta',  'Follow-up scheduled for 25 Jun',      '2026-06-24 11:00:00'),
('Lead Converted',     'Rohit Jadhav',  'Tech Mahindra',      'Rohit Patil',  'Deal closed — ₹8,50,000',            '2026-06-24 11:45:00'),
('Lead Created',       'Pooja Mehta',   'LTIMindtree',        'Sneha Verma',  'Lead added via cold call',            '2026-06-23 09:15:00'),
('Lead Updated',       'Vikram Singh',  'Cognizant',          'Karan Mehta',  'Status changed: In Progress → Lost',  '2026-06-23 10:00:00'),
('Lead Assigned',      'Aditya Verma',  'Persistent Systems', 'Akash Sharma', 'Assigned to Rohit Patil',             '2026-06-23 11:30:00'),
('Follow-up Added',    'Sunita Nair',   'Infosys BPM',        'Sneha Verma',  'Follow-up call completed',            '2026-06-22 14:00:00'),
('Lead Converted',     'Rajan Pillai',  'L&T Infotech',       'Rohit Patil',  'Deal closed — ₹12,20,000',           '2026-06-22 15:30:00'),
('Lead Created',       'Kavita Desai',  'Accenture',          'Karan Mehta',  'Lead added via referral',             '2026-06-21 09:00:00'),
('Lead Updated',       'Manoj Sharma',  'Capgemini',          'Sneha Verma',  'Remarks updated',                     '2026-06-20 16:00:00');

-- ============================================================
-- USEFUL VIEWS
-- ============================================================

-- View: Lead conversion summary by status
CREATE OR REPLACE VIEW v_lead_status_summary AS
SELECT
    status,
    COUNT(*) AS total,
    ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM leads), 1) AS percentage
FROM leads
GROUP BY status;

-- View: Sales team performance
CREATE OR REPLACE VIEW v_team_performance AS
SELECT
    assigned_to,
    COUNT(*)                                   AS total_leads,
    SUM(status = 'Converted')                  AS converted,
    SUM(status = 'Lost')                       AS lost,
    SUM(status NOT IN ('Converted','Lost'))    AS active,
    ROUND(SUM(status = 'Converted') * 100.0 / COUNT(*), 1) AS conversion_rate
FROM leads
WHERE assigned_to IS NOT NULL
GROUP BY assigned_to;
