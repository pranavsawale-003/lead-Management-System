<?php
// ============================================================
// Lead Management System
// Lead Management System - Reports Module
// Developer: Intern

// ============================================================

require_once 'db_connect.php';

$report_type    = $_GET['report'] ?? '';
$date_from      = $_GET['date_from'] ?? date('Y-m-01');
$date_to        = $_GET['date_to']   ?? date('Y-m-d');
$report_message = '';

// Handle report export simulation
if (isset($_GET['export'])) {
    $report_message = 'success';
}

include 'header.php';

// Monthly Report Data
$monthly_data = [
    ['month' => 'January 2026',  'total' => 22, 'new' => 8,  'converted' => 4, 'lost' => 2, 'rate' => '18.2%'],
    ['month' => 'February 2026', 'total' => 19, 'new' => 6,  'converted' => 3, 'lost' => 3, 'rate' => '15.8%'],
    ['month' => 'March 2026',    'total' => 31, 'new' => 10, 'converted' => 7, 'lost' => 4, 'rate' => '22.6%'],
    ['month' => 'April 2026',    'total' => 27, 'new' => 9,  'converted' => 6, 'lost' => 3, 'rate' => '22.2%'],
    ['month' => 'May 2026',      'total' => 34, 'new' => 12, 'converted' => 8, 'lost' => 5, 'rate' => '23.5%'],
    ['month' => 'June 2026',     'total' => 38, 'new' => 9,  'converted' => 8, 'lost' => 2, 'rate' => '21.1%'],
];

// Source Analysis Data
$source_data = [
    ['source' => 'Website',    'leads' => 68, 'converted' => 16, 'rate' => '23.5%', 'icon' => 'bi-globe',       'color' => '#2563EB'],
    ['source' => 'Referral',   'leads' => 54, 'converted' => 15, 'rate' => '27.8%', 'icon' => 'bi-person-check','color' => '#22C55E'],
    ['source' => 'Walk-in',    'leads' => 38, 'converted' => 9,  'rate' => '23.7%', 'icon' => 'bi-door-open',   'color' => '#F59E0B'],
    ['source' => 'Cold Call',  'leads' => 42, 'converted' => 8,  'rate' => '19.0%', 'icon' => 'bi-telephone',   'color' => '#8b5cf6'],
    ['source' => 'Email',      'leads' => 31, 'converted' => 5,  'rate' => '16.1%', 'icon' => 'bi-envelope',    'color' => '#0ea5e9'],
    ['source' => 'Social',     'leads' => 14, 'converted' => 1,  'rate' => '7.1%',  'icon' => 'bi-share',       'color' => '#EF4444'],
];
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Reports</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">Reports Module</h1>
        <div class="page-sub">Generate and export lead management reports</div>
    </div>
</div>

<!-- Export Success Alert -->
<?php if ($report_message === 'success'): ?>
<div class="alert d-flex align-items-center gap-2 mb-4" style="border-radius:8px;background:rgba(34,197,94,0.12);color:#16a34a;border:none;">
    <i class="bi bi-download fs-5"></i>
    <span>Report has been generated and downloaded successfully! <strong>(Demo Mode)</strong></span>
</div>
<?php endif; ?>

<!-- ============================================================
     REPORT TYPE CARDS
     ============================================================ -->
<div class="row g-3 mb-4">
    <?php
    $report_types = [
        ['monthly',     'Monthly Lead Report',       'bi-calendar-month-fill',    'icon-primary',  'Complete monthly analysis of all leads with trends'],
        ['conversion',  'Lead Conversion Report',    'bi-graph-up-arrow',         'icon-success',  'Detailed conversion funnel and rate analysis'],
        ['performance', 'Sales Performance Report',  'bi-trophy-fill',            'icon-warning',  'Team-wise and company-wise performance metrics'],
        ['source',      'Lead Source Analysis',      'bi-broadcast-pin',          'icon-purple',   'Analysis of lead origins and source effectiveness'],
    ];
    foreach ($report_types as [$type, $title, $icon, $iconCls, $desc]):
        $isActive = $report_type === $type;
    ?>
    <div class="col-lg-3 col-md-6">
        <a href="?report=<?= $type ?>&date_from=<?= $date_from ?>&date_to=<?= $date_to ?>" style="text-decoration:none;">
            <div class="section-card" style="cursor:pointer;<?= $isActive ? 'border:2px solid #2563EB;' : 'border:1px solid #e2e8f0;' ?> margin-bottom:0;">
                <div class="card-body-custom">
                    <div class="kpi-icon <?= $iconCls ?> mb-3" style="width:44px;height:44px;border-radius:10px;">
                        <i class="bi <?= $icon ?>"></i>
                    </div>
                    <div class="fw-700 fs-13 mb-1"><?= $title ?></div>
                    <div class="fs-12 text-muted"><?= $desc ?></div>
                    <?php if ($isActive): ?>
                    <div class="mt-2">
                        <span class="status-badge badge-new"><i class="bi bi-check-circle-fill me-1"></i>Selected</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- ============================================================
     DATE FILTERS & EXPORT
     ============================================================ -->
