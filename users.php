<?php
// ============================================================
// Lead Management System
// Lead Management System - User Management
// Developer: Intern

// ============================================================

require_once 'db_connect.php';
include 'header.php';

// Sample user data
$users = [
    [
        'id'       => 1,
        'name'     => 'Akash Sharma',
        'email'    => 'admin@leadms.com',
        'role'     => 'Admin',
        'status'   => 'Active',
        'phone'    => '9876543210',
        'joined'   => '01 Jan 2026',
        'leads'    => 0,
        'last_login'=> 'Today, 09:45 AM',
    ],
    [
        'id'       => 2,
        'name'     => 'Sneha Verma',
        'email'    => 'sneha@leadms.com',
        'role'     => 'Sales Executive',
        'status'   => 'Active',
        'phone'    => '9765432101',
        'joined'   => '15 Jan 2026',
        'leads'    => 15,
        'last_login'=> 'Today, 10:12 AM',
    ],
    [
        'id'       => 3,
        'name'     => 'Rohit Patil',
        'email'    => 'rohit@leadms.com',
        'role'     => 'Team Lead',
        'status'   => 'Active',
        'phone'    => '9654321012',
        'joined'   => '10 Jan 2026',
        'leads'    => 12,
        'last_login'=> 'Today, 08:55 AM',
    ],
    [
        'id'       => 4,
        'name'     => 'Karan Mehta',
        'email'    => 'karan@leadms.com',
        'role'     => 'Sales Executive',
        'status'   => 'Active',
        'phone'    => '9543210123',
        'joined'   => '20 Jan 2026',
        'leads'    => 11,
        'last_login'=> 'Yesterday, 05:30 PM',
    ],
];

$role_badge = [
    'Admin'           => 'badge-admin',
    'Team Lead'       => 'badge-teamlead',
    'Sales Executive' => 'badge-sales',
];

// Handle flash message
$action_msg = $_GET['msg'] ?? '';
?>

<!-- Breadcrumb -->
<div class="breadcrumb-custom">
    <a href="dashboard.php">Home</a>
    <span class="sep"><i class="bi bi-chevron-right"></i></span>
    <span>User Management</span>
</div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-heading">User Management</h1>
        <div class="page-sub">Manage system users, roles and permissions</div>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus-fill"></i> Add User
    </button>
</div>

<!-- Flash Message -->
<?php if ($action_msg === 'added'): ?>
<div class="alert d-flex align-items-center gap-2 mb-4" style="background:rgba(34,197,94,0.12);color:#16a34a;border:none;border-radius:8px;">
    <i class="bi bi-check-circle-fill"></i> User has been added successfully!
