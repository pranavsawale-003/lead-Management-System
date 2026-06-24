<?php
// ============================================================
// Lead Management System
// Lead Management System - Dashboard
// Developer: Intern


// ============================================================

require_once 'db_connect.php';
include 'header.php';

// ---- Sample Data (would come from DB in production) --------
$kpi_data = [
    'total_leads'        => 38,
    'new_leads'          => 9,
    'warm_leads'         => 18,
    'visits_booked'      => 8,
    'followups_pending'  => 6,
    'conversion_rate'    => 21,
];

// Today's Follow-Ups
$todays_followups = [
    ['name' => 'Rajesh Patil',    'company' => 'Tata Motors',           'mobile' => '9876543210', 'time' => '10:00 AM', 'assigned' => 'Sneha Verma'],
    ['name' => 'Priya Joshi',     'company' => 'Infosys',               'mobile' => '9765432109', 'time' => '11:30 AM', 'assigned' => 'Rohit Patil'],
    ['name' => 'Amit Deshmukh',   'company' => 'Wipro',                 'mobile' => '9654321098', 'time' => '02:00 PM', 'assigned' => 'Sneha Verma'],
    ['name' => 'Neha Kulkarni',   'company' => 'HCL Technologies',      'mobile' => '9543210987', 'time' => '03:30 PM', 'assigned' => 'Karan Mehta'],
    ['name' => 'Rohit Jadhav',    'company' => 'Tech Mahindra',         'mobile' => '9432109876', 'time' => '04:00 PM', 'assigned' => 'Rohit Patil'],
];

// Recent Leads
$recent_leads = [
    ['id' => 1, 'name' => 'Rajesh Patil',    'company' => 'Tata Motors',        'source' => 'Website',  'status' => 'New',         'date' => '24 Jun 2026', 'assigned' => 'Sneha Verma'],
    ['id' => 2, 'name' => 'Priya Joshi',     'company' => 'Infosys',            'source' => 'Referral', 'status' => 'In Progress', 'date' => '23 Jun 2026', 'assigned' => 'Rohit Patil'],
    ['id' => 3, 'name' => 'Amit Deshmukh',   'company' => 'Wipro',              'source' => 'Walk-in',  'status' => 'Qualified',   'date' => '22 Jun 2026', 'assigned' => 'Sneha Verma'],
    ['id' => 4, 'name' => 'Neha Kulkarni',   'company' => 'HCL Technologies',   'source' => 'Website',  'status' => 'Follow-up',   'date' => '21 Jun 2026', 'assigned' => 'Karan Mehta'],
    ['id' => 5, 'name' => 'Rohit Jadhav',    'company' => 'Tech Mahindra',      'source' => 'Cold Call','status' => 'Converted',   'date' => '20 Jun 2026', 'assigned' => 'Rohit Patil'],
    ['id' => 6, 'name' => 'Pooja Mehta',     'company' => 'LTIMindtree',        'source' => 'Email',    'status' => 'New',         'date' => '19 Jun 2026', 'assigned' => 'Sneha Verma'],
    ['id' => 7, 'name' => 'Vikram Singh',    'company' => 'Cognizant',          'source' => 'Referral', 'status' => 'Lost',        'date' => '18 Jun 2026', 'assigned' => 'Karan Mehta'],
    ['id' => 8, 'name' => 'Aditya Verma',    'company' => 'Persistent Systems', 'source' => 'Website',  'status' => 'In Progress', 'date' => '17 Jun 2026', 'assigned' => 'Rohit Patil'],
];

// Sales Team Performance
$team_performance = [
    ['name' => 'Sneha Verma',  'role' => 'Sales Executive', 'assigned' => 15, 'converted' => 4, 'pending' => 11],
    ['name' => 'Rohit Patil',  'role' => 'Team Lead',       'assigned' => 12, 'converted' => 5, 'pending' => 7],
    ['name' => 'Karan Mehta',  'role' => 'Sales Executive', 'assigned' => 11, 'converted' => 3, 'pending' => 8],
];

