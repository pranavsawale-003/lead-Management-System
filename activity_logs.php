<?php
// ============================================================
// Lead Management System
// Lead Management System - Activity Logs
// Developer: Intern
// 
// ============================================================

require_once 'db_connect.php';
include 'header.php';

// Activity log entries
$activity_logs = [
    ['id' => 1,  'activity' => 'Lead Created',         'lead' => 'Rajesh Patil',    'company' => 'Tata Motors',        'user' => 'Sneha Verma',  'date' => '24 Jun 2026', 'time' => '10:05 AM', 'type' => 'created',   'note' => 'Lead added via website form'],
    ['id' => 2,  'activity' => 'Lead Assigned',         'lead' => 'Priya Joshi',     'company' => 'Infosys',            'user' => 'Akash Sharma', 'date' => '24 Jun 2026', 'time' => '10:12 AM', 'type' => 'assigned',  'note' => 'Assigned to Rohit Patil'],
    ['id' => 3,  'activity' => 'Lead Updated',          'lead' => 'Amit Deshmukh',   'company' => 'Wipro',              'user' => 'Sneha Verma',  'date' => '24 Jun 2026', 'time' => '10:30 AM', 'type' => 'updated',   'note' => 'Status changed: New → Qualified'],
    ['id' => 4,  'activity' => 'Follow-up Added',       'lead' => 'Neha Kulkarni',   'company' => 'HCL Technologies',   'user' => 'Karan Mehta',  'date' => '24 Jun 2026', 'time' => '11:00 AM', 'type' => 'followup',  'note' => 'Follow-up scheduled for 25 Jun'],
    ['id' => 5,  'activity' => 'Lead Converted',        'lead' => 'Rohit Jadhav',    'company' => 'Tech Mahindra',      'user' => 'Rohit Patil',  'date' => '24 Jun 2026', 'time' => '11:45 AM', 'type' => 'converted', 'note' => 'Deal closed — ₹8,50,000'],
    ['id' => 6,  'activity' => 'Lead Created',          'lead' => 'Pooja Mehta',     'company' => 'LTIMindtree',        'user' => 'Sneha Verma',  'date' => '23 Jun 2026', 'time' => '09:15 AM', 'type' => 'created',   'note' => 'Lead added via cold call'],
    ['id' => 7,  'activity' => 'Lead Updated',          'lead' => 'Vikram Singh',    'company' => 'Cognizant',          'user' => 'Karan Mehta',  'date' => '23 Jun 2026', 'time' => '10:00 AM', 'type' => 'updated',   'note' => 'Status changed: In Progress → Lost'],
    ['id' => 8,  'activity' => 'Lead Assigned',         'lead' => 'Aditya Verma',    'company' => 'Persistent Systems', 'user' => 'Akash Sharma', 'date' => '23 Jun 2026', 'time' => '11:30 AM', 'type' => 'assigned',  'note' => 'Assigned to Rohit Patil'],
    ['id' => 9,  'activity' => 'Follow-up Added',       'lead' => 'Sunita Nair',     'company' => 'Infosys BPM',        'user' => 'Sneha Verma',  'date' => '22 Jun 2026', 'time' => '02:00 PM', 'type' => 'followup',  'note' => 'Follow-up call completed'],
    ['id' => 10, 'activity' => 'Lead Converted',        'lead' => 'Rajan Pillai',    'company' => 'L&T Infotech',       'user' => 'Rohit Patil',  'date' => '22 Jun 2026', 'time' => '03:30 PM', 'type' => 'converted', 'note' => 'Deal closed — ₹12,20,000'],
    ['id' => 11, 'activity' => 'Lead Created',          'lead' => 'Kavita Desai',    'company' => 'Accenture',          'user' => 'Karan Mehta',  'date' => '21 Jun 2026', 'time' => '09:00 AM', 'type' => 'created',   'note' => 'Lead added via referral'],
    ['id' => 12, 'activity' => 'Lead Updated',          'lead' => 'Manoj Sharma',    'company' => 'Capgemini',          'user' => 'Sneha Verma',  'date' => '20 Jun 2026', 'time' => '04:00 PM', 'type' => 'updated',   'note' => 'Remarks updated'],
];

