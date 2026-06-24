<?php
// ============================================================
// Lead Management System
// Lead Management System - Sales Analytics Dashboard
// Developer: Intern

// ============================================================

require_once 'db_connect.php';
include 'header.php';

// Sales Performance Data
$sales_performance = [
    ['company' => 'Tata Motors',        'leads' => 34, 'qualified' => 12, 'converted' => 8,  'lost' => 4,  'revenue' => '₹24,50,000'],
    ['company' => 'Infosys',            'leads' => 28, 'qualified' => 10, 'converted' => 7,  'lost' => 3,  'revenue' => '₹19,80,000'],
    ['company' => 'Wipro',              'leads' => 22, 'qualified' => 8,  'converted' => 5,  'lost' => 5,  'revenue' => '₹14,20,000'],
    ['company' => 'Tech Mahindra',      'leads' => 19, 'qualified' => 7,  'converted' => 6,  'lost' => 2,  'revenue' => '₹17,60,000'],
    ['company' => 'LTIMindtree',        'leads' => 16, 'qualified' => 6,  'converted' => 5,  'lost' => 2,  'revenue' => '₹12,40,000'],
    ['company' => 'Persistent Systems', 'leads' => 14, 'qualified' => 5,  'converted' => 4,  'lost' => 3,  'revenue' => '₹9,80,000'],
    ['company' => 'Cognizant',          'leads' => 21, 'qualified' => 8,  'converted' => 7,  'lost' => 4,  'revenue' => '₹21,00,000'],
    ['company' => 'HCL Technologies',   'leads' => 18, 'qualified' => 6,  'converted' => 5,  'lost' => 3,  'revenue' => '₹15,30,000'],
    ['company' => 'Accenture',          'leads' => 15, 'qualified' => 5,  'converted' => 3,  'lost' => 2,  'revenue' => '₹8,70,000'],
    ['company' => 'Capgemini',          'leads' => 12, 'qualified' => 4,  'converted' => 3,  'lost' => 1,  'revenue' => '₹7,20,000'],
];
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Sales Analytics</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">Sales Analytics Dashboard</h1>
        <div class="page-sub">Performance overview and lead conversion analytics</div>
    </div>
    <div class="d-flex gap-2">
        <select class="form-control-custom" style="width:auto;" id="analyticsFilter">
            <option>This Month</option>
            <option>Last Month</option>
            <option>This Quarter</option>
            <option>This Year</option>
        </select>
    </div>
</div>