// Status badge helper
function statusBadge($status) {
    $map = [
        'New'         => 'badge-new',
        'In Progress' => 'badge-progress',
        'Qualified'   => 'badge-qualified',
        'Follow-up'   => 'badge-followup',
        'Converted'   => 'badge-converted',
        'Lost'        => 'badge-lost',
        'Warm'        => 'badge-warm',
    ];
    $cls = $map[$status] ?? 'badge-new';
    return "<span class=\"status-badge $cls\">$status</span>";
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <span>Home</span>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Dashboard</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">Dashboard Overview</h1>
        <div class="page-sub">Welcome back, Akash! Here's what's happening today.</div>
    </div>
    <div class="d-flex gap-2">
        <a href="add_lead.php" class="btn-primary-custom">
            <i class="bi bi-plus-lg"></i> Add New Lead
        </a>
    </div>
</div>

<!-- ============================================================
     ROW 1 — KPI CARDS (
     ============================================================ -->
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-primary"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $kpi_data['total_leads'] ?></div>
                <div class="kpi-label">Total Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+4 this period</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-info"><i class="bi bi-person-plus-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $kpi_data['new_leads'] ?></div>
                <div class="kpi-label">New Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+2 today</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-warning"><i class="bi bi-fire"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $kpi_data['warm_leads'] ?></div>
                <div class="kpi-label">Warm Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+3 this period</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-purple"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $kpi_data['visits_booked'] ?></div>
                <div class="kpi-label">Visits Booked</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+1 today</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-danger"><i class="bi bi-alarm-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $kpi_data['followups_pending'] ?></div>
                <div class="kpi-label">Follow Ups Pending</div>
                <div class="kpi-trend down"><i class="bi bi-exclamation-circle-fill"></i> Due today</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-success"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $kpi_data['conversion_rate'] ?>%</div>
                <div class="kpi-label">Conversion Rate</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+2% vs last month</div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     ROW 2 — CHARTS (
     ============================================================ -->
<div class="row g-3 mb-4">
    <!-- Leads by Type -->
    <div class="col-lg-3 col-md-6">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-pie-chart-fill"></i> Leads by Type</div>
            </div>
            <div class="card-body-custom">
                <div class="chart-wrapper" style="height:200px;">
                    <canvas id="leadsByTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Leads by Status -->
    <div class="col-lg-5 col-md-6">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-bar-chart-fill"></i> Leads by Status</div>
            </div>
            <div class="card-body-custom">
                <div class="chart-wrapper" style="height:200px;">
                    <canvas id="leadsByStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Wise Demand -->
    <div class="col-lg-4 col-md-6">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-map-fill"></i> Area Wise Demand</div>
            </div>
            <div class="card-body-custom">
                <div class="chart-wrapper" style="height:200px;">
                    <canvas id="areaWiseChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Budget Distribution -->
    <div class="col-lg-4 col-md-6">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-currency-rupee"></i> Budget Distribution</div>
            </div>
            <div class="card-body-custom">
                <div class="chart-wrapper" style="height:200px;">
                    <canvas id="budgetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Team Performance -->
    <div class="col-lg-8 col-md-6">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-trophy-fill"></i> Sales Team Performance</div>
                <span class="fs-12 text-muted">This Month</span>
            </div>
            <div class="card-body-custom p-0">
                <table class="lms-table">
                    <thead>
                        <tr>
                            <th>Sales Person</th>
                            <th>Role</th>
                            <th>Assigned</th>
                            <th>Converted</th>
                            <th>Pending</th>
                            <th>Conversion %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($team_performance as $member): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:30px;height:30px;background:rgba(37,99,235,0.12);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#2563EB;">
                                        <?= strtoupper(substr($member['name'], 0, 1)) ?>
                                    </div>
                                    <span class="fw-600"><?= htmlspecialchars($member['name']) ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= htmlspecialchars($member['role']) ?></td>
                            <td><strong><?= $member['assigned'] ?></strong></td>
                            <td><span style="color:#22C55E;font-weight:600;"><?= $member['converted'] ?></span></td>
                            <td><span style="color:#F59E0B;font-weight:600;"><?= $member['pending'] ?></span></td>
                            <td>
                                <?php $pct = round(($member['converted'] / $member['assigned']) * 100); ?>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress-custom flex-grow-1">
                                        <div class="progress-bar-custom" style="width:<?= $pct ?>%;background:#22C55E;"></div>
                                    </div>
                                    <span class="fs-12 fw-600"><?= $pct ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     ROW 3 — TABLES (
     ============================================================ -->
<div class="row g-3 mb-4">
    <!-- Today's Follow Ups -->
    <div class="col-lg-5">
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-alarm-fill"></i> Today's Follow Ups</div>
                <span class="status-badge badge-danger" style="background:rgba(239,68,68,0.1);color:#dc2626;">
                    <?= count($todays_followups) ?> Pending
                </span>
            </div>
            <div class="card-body-custom p-0">
                <table class="lms-table">
                    <thead>
                        <tr>
                            <th>Lead Name</th>
                            <th>Company</th>
                            <th>Time</th>
                            <th>Assigned To</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todays_followups as $fu): ?>
                        <tr>
                            <td>
                                <span class="fw-600"><?= htmlspecialchars($fu['name']) ?></span><br>
                                <span class="fs-12 text-muted"><?= $fu['mobile'] ?></span>
                            </td>
                            <td class="text-muted"><?= htmlspecialchars($fu['company']) ?></td>
                            <td>
                                <span class="status-badge" style="background:rgba(245,158,11,0.12);color:#d97706;">
                                    <i class="bi bi-clock-fill"></i> <?= $fu['time'] ?>
                                </span>
                            </td>
                            <td class="text-muted fs-12"><?= htmlspecialchars($fu['assigned']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Leads -->
    <div class="col-lg-7">
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-person-lines-fill"></i> Recent Leads</div>
                <a href="lead_status.php" class="fs-12" style="color:#2563EB;">View All</a>
            </div>
            <div class="card-body-custom p-0">
                <table class="lms-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lead Name</th>
                            <th>Company</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_leads as $lead): ?>
                        <tr>
                            <td class="text-muted fs-12"><?= $lead['id'] ?></td>
                            <td>
                                <span class="fw-600"><?= htmlspecialchars($lead['name']) ?></span>
                            </td>
                            <td class="text-muted fs-12"><?= htmlspecialchars($lead['company']) ?></td>
                            <td class="text-muted fs-12"><?= htmlspecialchars($lead['source']) ?></td>
                            <td><?= statusBadge($lead['status']) ?></td>
                            <td class="text-muted fs-12"><?= $lead['date'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     ROW 4 — 
     Recent Activity | User Summary | System Status
     ============================================================ -->
<div class="row g-3">
    <!-- Recent Activity Widget (
    <div class="col-lg-4">
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-activity"></i> Recent Activity</div>
                <a href="activity_logs.php" class="fs-12" style="color:#2563EB;">View Logs</a>
            </div>
            <div class="card-body-custom">
                <?php
                $activities = [
                    ['type' => 'created',  'lead' => 'Rajesh Patil',  'user' => 'Sneha Verma',  'time' => '10 min ago',  'icon' => 'bi-person-plus-fill',  'color' => 'icon-primary'],
                    ['type' => 'assigned', 'lead' => 'Priya Joshi',   'user' => 'Rohit Patil',  'time' => '25 min ago',  'icon' => 'bi-arrow-right-circle-fill', 'color' => 'icon-info'],
                    ['type' => 'updated',  'lead' => 'Amit Deshmukh', 'user' => 'Sneha Verma',  'time' => '1 hr ago',    'icon' => 'bi-pencil-fill',       'color' => 'icon-warning'],
                    ['type' => 'followup', 'lead' => 'Neha Kulkarni', 'user' => 'Karan Mehta',  'time' => '2 hrs ago',   'icon' => 'bi-telephone-fill',    'color' => 'icon-purple'],
                    ['type' => 'converted','lead' => 'Rohit Jadhav',  'user' => 'Rohit Patil',  'time' => '3 hrs ago',   'icon' => 'bi-check-circle-fill', 'color' => 'icon-success'],
                ];
                $activity_labels = [
                    'created'  => 'Lead Created',
                    'assigned' => 'Lead Assigned',
                    'updated'  => 'Lead Updated',
                    'followup' => 'Follow-up Added',
                    'converted'=> 'Lead Converted',
                ];
                foreach ($activities as $act): ?>
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="activity-icon <?= $act['color'] ?>">
                        <i class="bi <?= $act['icon'] ?>"></i>
                    </div>
                    <div style="flex:1;">
                        <div class="fw-600 fs-13"><?= $activity_labels[$act['type']] ?></div>
                        <div class="fs-12 text-muted"><?= htmlspecialchars($act['lead']) ?> • <?= htmlspecialchars($act['user']) ?></div>
                        <div class="fs-12" style="color:#94a3b8;"><?= $act['time'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- User Summary Widget (
    <div class="col-lg-4">
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-people-fill"></i> User Summary</div>
                <a href="users.php" class="fs-12" style="color:#2563EB;">Manage Users</a>
            </div>
            <div class="card-body-custom">
                <?php
                $users_summary = [
                    ['name' => 'Akash Sharma',  'role' => 'Admin',          'status' => 'Active', 'leads' => 0,  'badge' => 'badge-admin'],
                    ['name' => 'Sneha Verma',   'role' => 'Sales Executive', 'status' => 'Active', 'leads' => 15, 'badge' => 'badge-sales'],
                    ['name' => 'Rohit Patil',   'role' => 'Team Lead',       'status' => 'Active', 'leads' => 12, 'badge' => 'badge-teamlead'],
                    ['name' => 'Karan Mehta',   'role' => 'Sales Executive', 'status' => 'Active', 'leads' => 11, 'badge' => 'badge-sales'],
                ];
                foreach ($users_summary as $usr): ?>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:36px;height:36px;background:rgba(37,99,235,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#2563EB;flex-shrink:0;">
                        <?= strtoupper(substr($usr['name'], 0, 1)) ?>
                    </div>
                    <div style="flex:1;">
                        <div class="fw-600 fs-13"><?= htmlspecialchars($usr['name']) ?></div>
                        <div>
                            <span class="status-badge <?= $usr['badge'] ?>"><?= $usr['role'] ?></span>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-700 fs-13"><?= $usr['leads'] ?></div>
                        <div class="fs-12 text-muted">Leads</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- System Status Card (
    <div class="col-lg-4">
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-hdd-fill"></i> System Status</div>
                <span class="status-badge badge-active">
                    <i class="bi bi-circle-fill" style="font-size:8px;"></i> Online
                </span>
            </div>
            <div class="card-body-custom">
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-database me-2"></i>Database</span>
                    <span class="stat-val" style="color:#22C55E;"><i class="bi bi-check-circle-fill me-1"></i>Connected</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-server me-2"></i>Server</span>
                    <span class="stat-val" style="color:#22C55E;"><i class="bi bi-check-circle-fill me-1"></i>Running</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-people me-2"></i>Active Users</span>
                    <span class="stat-val">4</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-file-earmark-text me-2"></i>Total Leads in DB</span>
                    <span class="stat-val">38</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-calendar me-2"></i>Leads This Month</span>
                    <span class="stat-val">14</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-clock me-2"></i>Last Backup</span>
                    <span class="stat-val">Today 06:00 AM</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-code-slash me-2"></i>PHP Version</span>
                    <span class="stat-val">8.2.4</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label"><i class="bi bi-hdd-network me-2"></i>MySQL Version</span>
                    <span class="stat-val">8.0.32</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