// Activity type config
$activity_config = [
    'created'   => ['icon' => 'bi-person-plus-fill',     'class' => 'icon-primary',  'badge' => 'badge-new'],
    'assigned'  => ['icon' => 'bi-arrow-right-circle-fill','class'=> 'icon-info',     'badge' => 'badge-qualified'],
    'updated'   => ['icon' => 'bi-pencil-fill',           'class' => 'icon-warning',  'badge' => 'badge-progress'],
    'followup'  => ['icon' => 'bi-telephone-fill',        'class' => 'icon-purple',   'badge' => 'badge-followup'],
    'converted' => ['icon' => 'bi-check-circle-fill',     'class' => 'icon-success',  'badge' => 'badge-converted'],
];

// Filter
$filter_type = $_GET['type'] ?? '';
$filter_user = $_GET['user'] ?? '';

$logs = $activity_logs;
if ($filter_type) {
    $logs = array_filter($logs, fn($l) => $l['type'] === $filter_type);
}
if ($filter_user) {
    $logs = array_filter($logs, fn($l) => $l['user'] === $filter_user);
}

// Counts
$type_counts = [];
foreach ($activity_logs as $l) {
    $type_counts[$l['type']] = ($type_counts[$l['type']] ?? 0) + 1;
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Activity Logs</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">Activity Logs</h1>
        <div class="page-sub">Track all system actions and user activities</div>
    </div>
    <a href="activity_logs.php?export=1" class="btn-success-custom">
        <i class="bi bi-download"></i> Export Logs
    </a>
</div>

<!-- Activity Summary Cards -->
<div class="row g-3 mb-4">
    <?php
    $summary_items = [
        ['type' => 'created',   'label' => 'Lead Created',      'icon-cls' => 'icon-primary',  'icon' => 'bi-person-plus-fill'],
        ['type' => 'assigned',  'label' => 'Lead Assigned',     'icon-cls' => 'icon-info',     'icon' => 'bi-arrow-right-circle-fill'],
        ['type' => 'updated',   'label' => 'Lead Updated',      'icon-cls' => 'icon-warning',  'icon' => 'bi-pencil-fill'],
        ['type' => 'followup',  'label' => 'Follow-up Added',   'icon-cls' => 'icon-purple',   'icon' => 'bi-telephone-fill'],
        ['type' => 'converted', 'label' => 'Lead Converted',    'icon-cls' => 'icon-success',  'icon' => 'bi-check-circle-fill'],
    ];
    foreach ($summary_items as $si):
    ?>
    <div class="col">
        <a href="?type=<?= $si['type'] ?>" style="text-decoration:none;">
            <div class="kpi-card" style="<?= $filter_type === $si['type'] ? 'border:2px solid #2563EB;' : '' ?>">
                <div class="kpi-icon <?= $si['icon-cls'] ?>"><i class="bi <?= $si['icon'] ?>"></i></div>
                <div class="kpi-data">
                    <div class="kpi-value"><?= $type_counts[$si['type']] ?? 0 ?></div>
                    <div class="kpi-label"><?= $si['label'] ?></div>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Filters -->
<div class="section-card mb-4">
    <div class="card-body-custom">
        <form method="GET" class="d-flex gap-3 align-items-end flex-wrap">
            <div>
                <label class="form-label-custom">Activity Type</label>
                <select name="type" class="form-control-custom" style="width:180px;">
                    <option value="">All Activities</option>
                    <option value="created"   <?= $filter_type === 'created'   ? 'selected' : '' ?>>Lead Created</option>
                    <option value="assigned"  <?= $filter_type === 'assigned'  ? 'selected' : '' ?>>Lead Assigned</option>
                    <option value="updated"   <?= $filter_type === 'updated'   ? 'selected' : '' ?>>Lead Updated</option>
                    <option value="followup"  <?= $filter_type === 'followup'  ? 'selected' : '' ?>>Follow-up Added</option>
                    <option value="converted" <?= $filter_type === 'converted' ? 'selected' : '' ?>>Lead Converted</option>
                </select>
            </div>
            <div>
                <label class="form-label-custom">User</label>
                <select name="user" class="form-control-custom" style="width:180px;">
                    <option value="">All Users</option>
                    <option value="Akash Sharma"  <?= $filter_user === 'Akash Sharma'  ? 'selected' : '' ?>>Akash Sharma</option>
                    <option value="Sneha Verma"   <?= $filter_user === 'Sneha Verma'   ? 'selected' : '' ?>>Sneha Verma</option>
                    <option value="Rohit Patil"   <?= $filter_user === 'Rohit Patil'   ? 'selected' : '' ?>>Rohit Patil</option>
                    <option value="Karan Mehta"   <?= $filter_user === 'Karan Mehta'   ? 'selected' : '' ?>>Karan Mehta</option>
                </select>
            </div>
            <div>
                <label class="form-label-custom">Date From</label>
                <input type="date" name="date_from" class="form-control-custom" style="width:160px;" value="2026-06-20">
            </div>
            <div>
                <label class="form-label-custom">Date To</label>
                <input type="date" name="date_to" class="form-control-custom" style="width:160px;" value="2026-06-24">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary-custom">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="activity_logs.php" class="btn-primary-custom" style="background:#64748b;">
                    <i class="bi bi-x-lg"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Activity Log Table -->
<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title">
            <i class="bi bi-clock-history"></i> Activity Log
            <span class="status-badge badge-new"><?= count($logs) ?> records</span>
        </div>
        <span class="fs-12 text-muted">Showing <?= count($logs) ?> of <?= count($activity_logs) ?> entries</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="lms-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Activity</th>
                    <th>Lead Name</th>
                    <th>Company</th>
                    <th>Notes</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log):
                    $cfg = $activity_config[$log['type']];
                ?>
                <tr>
                    <td class="text-muted fs-12"><?= $log['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="activity-icon <?= $cfg['class'] ?>">
                                <i class="bi <?= $cfg['icon'] ?>"></i>
                            </div>
                            <span class="status-badge <?= $cfg['badge'] ?>"><?= htmlspecialchars($log['activity']) ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:26px;height:26px;background:rgba(37,99,235,0.10);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#2563EB;flex-shrink:0;">
                                <?= strtoupper(substr($log['lead'], 0, 1)) ?>
                            </div>
                            <span class="fw-600"><?= htmlspecialchars($log['lead']) ?></span>
                        </div>
                    </td>
                    <td class="text-muted fs-13"><?= htmlspecialchars($log['company']) ?></td>
                    <td class="fs-12 text-muted"><?= htmlspecialchars($log['note']) ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:24px;height:24px;background:rgba(37,99,235,0.10);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#2563EB;">
                                <?= strtoupper(substr($log['user'], 0, 1)) ?>
                            </div>
                            <span class="fs-13"><?= htmlspecialchars($log['user']) ?></span>
                        </div>
                    </td>
                    <td class="text-muted fs-12"><?= $log['date'] ?></td>
                    <td>
                        <span class="fs-12" style="color:#2563EB;">
                            <i class="bi bi-clock me-1"></i><?= $log['time'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($logs)): ?>
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        No activity logs found for the selected filters.
                        <a href="activity_logs.php">Clear filters</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 20px;border-top:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
        <span class="fs-12 text-muted">Showing 1 to <?= count($logs) ?> of <?= count($logs) ?> entries</span>
        <div class="d-flex gap-2">
            <button class="btn-sm-action btn-view" disabled>Previous</button>
            <button class="btn-sm-action" style="background:var(--primary);color:white;padding:4px 12px;">1</button>
            <button class="btn-sm-action btn-view">Next</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
