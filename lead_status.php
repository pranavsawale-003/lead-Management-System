<?php
// ============================================================
// Lead Management System
// Lead Management System - Lead Status Page
// Developer: Intern

// ============================================================

require_once 'db_connect.php';
include 'header.php';

// Filter by status if provided
$filter_status = $_GET['status'] ?? '';

// Sample leads data
$all_leads = [
    ['id' => 1,  'name' => 'Rajesh Patil',    'company' => 'Tata Motors',           'mobile' => '9876543210', 'email' => 'rajesh@tata.com',      'source' => 'Website',   'status' => 'New',         'assigned' => 'Sneha Verma',  'date' => '24 Jun 2026', 'remarks' => 'Interested in fleet vehicles'],
    ['id' => 2,  'name' => 'Priya Joshi',     'company' => 'Infosys',               'mobile' => '9765432109', 'email' => 'priya@infosys.com',    'source' => 'Referral',  'status' => 'In Progress', 'assigned' => 'Rohit Patil',  'date' => '23 Jun 2026', 'remarks' => 'Following up on IT services proposal'],
    ['id' => 3,  'name' => 'Amit Deshmukh',   'company' => 'Wipro',                 'mobile' => '9654321098', 'email' => 'amit@wipro.com',       'source' => 'Walk-in',   'status' => 'Qualified',   'assigned' => 'Sneha Verma',  'date' => '22 Jun 2026', 'remarks' => 'Budget confirmed, proposal sent'],
    ['id' => 4,  'name' => 'Neha Kulkarni',   'company' => 'HCL Technologies',      'mobile' => '9543210987', 'email' => 'neha@hcl.com',         'source' => 'Website',   'status' => 'Follow-up',   'assigned' => 'Karan Mehta',  'date' => '21 Jun 2026', 'remarks' => 'Second follow-up scheduled'],
    ['id' => 5,  'name' => 'Rohit Jadhav',    'company' => 'Tech Mahindra',         'mobile' => '9432109876', 'email' => 'rohit@techmahindra.com','source' => 'Cold Call', 'status' => 'Converted',   'assigned' => 'Rohit Patil',  'date' => '20 Jun 2026', 'remarks' => 'Deal closed successfully'],
    ['id' => 6,  'name' => 'Pooja Mehta',     'company' => 'LTIMindtree',           'mobile' => '9321098765', 'email' => 'pooja@ltimindtree.com', 'source' => 'Email',     'status' => 'New',         'assigned' => 'Sneha Verma',  'date' => '19 Jun 2026', 'remarks' => 'Awaiting initial contact'],
    ['id' => 7,  'name' => 'Vikram Singh',    'company' => 'Cognizant',             'mobile' => '9210987654', 'email' => 'vikram@cognizant.com',  'source' => 'Referral',  'status' => 'Lost',        'assigned' => 'Karan Mehta',  'date' => '18 Jun 2026', 'remarks' => 'Went with competitor'],
    ['id' => 8,  'name' => 'Aditya Verma',    'company' => 'Persistent Systems',    'mobile' => '9109876543', 'email' => 'aditya@persistent.com', 'source' => 'Website',   'status' => 'In Progress', 'assigned' => 'Rohit Patil',  'date' => '17 Jun 2026', 'remarks' => 'Demo scheduled for next period'],
    ['id' => 9,  'name' => 'Sunita Nair',     'company' => 'Infosys BPM',           'mobile' => '8998765432', 'email' => 'sunita@infosysbpm.com', 'source' => 'Social',    'status' => 'Qualified',   'assigned' => 'Sneha Verma',  'date' => '16 Jun 2026', 'remarks' => 'High value prospect'],
    ['id' => 10, 'name' => 'Manoj Sharma',    'company' => 'Capgemini',             'mobile' => '8887654321', 'email' => 'manoj@capgemini.com',   'source' => 'Cold Call', 'status' => 'Follow-up',   'assigned' => 'Karan Mehta',  'date' => '15 Jun 2026', 'remarks' => 'Requested product brochure'],
    ['id' => 11, 'name' => 'Kavita Desai',    'company' => 'Accenture',             'mobile' => '8776543210', 'email' => 'kavita@accenture.com',  'source' => 'Website',   'status' => 'New',         'assigned' => 'Sneha Verma',  'date' => '14 Jun 2026', 'remarks' => 'New inquiry via contact form'],
    ['id' => 12, 'name' => 'Rajan Pillai',    'company' => 'L&T Infotech',          'mobile' => '8665432109', 'email' => 'rajan@lnt.com',         'source' => 'Exhibition','status' => 'Converted',   'assigned' => 'Rohit Patil',  'date' => '13 Jun 2026', 'remarks' => 'Met at Tech Summit 2026'],
];

// Filter
if ($filter_status) {
    $leads = array_filter($all_leads, fn($l) => $l['status'] === $filter_status);
} else {
    $leads = $all_leads;
}

// Count by status
$status_counts = [];
foreach ($all_leads as $l) {
    $status_counts[$l['status']] = ($status_counts[$l['status']] ?? 0) + 1;
}

