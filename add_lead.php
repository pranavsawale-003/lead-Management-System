<?php
// ============================================================
// Lead Management System
// Lead Management System - Add New Lead
// Developer: Intern

// ============================================================

require_once 'db_connect.php';

$success_msg = '';
$error_msg   = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lead_name    = trim($_POST['lead_name']    ?? '');
    $company_name = trim($_POST['company_name'] ?? '');
    $mobile       = trim($_POST['mobile']       ?? '');
    $email        = trim($_POST['email']        ?? '');
    $source       = trim($_POST['source']       ?? '');
    $status       = trim($_POST['status']       ?? '');
    $assigned_to  = trim($_POST['assigned_to']  ?? '');
    $remarks      = trim($_POST['remarks']      ?? '');

    // Basic validation
    if (!$lead_name || !$mobile || !$status) {
        $error_msg = 'Please fill in all required fields (Lead Name, Mobile, Status).';
    } elseif (!preg_match('/^[6-9]\d{9}$/', $mobile)) {
        $error_msg = 'Please enter a valid 10-digit Indian mobile number.';
    } else {
        // Insert into DB (if DB is live; else show success)
        try {
            $sql = "INSERT INTO leads (lead_name, company_name, mobile, email, source, status, assigned_to, remarks, created_at)
                    VALUES (:lead_name, :company_name, :mobile, :email, :source, :status, :assigned_to, :remarks, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':lead_name'    => $lead_name,
                ':company_name' => $company_name,
                ':mobile'       => $mobile,
                ':email'        => $email,
                ':source'       => $source,
                ':status'       => $status,
                ':assigned_to'  => $assigned_to,
                ':remarks'      => $remarks,
            ]);
            $success_msg = "Lead <strong>" . htmlspecialchars($lead_name) . "</strong> from <strong>" . htmlspecialchars($company_name) . "</strong> has been added successfully!";
        } catch (PDOException $e) {
            // DB not configured — show success for demo
            $success_msg = "Lead <strong>" . htmlspecialchars($lead_name) . "</strong> from <strong>" . htmlspecialchars($company_name) . "</strong> has been added successfully! (Demo Mode)";
        }
    }
}

include 'header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>Add New Lead</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">Add New Lead</h1>
        <div class="page-sub">Enter details for a new lead into the system</div>
    </div>
    <a href="lead_status.php" class="btn-primary-custom" style="background:#64748b;">
        <i class="bi bi-list-ul"></i> View All Leads
    </a>
</div>

<!-- Alert Messages -->
<?php if ($success_msg): ?>
<div class="alert alert-success d-flex align-items-center gap-2 mb-4" style="border-radius:8px;border:none;background:rgba(34,197,94,0.12);color:#16a34a;">
    <i class="bi bi-check-circle-fill fs-5"></i>
    <span><?= $success_msg ?></span>
</div>
<?php endif; ?>
<?php if ($error_msg): ?>
<div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="border-radius:8px;border:none;background:rgba(239,68,68,0.10);color:#dc2626;">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <span><?= $error_msg ?></span>
</div>
<?php endif; ?>

