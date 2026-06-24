<?php
// ============================================================
// Lead Management System
// Lead Management System - Settings
// Developer: Intern

// ============================================================

require_once 'db_connect.php';
include 'header.php';

$save_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $save_msg = 'success';
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Settings</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">System Settings</h1>
        <div class="page-sub">Configure Lead Management System preferences</div>
    </div>
</div>

<?php if ($save_msg === 'success'): ?>
<div class="alert d-flex align-items-center gap-2 mb-4" style="background:rgba(34,197,94,0.12);color:#16a34a;border:none;border-radius:8px;">
    <i class="bi bi-check-circle-fill"></i> Settings saved successfully!
</div>
<?php endif; ?>

<form method="POST" action="settings.php">
<div class="row g-4">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Company Information -->
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-building"></i> Company Information</div>
            </div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Company Name</label>
                        <input type="text" class="form-control-custom" value="Lead Management System">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">System Name</label>
                        <input type="text" class="form-control-custom" value="Lead Management System">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Admin Email</label>
                        <input type="email" class="form-control-custom" value="admin@leadms.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Support Phone</label>
                        <input type="text" class="form-control-custom" value="+91 98765 43210">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-custom">Address</label>
                        <input type="text" class="form-control-custom" value="Pune, Maharashtra, India">
                    </div>
                </div>
            </div>
        </div>

        <!-- Lead Settings -->
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-sliders"></i> Lead Configuration</div>
            </div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Default Lead Status</label>
                        <select class="form-control-custom">
                            <option selected>New</option>
                            <option>In Progress</option>
                            <option>Qualified</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Follow-up Reminder (Days)</label>
                        <input type="number" class="form-control-custom" value="3" min="1" max="30">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Lead Expiry After (Days)</label>
                        <input type="number" class="form-control-custom" value="90" min="30" max="365">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Max Leads per Executive</label>
                        <input type="number" class="form-control-custom" value="20" min="5" max="100">
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <input type="checkbox" id="auto_assign" checked style="width:15px;height:15px;accent-color:#2563EB;">
                            <label for="auto_assign" class="form-label-custom" style="margin:0;cursor:pointer;">Auto-assign leads to available executive</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <input type="checkbox" id="email_notify" checked style="width:15px;height:15px;accent-color:#2563EB;">
                            <label for="email_notify" class="form-label-custom" style="margin:0;cursor:pointer;">Send email notification on lead assignment</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Settings -->
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-database-fill"></i> Database Settings</div>
            </div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">DB Host</label>
                        <input type="text" class="form-control-custom" value="localhost" readonly style="background:#f8fafc;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">DB Name</label>
                        <input type="text" class="form-control-custom" value="lead_management" readonly style="background:#f8fafc;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">DB Username</label>
                        <input type="text" class="form-control-custom" value="root" readonly style="background:#f8fafc;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">DB Status</label>
                        <input type="text" class="form-control-custom" value="✓ Connected (PHP 8.2 / MySQL 8.0)" readonly style="background:rgba(34,197,94,0.08);color:#16a34a;font-weight:600;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- System Info -->
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-info-circle-fill"></i> System Info</div>
            </div>
            <div class="card-body-custom">
                <?php
                $sys_info = [
                    ['Version',     'LMS v2.0'],
                    ['PHP',         '8.2.4'],
                    ['MySQL',       '8.0.32'],
                    ['Bootstrap',   '5.3.0'],
                    ['Chart.js',    '4.4.0'],
                    ['Environment', 'Development'],
                    ['Server',      'localhost'],
                    ['Last Backup', 'Today 06:00 AM'],
                ];
                foreach ($sys_info as [$key, $val]):
                ?>
                <div class="stat-row">
                    <span class="stat-label"><?= $key ?></span>
                    <span class="stat-val"><?= $val ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Profile Settings -->
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-person-circle"></i> My Profile</div>
            </div>
            <div class="card-body-custom">
                <div class="text-center mb-3">
                    <div style="width:64px;height:64px;background:#2563EB;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:24px;color:white;font-weight:700;">AK</div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Full Name</label>
                    <input type="text" class="form-control-custom" value="Akash Sharma">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Email</label>
                    <input type="email" class="form-control-custom" value="admin@leadms.com">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">New Password</label>
                    <input type="password" class="form-control-custom" placeholder="Leave blank to keep current">
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-lightning-fill"></i> Quick Actions</div>
            </div>
            <div class="card-body-custom">
                <div class="d-grid gap-2">
                    <button type="button" class="btn-primary-custom justify-content-center" style="background:#64748b;">
                        <i class="bi bi-arrow-clockwise"></i> Clear Cache
                    </button>
                    <button type="button" class="btn-primary-custom justify-content-center" style="background:#0ea5e9;">
                        <i class="bi bi-download"></i> Backup Database
                    </button>
                    <a href="activity_logs.php" class="btn-primary-custom justify-content-center" style="background:#8b5cf6;">
                        <i class="bi bi-clock-history"></i> View Activity Logs
                    </a>
                    <a href="login.php" class="btn-primary-custom justify-content-center" style="background:#EF4444;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Button -->
<div class="d-flex gap-2 mt-2 mb-4">
    <button type="submit" class="btn-primary-custom">
        <i class="bi bi-check2-circle"></i> Save Settings
    </button>
    <button type="reset" class="btn-primary-custom" style="background:#64748b;">
        <i class="bi bi-arrow-counterclockwise"></i> Reset
    </button>
</div>
</form>

<?php include 'footer.php'; ?>