$statuses_list = ['New', 'In Progress', 'Qualified', 'Follow-up', 'Converted', 'Lost'];
$status_config = [
    'New'         => ['badge-new',       'bi-person-plus-fill',   '#2563EB', 'icon-primary'],
    'In Progress' => ['badge-progress',  'bi-arrow-repeat',       '#d97706', 'icon-warning'],
    'Qualified'   => ['badge-qualified', 'bi-star-fill',          '#0284c7', 'icon-info'],
    'Follow-up'   => ['badge-followup',  'bi-telephone-fill',     '#7c3aed', 'icon-purple'],
    'Converted'   => ['badge-converted', 'bi-check-circle-fill',  '#16a34a', 'icon-success'],
    'Lost'        => ['badge-lost',      'bi-x-circle-fill',      '#dc2626', 'icon-danger'],
];

function statusBadge2($status) {
    $map = [
        'New'         => 'badge-new',
        'In Progress' => 'badge-progress',
        'Qualified'   => 'badge-qualified',
        'Follow-up'   => 'badge-followup',
        'Converted'   => 'badge-converted',
        'Lost'        => 'badge-lost',
    ];
    $cls = $map[$status] ?? 'badge-new';
    return "<span class=\"status-badge $cls\">$status</span>";
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Lead Status</span>
    <?php if ($filter_status): ?>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span><?= htmlspecialchars($filter_status) ?></span>
    <?php endif; ?>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">Lead Status Management</h1>
        <div class="page-sub">Track and manage all leads across different stages</div>
    </div>
    <a href="add_lead.php" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Add New Lead
    </a>
</div>

<!-- Status Summary Cards -->
<div class="row g-3 mb-4">
    <?php foreach ($statuses_list as $st):
        [$badge, $icon, $color, $iconClass] = $status_config[$st];
        $cnt = $status_counts[$st] ?? 0;
        $active_cls = ($filter_status === $st) ? 'border-primary' : '';
    ?>
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
        <a href="?status=<?= urlencode($st) ?>" style="text-decoration:none;">
            <div class="kpi-card <?= $active_cls ?>" style="<?= $filter_status === $st ? 'border:2px solid #2563EB;' : '' ?>">
                <div class="kpi-icon <?= $iconClass ?>">
                    <i class="bi <?= $icon ?>"></i>
                </div>
                <div class="kpi-data">
                    <div class="kpi-value"><?= $cnt ?></div>
                    <div class="kpi-label"><?= $st ?></div>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Leads Table -->
<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title">
            <i class="bi bi-kanban-fill"></i>
            <?= $filter_status ? htmlspecialchars($filter_status) . ' Leads' : 'All Leads' ?>
            <span class="status-badge" style="background:rgba(37,99,235,0.12);color:#2563EB;"><?= count($leads) ?></span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <?php if ($filter_status): ?>
            <a href="lead_status.php" class="btn-sm-action btn-view">
                <i class="bi bi-x-lg"></i> Clear Filter
            </a>
            <?php endif; ?>
            <span class="fs-12 text-muted">Showing <?= count($leads) ?> of <?= count($all_leads) ?> leads</span>
        </div>
    </div>
    <div class="card-body-custom p-0">
        <table class="lms-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lead Name</th>
                    <th>Company</th>
                    <th>Mobile</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Date Added</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                <tr>
                    <td class="text-muted fs-12"><?= $lead['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;background:rgba(37,99,235,0.10);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#2563EB;flex-shrink:0;">
                                <?= strtoupper(substr($lead['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-600"><?= htmlspecialchars($lead['name']) ?></div>
                                <div class="fs-12 text-muted"><?= htmlspecialchars($lead['email']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="fw-600 fs-13"><?= htmlspecialchars($lead['company']) ?></td>
                    <td class="text-muted fs-13"><?= htmlspecialchars($lead['mobile']) ?></td>
                    <td>
                        <span class="fs-12 text-muted">
                            <i class="bi bi-broadcast me-1" style="color:#2563EB;"></i>
                            <?= htmlspecialchars($lead['source']) ?>
                        </span>
                    </td>
                    <td><?= statusBadge2($lead['status']) ?></td>
                    <td class="fs-13 text-muted"><?= htmlspecialchars($lead['assigned']) ?></td>
                    <td class="fs-12 text-muted"><?= $lead['date'] ?></td>
                    <td>
                        <span class="fs-12 text-muted" title="<?= htmlspecialchars($lead['remarks']) ?>">
                            <?= strlen($lead['remarks']) > 30 ? htmlspecialchars(substr($lead['remarks'], 0, 30)) . '...' : htmlspecialchars($lead['remarks']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn-sm-action btn-view" title="View">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn-sm-action btn-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn-sm-action btn-delete" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($leads)): ?>
                <tr>
                    <td colspan="10" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        No leads found for this status.
                        <a href="lead_status.php">View all leads</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Table Footer / Pagination -->
    <div style="padding:12px 20px;border-top:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
        <span class="fs-12 text-muted">
            Showing 1 to <?= count($leads) ?> of <?= count($leads) ?> entries
        </span>
        <div class="d-flex gap-2">
            <button class="btn-sm-action btn-view" disabled>Previous</button>
            <button class="btn-sm-action btn-primary" style="background:var(--primary);color:white;padding:4px 12px;">1</button>
            <button class="btn-sm-action btn-view">Next</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