<!-- ============================================================
     KPI CARDS (
     ============================================================ -->
<div class="row g-3 mb-4">
    <div class="col-xl col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-primary"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">247</div>
                <div class="kpi-label">Total Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+18 this month</div>
            </div>
        </div>
    </div>
    <div class="col-xl col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-info"><i class="bi bi-person-plus-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">63</div>
                <div class="kpi-label">New Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+8 this period</div>
            </div>
        </div>
    </div>
    <div class="col-xl col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-warning"><i class="bi bi-star-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">89</div>
                <div class="kpi-label">Qualified Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+12 this month</div>
            </div>
        </div>
    </div>
    <div class="col-xl col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-success"><i class="bi bi-check-circle-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">54</div>
                <div class="kpi-label">Converted Leads</div>
                <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+6 this month</div>
            </div>
        </div>
    </div>
    <div class="col-xl col-lg-4 col-md-4 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-danger"><i class="bi bi-x-circle-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">31</div>
                <div class="kpi-label">Lost Leads</div>
                <div class="kpi-trend down"><i class="bi bi-arrow-down-short"></i>-3 vs last month</div>
            </div>
        </div>
    </div>
</div>

<!-- Conversion Rate Banner -->
<div class="section-card mb-4" style="background:linear-gradient(135deg,#2563EB 0%,#1d4ed8 100%);border:none;">
    <div class="card-body-custom">
        <div class="row align-items-center">
            <div class="col-md-4 text-white">
                <div style="font-size:13px;opacity:0.8;margin-bottom:4px;">Overall Conversion Rate</div>
                <div style="font-size:40px;font-weight:700;">21.9%</div>
                <div style="font-size:12px;opacity:0.7;margin-top:4px;"><i class="bi bi-arrow-up-short"></i>+2.4% compared to last month</div>
            </div>
            <div class="col-md-8">
                <div class="row g-3 text-white">
                    <?php
                    $conv_stats = [
                        ['label' => 'Lead → Qualified', 'value' => '36.0%', 'note' => '89 of 247'],
                        ['label' => 'Qualified → Converted', 'value' => '60.7%', 'note' => '54 of 89'],
                        ['label' => 'Lead → Converted', 'value' => '21.9%', 'note' => '54 of 247'],
                        ['label' => 'Avg. Lead Age', 'value' => '14 Days', 'note' => 'To conversion'],
                    ];
                    foreach ($conv_stats as $cs):
                    ?>
                    <div class="col-md-3 col-6">
                        <div style="background:rgba(255,255,255,0.12);border-radius:8px;padding:14px;">
                            <div style="font-size:22px;font-weight:700;"><?= $cs['value'] ?></div>
                            <div style="font-size:12px;opacity:0.85;margin-top:2px;"><?= $cs['label'] ?></div>
                            <div style="font-size:11px;opacity:0.6;margin-top:2px;"><?= $cs['note'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     CHARTS ROW
     ============================================================ -->
<div class="row g-3 mb-4">
    <!-- Weekly Lead Growth -->
    <div class="col-lg-8">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title">
                    <i class="bi bi-graph-up-arrow"></i> Weekly Lead Growth
                </div>
                <span class="fs-12 text-muted">Last 8 weeks</span>
            </div>
            <div class="card-body-custom">
                <div class="chart-wrapper" style="height:260px;">
                    <canvas id="weeklyGrowthChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Status Distribution -->
    <div class="col-lg-4">
        <div class="section-card h-100">
            <div class="card-header-custom">
                <div class="card-title">
                    <i class="bi bi-pie-chart-fill"></i> Status Distribution
                </div>
            </div>
            <div class="card-body-custom">
                <div class="chart-wrapper" style="height:200px;">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
                <div style="margin-top:16px;">
                    <?php
                    $dist = [
                        ['New',         63,  '#2563EB'],
                        ['Qualified',   89,  '#0ea5e9'],
                        ['Converted',   54,  '#22C55E'],
                        ['In Progress', 45,  '#F59E0B'],
                        ['Lost',        31,  '#EF4444'],
                        ['Follow-up',   25,  '#8b5cf6'],
                    ];
                    foreach ($dist as [$label, $val, $color]):
                        $pct = round(($val / 247) * 100);
                    ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div style="width:10px;height:10px;border-radius:50%;background:<?= $color ?>;flex-shrink:0;"></div>
                        <span class="fs-12" style="flex:1;"><?= $label ?></span>
                        <span class="fs-12 fw-600"><?= $val ?></span>
                        <span class="fs-12 text-muted">(<?= $pct ?>%)</span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     SALES PERFORMANCE TABLE
     ============================================================ -->
<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title">
            <i class="bi bi-table"></i> Sales Performance Summary
        </div>
        <span class="fs-12 text-muted">By Company — June 2026</span>
    </div>
    <div class="card-body-custom p-0">
        <table class="lms-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Total Leads</th>
                    <th>Qualified</th>
                    <th>Converted</th>
                    <th>Lost</th>
                    <th>Conv. Rate</th>
                    <th>Est. Revenue</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales_performance as $i => $row):
                    $rate = round(($row['converted'] / $row['leads']) * 100);
                    $bar_color = $rate >= 30 ? '#22C55E' : ($rate >= 20 ? '#F59E0B' : '#EF4444');
                ?>
                <tr>
                    <td class="text-muted fs-12"><?= $i + 1 ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:30px;height:30px;background:rgba(37,99,235,0.10);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#2563EB;">
                                <?= strtoupper(substr($row['company'], 0, 2)) ?>
                            </div>
                            <span class="fw-600"><?= htmlspecialchars($row['company']) ?></span>
                        </div>
                    </td>
                    <td><strong><?= $row['leads'] ?></strong></td>
                    <td><span style="color:#0284c7;font-weight:600;"><?= $row['qualified'] ?></span></td>
                    <td><span style="color:#16a34a;font-weight:600;"><?= $row['converted'] ?></span></td>
                    <td><span style="color:#dc2626;font-weight:600;"><?= $row['lost'] ?></span></td>
                    <td>
                        <span style="font-weight:700;color:<?= $bar_color ?>;"><?= $rate ?>%</span>
                    </td>
                    <td class="fw-600 fs-13"><?= $row['revenue'] ?></td>
                    <td style="width:140px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress-custom flex-grow-1">
                                <div class="progress-bar-custom" style="width:<?= $rate ?>%;background:<?= $bar_color ?>;"></div>
                            </div>
                            <span class="fs-12"><?= $rate ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background:#f8fafc;">
                    <td colspan="2" class="fw-700 fs-13" style="padding:12px 14px;">TOTAL</td>
                    <td class="fw-700">199</td>
                    <td class="fw-700" style="color:#0284c7;">71</td>
                    <td class="fw-700" style="color:#16a34a;">53</td>
                    <td class="fw-700" style="color:#dc2626;">29</td>
                    <td class="fw-700" style="color:#22C55E;">26.6%</td>
                    <td class="fw-700">₹1,50,50,000</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