<div class="section-card mb-4">
    <div class="card-header-custom">
        <div class="card-title"><i class="bi bi-funnel-fill"></i> Report Filters</div>
    </div>
    <div class="card-body-custom">
        <form method="GET" action="reports.php">
            <input type="hidden" name="report" value="<?= htmlspecialchars($report_type) ?>">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label-custom">Report Type</label>
                    <select name="report" class="form-control-custom">
                        <option value="">Select Report Type</option>
                        <option value="monthly"     <?= $report_type === 'monthly'     ? 'selected' : '' ?>>Monthly Lead Report</option>
                        <option value="conversion"  <?= $report_type === 'conversion'  ? 'selected' : '' ?>>Lead Conversion Report</option>
                        <option value="performance" <?= $report_type === 'performance' ? 'selected' : '' ?>>Sales Performance Report</option>
                        <option value="source"      <?= $report_type === 'source'      ? 'selected' : '' ?>>Lead Source Analysis</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Date From</label>
                    <input type="date" name="date_from" class="form-control-custom" value="<?= htmlspecialchars($date_from) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Date To</label>
                    <input type="date" name="date_to" class="form-control-custom" value="<?= htmlspecialchars($date_to) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label-custom">Assigned To</label>
                    <select name="assigned" class="form-control-custom">
                        <option value="">All Team Members</option>
                        <option>Sneha Verma</option>
                        <option>Rohit Patil</option>
                        <option>Karan Mehta</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-search"></i> Generate
                    </button>
                    <a href="?report=<?= $report_type ?>&date_from=<?= $date_from ?>&date_to=<?= $date_to ?>&export=1"
                       class="btn-success-custom">
                        <i class="bi bi-download"></i> Export
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
     REPORT CONTENT — MONTHLY LEAD REPORT
     ============================================================ -->
<?php if (!$report_type || $report_type === 'monthly'): ?>

<!-- Lead Conversion Statistics (shown on all reports) -->
<div class="row g-3 mb-4">
    <?php
    $conv_kpis = [
        ['Total Leads (YTD)',    '171', 'icon-primary',  'bi-people-fill'],
        ['Total Converted',      '36',  'icon-success',  'bi-check-circle-fill'],
        ['Avg. Conversion Rate', '21%', 'icon-warning',  'bi-graph-up-arrow'],
        ['Avg. Follow-ups',      '2.4', 'icon-info',     'bi-telephone-fill'],
    ];
    foreach ($conv_kpis as [$lbl, $val, $cls, $ico]):
    ?>
    <div class="col-lg-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-icon <?= $cls ?>"><i class="bi <?= $ico ?>"></i></div>
            <div class="kpi-data">
                <div class="kpi-value"><?= $val ?></div>
                <div class="kpi-label"><?= $lbl ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title"><i class="bi bi-calendar-month-fill"></i> Monthly Lead Report — 2026</div>
        <span class="fs-12 text-muted">January – June 2026</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="lms-table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Leads</th>
                    <th>New Leads</th>
                    <th>Converted</th>
                    <th>Lost</th>
                    <th>Pending</th>
                    <th>Conv. Rate</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly_data as $row):
                    $pending = $row['total'] - $row['converted'] - $row['lost'];
                    $rate_num = floatval($row['rate']);
                    $bar_color = $rate_num >= 22 ? '#22C55E' : ($rate_num >= 18 ? '#F59E0B' : '#EF4444');
                ?>
                <tr>
                    <td class="fw-600"><?= $row['month'] ?></td>
                    <td><strong><?= $row['total'] ?></strong></td>
                    <td style="color:#2563EB;font-weight:600;"><?= $row['new'] ?></td>
                    <td style="color:#16a34a;font-weight:600;"><?= $row['converted'] ?></td>
                    <td style="color:#dc2626;font-weight:600;"><?= $row['lost'] ?></td>
                    <td style="color:#d97706;font-weight:600;"><?= $pending ?></td>
                    <td style="font-weight:700;color:<?= $bar_color ?>;"><?= $row['rate'] ?></td>
                    <td style="width:150px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress-custom flex-grow-1">
                                <div class="progress-bar-custom" style="width:<?= $rate_num * 4 ?>%;background:<?= $bar_color ?>;"></div>
                            </div>
                            <span class="fs-12"><?= $row['rate'] ?></span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background:#f8fafc;">
                    <td class="fw-700" style="padding:12px 14px;">TOTAL (H1 2026)</td>
                    <td class="fw-700">171</td>
                    <td class="fw-700" style="color:#2563EB;">54</td>
                    <td class="fw-700" style="color:#16a34a;">36</td>
                    <td class="fw-700" style="color:#dc2626;">19</td>
                    <td class="fw-700" style="color:#d97706;">116</td>
                    <td class="fw-700" style="color:#22C55E;">21.1%</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php elseif ($report_type === 'source'): ?>

