<?php
// ============================================================
// Lead Management System
// Lead Management System - Header Partial
// Developer: Intern

// ============================================================

// Determine current page for active nav state
$current_page = basename($_SERVER['PHP_SELF']);

// Page titles mapping
$page_titles = [
    'dashboard.php'       => 'Dashboard',
    'add_lead.php'        => 'Add New Lead',
    'lead_status.php'     => 'Lead Status',
    'sales_analytics.php' => 'Sales Analytics',
    'reports.php'         => 'Reports',
    'login.php'           => 'Login',
    'users.php'           => 'User Management',
    'activity_logs.php'   => 'Activity Logs',
    'settings.php'        => 'Settings',
];
$page_title = $page_titles[$current_page] ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lead Management System - Lead Management System">
    <title><?= htmlspecialchars($page_title) ?> | Lead Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php if ($current_page !== 'login.php'): ?>
<!-- ======================================================
     SIDEBAR
     ====================================================== -->
<nav id="sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-diagram-3-fill"></i>
        </div>
        <div class="brand-text">
            <span class="brand-name">LeadMS</span>
            <span class="brand-sub">Lead Management</span>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="sidebar-section-label">Main Menu</div>
    <ul class="sidebar-nav">
        <li>
            <a href="dashboard.php" class="<?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="add_lead.php" class="<?= $current_page === 'add_lead.php' ? 'active' : '' ?>">
                <i class="bi bi-person-plus-fill"></i>
                Add New Lead
            </a>
        </li>
        <li>
            <a href="lead_status.php" class="<?= $current_page === 'lead_status.php' ? 'active' : '' ?>">
                <i class="bi bi-kanban-fill"></i>
                Lead Status
                <span class="nav-badge">6</span>
            </a>
        </li>
    </ul>

    <!-- Analytics Navigation -->
    <div class="sidebar-section-label">Analytics</div>
    <ul class="sidebar-nav">
        <li>
            <a href="sales_analytics.php" class="<?= $current_page === 'sales_analytics.php' ? 'active' : '' ?>">
                <i class="bi bi-bar-chart-fill"></i>
                Sales Analytics
            </a>
        </li>
        <li>
            <a href="reports.php" class="<?= $current_page === 'reports.php' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                Reports
            </a>
        </li>
    </ul>

    <!-- Admin Navigation -->
    <div class="sidebar-section-label">Administration</div>
    <ul class="sidebar-nav">
        <li>
            <a href="users.php" class="<?= $current_page === 'users.php' ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i>
                User Management
            </a>
        </li>
        <li>
            <a href="activity_logs.php" class="<?= $current_page === 'activity_logs.php' ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i>
                Activity Logs
            </a>
        </li>
        <li>
            <a href="settings.php" class="<?= $current_page === 'settings.php' ? 'active' : '' ?>">
                <i class="bi bi-gear-fill"></i>
                Settings
            </a>
        </li>
    </ul>

    <!-- Sidebar User Profile -->
    <div class="sidebar-user">
        <div class="user-avatar">AK</div>
        <div class="user-info">
            <div class="user-name">Akash Sharma</div>
            <div class="user-role">Administrator</div>
        </div>
    </div>
</nav><!-- /#sidebar -->

<!-- ======================================================
     MAIN CONTENT
     ====================================================== -->
<div id="main-content">
    <!-- Top Bar -->
    <div class="topbar">
        <div class="page-title">
            <i class="bi bi-<?=
                match($current_page) {
                    'dashboard.php'       => 'grid-1x2',
                    'add_lead.php'        => 'person-plus',
                    'lead_status.php'     => 'kanban',
                    'sales_analytics.php' => 'bar-chart',
                    'reports.php'         => 'file-earmark-bar-graph',
                    'users.php'           => 'people',
                    'activity_logs.php'   => 'clock-history',
                    'settings.php'        => 'gear',
                    default               => 'grid-1x2'
                }
            ?>" style="margin-right:8px; color:#2563EB;"></i>
            <?= htmlspecialchars($page_title) ?>
        </div>
        <div class="topbar-right">
            <span class="topbar-date">
                <i class="bi bi-calendar3 me-1"></i>
                <?= date('D, d M Y') ?>
            </span>
            <div class="position-relative">
                <a href="#" class="text-muted me-2" title="Notifications">
                    <i class="bi bi-bell" style="font-size:16px;"></i>
                    <span style="position:absolute;top:-3px;right:6px;width:8px;height:8px;background:var(--danger);border-radius:50%;"></span>
                </a>
            </div>
            <div class="topbar-avatar" title="Akash Sharma - Admin">AK</div>
        </div>
    </div>
    <!-- Page Content Starts -->
    <div class="page-content">
<?php endif; ?>