</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-primary"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">4</div>
                <div class="kpi-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-success"><i class="bi bi-person-check-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">4</div>
                <div class="kpi-label">Active Users</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-warning"><i class="bi bi-shield-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">1</div>
                <div class="kpi-label">Admins</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon icon-info"><i class="bi bi-person-badge-fill"></i></div>
            <div class="kpi-data">
                <div class="kpi-value">2</div>
                <div class="kpi-label">Sales Executives</div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="section-card">
    <div class="card-header-custom">
        <div class="card-title"><i class="bi bi-people-fill"></i> All Users</div>
        <div class="d-flex gap-2 align-items-center">
            <input type="text"
                   id="userSearch"
                   class="form-control-custom"
                   style="width:200px;"
                   placeholder="Search users..."
                   onkeyup="filterUsers()">
        </div>
    </div>
    <div class="card-body-custom p-0">
        <table class="lms-table" id="usersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Leads Assigned</th>
                    <th>Joined</th>
                    <th>Last Login</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td class="text-muted fs-12"><?= $user['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:rgba(37,99,235,0.10);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#2563EB;flex-shrink:0;">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-600"><?= htmlspecialchars($user['name']) ?></div>
                                <?php if ($user['role'] === 'Admin'): ?>
                                <div class="fs-12 text-muted">Super Administrator</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted fs-13"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="text-muted fs-13"><?= htmlspecialchars($user['phone']) ?></td>
                    <td>
                        <span class="status-badge <?= $role_badge[$user['role']] ?? 'badge-new' ?>">
                            <?= htmlspecialchars($user['role']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($user['leads'] > 0): ?>
                        <span class="fw-600"><?= $user['leads'] ?> leads</span>
                        <?php else: ?>
                        <span class="text-muted fs-12">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted fs-12"><?= $user['joined'] ?></td>
                    <td class="text-muted fs-12"><?= $user['last_login'] ?></td>
                    <td>
                        <span class="status-badge <?= $user['status'] === 'Active' ? 'badge-active' : 'badge-inactive' ?>">
                            <i class="bi bi-circle-fill" style="font-size:7px;"></i>
                            <?= $user['status'] ?>
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn-sm-action btn-edit" title="Edit User"
                                    data-bs-toggle="modal" data-bs-target="#editUserModal"
                                    data-name="<?= htmlspecialchars($user['name']) ?>"
                                    data-email="<?= htmlspecialchars($user['email']) ?>"
                                    data-role="<?= htmlspecialchars($user['role']) ?>">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <?php if ($user['role'] !== 'Admin'): ?>
                            <button class="btn-sm-action btn-deactivate" title="Deactivate">
                                <i class="bi bi-toggle-off"></i> Deactivate
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ============================================================
     ADD USER MODAL
     ============================================================ -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #e2e8f0;padding:18px 24px;">
                <h5 class="modal-title fw-700" id="addUserModalLabel" style="font-size:15px;">
                    <i class="bi bi-person-plus-fill me-2" style="color:#2563EB;"></i>Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <form method="POST" action="users.php" id="addUserForm">
                    <div class="mb-3">
                        <label class="form-label-custom" for="new_name">Full Name *</label>
                        <input type="text" id="new_name" name="new_name" class="form-control-custom" placeholder="e.g. Ravi Kumar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom" for="new_email">Email Address *</label>
                        <input type="email" id="new_email" name="new_email" class="form-control-custom" placeholder="e.g. ravi@leadms.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom" for="new_phone">Phone Number</label>
                        <input type="tel" id="new_phone" name="new_phone" class="form-control-custom" placeholder="e.g. 9876543210" maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom" for="new_role">Role *</label>
                        <select id="new_role" name="new_role" class="form-control-custom" required>
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Team Lead">Team Lead</option>
                            <option value="Sales Executive">Sales Executive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom" for="new_password">Temporary Password *</label>
                        <input type="password" id="new_password" name="new_password" class="form-control-custom" placeholder="Set a password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e2e8f0;padding:14px 24px;">
                <button type="button" class="btn-primary-custom" style="background:#64748b;" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addUserForm" class="btn-primary-custom">
                    <i class="bi bi-check2-circle"></i> Add User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #e2e8f0;padding:18px 24px;">
                <h5 class="modal-title fw-700" id="editUserModalLabel" style="font-size:15px;">
                    <i class="bi bi-pencil-fill me-2" style="color:#2563EB;"></i>Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <div class="mb-3">
                    <label class="form-label-custom">Full Name</label>
                    <input type="text" id="edit_name" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Email Address</label>
                    <input type="email" id="edit_email" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Role</label>
                    <select id="edit_role" class="form-control-custom">
                        <option>Admin</option>
                        <option>Team Lead</option>
                        <option>Sales Executive</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Status</label>
                    <select class="form-control-custom">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e2e8f0;padding:14px 24px;">
                <button type="button" class="btn-primary-custom" style="background:#64748b;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" data-bs-dismiss="modal">
                    <i class="bi bi-check2-circle"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Populate edit modal on open
document.getElementById('editUserModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit_name').value  = btn.dataset.name  || '';
    document.getElementById('edit_email').value = btn.dataset.email || '';
    const roleSelect = document.getElementById('edit_role');
    for (let opt of roleSelect.options) {
        opt.selected = (opt.value === btn.dataset.role);
    }
});

// Live search
function filterUsers() {
    const q   = document.getElementById('userSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>

<?php include 'footer.php'; ?>