<!-- Source Analysis Report -->
<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title"><i class="bi bi-broadcast-pin"></i> Lead Source Analysis Report</div>
        <span class="fs-12 text-muted"><?= date('d M Y', strtotime($date_from)) ?> to <?= date('d M Y', strtotime($date_to)) ?></span>
    </div>
    <div class="card-body-custom p-0">
        <table class="lms-table">
            <thead>
                <tr>
                    <th>Lead Source</th>
                    <th>Total Leads</th>
                    <th>Qualified</th>
                    <th>Converted</th>
                    <th>Conv. Rate</th>
                    <th>Share</th>
                    <th>Effectiveness</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($source_data as $row):
                    $total = array_sum(array_column($source_data, 'leads'));
                    $share = round(($row['leads'] / $total) * 100);
                    $rate_num = floatval($row['rate']);
                    $bar_color = $rate_num >= 25 ? '#22C55E' : ($rate_num >= 18 ? '#F59E0B' : '#EF4444');
                ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="activity-icon" style="background:rgba(37,99,235,0.10);color:<?= $row['color'] ?>;">
                                <i class="bi <?= $row['icon'] ?>"></i>
                            </div>
                            <span class="fw-600"><?= htmlspecialchars($row['source']) ?></span>
                        </div>
                    </td>
                    <td><strong><?= $row['leads'] ?></strong></td>
                    <td style="color:#0284c7;font-weight:600;"><?= round($row['leads'] * 0.38) ?></td>
                    <td style="color:#16a34a;font-weight:600;"><?= $row['converted'] ?></td>
                    <td style="font-weight:700;color:<?= $bar_color ?>;"><?= $row['rate'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress-custom" style="width:80px;">
                                <div class="progress-bar-custom" style="width:<?= $share ?>%;background:<?= $row['color'] ?>;"></div>
                            </div>
                            <span class="fs-12"><?= $share ?>%</span>
                        </div>
                    </td>
                    <td>
                        <?php
                        $eff = $rate_num >= 25 ? ['badge-converted', 'High'] : ($rate_num >= 18 ? ['badge-progress', 'Medium'] : ['badge-lost', 'Low']);
                        echo "<span class=\"status-badge {$eff[0]}\">{$eff[1]}</span>";
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>

<!-- Generic Report View for conversion & performance -->
<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title">
            <i class="bi bi-file-earmark-bar-graph-fill"></i>
            <?= $report_type === 'conversion' ? 'Lead Conversion Report' : 'Sales Performance Report' ?>
        </div>
        <span class="fs-12 text-muted"><?= date('d M Y', strtotime($date_from)) ?> to <?= date('d M Y', strtotime($date_to)) ?></span>
    </div>
    <div class="card-body-custom">
        <div class="row g-3 mb-4">
            <?php
            if ($report_type === 'conversion') {
                $stats = [
                    ['Total Leads Entered',     '171',  'icon-primary',  'bi-people-fill'],
                    ['Qualified Leads',          '62',   'icon-info',     'bi-star-fill'],
                    ['Converted Leads',          '36',   'icon-success',  'bi-check-circle-fill'],
                    ['Lost Leads',               '19',   'icon-danger',   'bi-x-circle-fill'],
                    ['Avg. Time to Conversion',  '14d',  'icon-warning',  'bi-clock-fill'],
                    ['Conversion Rate',          '21.1%','icon-purple',   'bi-graph-up-arrow'],
                ];
            } else {
                $stats = [
                    ['Total Sales Execs',   '3',     'icon-primary', 'bi-people-fill'],
                    ['Best Performer',      'Rohit', 'icon-success', 'bi-trophy-fill'],
                    ['Leads This Period',   '38',    'icon-info',    'bi-person-plus-fill'],
                    ['Converted',           '8',     'icon-success', 'bi-check-circle-fill'],
                    ['Avg. per Executive',  '12.7',  'icon-warning', 'bi-bar-chart-fill'],
                    ['Team Conv. Rate',     '21.0%', 'icon-purple',  'bi-graph-up-arrow'],
                ];
            }
            foreach ($stats as [$lbl, $val, $cls, $ico]):
            ?>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-icon <?= $cls ?> mb-2" style="width:40px;height:40px;border-radius:8px;">
                            <i class="bi <?= $ico ?>"></i>
                        </div>
                        <div class="kpi-value"><?= $val ?></div>
                        <div class="kpi-label"><?= $lbl ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center py-3 text-muted">
            <i class="bi bi-file-earmark-text fs-1 d-block mb-2" style="color:#cbd5e1;"></i>
            Click <strong>Generate</strong> to load report data, then <strong>Export</strong> to download.
        </div>
    </div>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