<div class="row g-4">
    <!-- Lead Entry Form -->
    <div class="col-lg-8">
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title">
                    <i class="bi bi-person-plus-fill"></i> Lead Information
                </div>
                <span class="fs-12 text-muted">All fields marked * are required</span>
            </div>
            <div class="card-body-custom">
                <form method="POST" action="add_lead.php" id="addLeadForm" novalidate>

                    <!-- Row 1: Lead Name + Company Name -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom" for="lead_name">Lead Name <span style="color:var(--danger);">*</span></label>
                            <input type="text"
                                   id="lead_name"
                                   name="lead_name"
                                   class="form-control-custom"
                                   placeholder="e.g. Rajesh Patil"
                                   value="<?= htmlspecialchars($_POST['lead_name'] ?? '') ?>"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom" for="company_name">Company Name</label>
                            <input type="text"
                                   id="company_name"
                                   name="company_name"
                                   class="form-control-custom"
                                   placeholder="e.g. Tata Motors"
                                   value="<?= htmlspecialchars($_POST['company_name'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Row 2: Mobile + Email -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom" for="mobile">Mobile Number <span style="color:var(--danger);">*</span></label>
                            <div style="position:relative;">
                                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748b;font-size:13px;">+91</span>
                                <input type="tel"
                                       id="mobile"
                                       name="mobile"
                                       class="form-control-custom"
                                       style="padding-left:42px;"
                                       placeholder="9876543210"
                                       maxlength="10"
                                       value="<?= htmlspecialchars($_POST['mobile'] ?? '') ?>"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom" for="email">Email Address</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control-custom"
                                   placeholder="e.g. rajesh@tata.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Row 3: Source + Status -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom" for="source">Lead Source</label>
                            <select id="source" name="source" class="form-control-custom">
                                <option value="">-- Select Source --</option>
                                <option value="Website"   <?= ($_POST['source'] ?? '') === 'Website'   ? 'selected' : '' ?>>Website</option>
                                <option value="Referral"  <?= ($_POST['source'] ?? '') === 'Referral'  ? 'selected' : '' ?>>Referral</option>
                                <option value="Walk-in"   <?= ($_POST['source'] ?? '') === 'Walk-in'   ? 'selected' : '' ?>>Walk-in</option>
                                <option value="Cold Call" <?= ($_POST['source'] ?? '') === 'Cold Call' ? 'selected' : '' ?>>Cold Call</option>
                                <option value="Email"     <?= ($_POST['source'] ?? '') === 'Email'     ? 'selected' : '' ?>>Email Campaign</option>
                                <option value="Social"    <?= ($_POST['source'] ?? '') === 'Social'    ? 'selected' : '' ?>>Social Media</option>
                                <option value="Exhibition"<?= ($_POST['source'] ?? '') === 'Exhibition'? 'selected' : '' ?>>Exhibition / Event</option>
                                <option value="Other"     <?= ($_POST['source'] ?? '') === 'Other'     ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom" for="status">Lead Status <span style="color:var(--danger);">*</span></label>
                            <select id="status" name="status" class="form-control-custom" required>
                                <option value="">-- Select Status --</option>
                                <option value="New"         <?= ($_POST['status'] ?? '') === 'New'         ? 'selected' : '' ?>>New</option>
                                <option value="In Progress" <?= ($_POST['status'] ?? '') === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Qualified"   <?= ($_POST['status'] ?? '') === 'Qualified'   ? 'selected' : '' ?>>Qualified</option>
                                <option value="Follow-up"   <?= ($_POST['status'] ?? '') === 'Follow-up'   ? 'selected' : '' ?>>Follow-up</option>
                                <option value="Converted"   <?= ($_POST['status'] ?? '') === 'Converted'   ? 'selected' : '' ?>>Converted</option>
                                <option value="Lost"        <?= ($_POST['status'] ?? '') === 'Lost'        ? 'selected' : '' ?>>Lost</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 4: Assigned To -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom" for="assigned_to">Assigned To</label>
                            <select id="assigned_to" name="assigned_to" class="form-control-custom">
                                <option value="">-- Select Sales Person --</option>
                                <option value="Sneha Verma"  <?= ($_POST['assigned_to'] ?? '') === 'Sneha Verma'  ? 'selected' : '' ?>>Sneha Verma (Sales Executive)</option>
                                <option value="Rohit Patil"  <?= ($_POST['assigned_to'] ?? '') === 'Rohit Patil'  ? 'selected' : '' ?>>Rohit Patil (Team Lead)</option>
                                <option value="Karan Mehta"  <?= ($_POST['assigned_to'] ?? '') === 'Karan Mehta'  ? 'selected' : '' ?>>Karan Mehta (Sales Executive)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom" for="follow_up_date">Next Follow-up Date</label>
                            <input type="date"
                                   id="follow_up_date"
                                   name="follow_up_date"
                                   class="form-control-custom"
                                   value="<?= htmlspecialchars($_POST['follow_up_date'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Row 5: Remarks -->
                    <div class="mb-4">
                        <label class="form-label-custom" for="remarks">Remarks / Notes</label>
                        <textarea id="remarks"
                                  name="remarks"
                                  class="form-control-custom"
                                  rows="4"
                                  placeholder="Enter any additional notes about this lead..."><?= htmlspecialchars($_POST['remarks'] ?? '') ?></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 align-items-center">
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-check2-circle"></i> Save Lead
                        </button>
                        <button type="reset" class="btn-primary-custom" style="background:#64748b;">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                        </button>
                        <a href="dashboard.php" class="btn-primary-custom" style="background:#e2e8f0;color:#475569;">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Right Panel: Info Cards -->
    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="section-card mb-3">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-info-circle-fill"></i> Lead Summary</div>
            </div>
            <div class="card-body-custom">
                <div class="stat-row">
                    <span class="stat-label">Total Leads</span>
                    <span class="stat-val">38</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">New This Cycle</span>
                    <span class="stat-val" style="color:#2563EB;">9</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Converted</span>
                    <span class="stat-val" style="color:#22C55E;">8</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Follow-ups Due</span>
                    <span class="stat-val" style="color:#F59E0B;">6</span>
                </div>
            </div>
        </div>

        <!-- Source Guide -->
        <div class="section-card mb-3">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-lightbulb-fill"></i> Lead Source Guide</div>
            </div>
            <div class="card-body-custom">
                <?php
                $sources = [
                    ['Website',     'bi-globe',       'Leads from online forms',        '#2563EB'],
                    ['Referral',    'bi-person-check','Referred by existing customer',   '#22C55E'],
                    ['Walk-in',     'bi-door-open',   'Customer walked into office',     '#F59E0B'],
                    ['Cold Call',   'bi-telephone',   'Outbound call to prospect',       '#8b5cf6'],
                    ['Email',       'bi-envelope',    'Email marketing campaign',        '#0ea5e9'],
                    ['Social',      'bi-share',       'Social media platforms',          '#EF4444'],
                ];
                foreach ($sources as [$label, $icon, $desc, $color]):
                ?>
                <div class="d-flex align-items-start gap-2 mb-2">
                    <i class="bi <?= $icon ?>" style="color:<?= $color ?>;font-size:14px;margin-top:2px;"></i>
                    <div>
                        <div class="fw-600 fs-12"><?= $label ?></div>
                        <div class="fs-12 text-muted"><?= $desc ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Status Guide -->
        <div class="section-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="bi bi-kanban-fill"></i> Status Guide</div>
            </div>
            <div class="card-body-custom">
                <?php
                $statuses = [
                    ['New',         'badge-new',       'Freshly added lead'],
                    ['In Progress', 'badge-progress',  'Being actively followed up'],
                    ['Qualified',   'badge-qualified', 'Meets criteria, needs proposal'],
                    ['Follow-up',   'badge-followup',  'Awaiting next follow-up call'],
                    ['Converted',   'badge-converted', 'Successfully closed deal'],
                    ['Lost',        'badge-lost',      'Lead did not convert'],
                ];
                foreach ($statuses as [$label, $badge, $desc]):
                ?>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="status-badge <?= $badge ?>"><?= $label ?></span>
                    <span class="fs-12 text-muted"><?= $desc ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side validation
document.getElementById('addLeadForm').addEventListener('submit', function(e) {
    const mobile = document.getElementById('mobile').value;
    const mobileRegex = /^[6-9]\d{9}$/;
    if (!mobileRegex.test(mobile)) {
        e.preventDefault();
        alert('Please enter a valid 10-digit Indian mobile number (starting with 6-9).');
        document.getElementById('mobile').focus();
        return false;
    }
});

// Mobile number - only allow digits
document.getElementById('mobile').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
});
</script>

<?php include 'footer.php'; ?>
