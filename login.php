<?php
// ============================================================
// Lead Management System
// Lead Management System - Login Page
// Developer: Intern

// ============================================================

session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error_msg   = '';
$success_msg = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    // Demo credentials validation
    $demo_users = [
        'admin@leadms.com'  => ['password' => 'admin123',  'name' => 'Akash Sharma',  'role' => 'Admin'],
        'sneha@leadms.com'  => ['password' => 'sales123',  'name' => 'Sneha Verma',   'role' => 'Sales Executive'],
        'rohit@leadms.com'  => ['password' => 'lead123',   'name' => 'Rohit Patil',   'role' => 'Team Lead'],
        'karan@leadms.com'  => ['password' => 'sales123',  'name' => 'Karan Mehta',   'role' => 'Sales Executive'],
    ];

    if (!$email || !$password) {
        $error_msg = 'Please enter your email and password.';
    } else {
        // Find if it's one of the demo users for name/role assignment; otherwise generate default details
        $demo_users = [
            'admin@leadms.com'  => ['name' => 'Akash Sharma',  'role' => 'Admin'],
            'sneha@leadms.com'  => ['name' => 'Sneha Verma',   'role' => 'Sales Executive'],
            'rohit@leadms.com'  => ['name' => 'Rohit Patil',   'role' => 'Team Lead'],
            'karan@leadms.com'  => ['name' => 'Karan Mehta',   'role' => 'Sales Executive'],
        ];

        $user_info = $demo_users[$email] ?? ['name' => 'Demo User', 'role' => 'Admin'];

        // Successful login with any credentials
        $_SESSION['user_id']   = md5($email);
        $_SESSION['user_email']= $email;
        $_SESSION['user_name'] = $user_info['name'];
        $_SESSION['user_role'] = $user_info['role'];

        // Set remember-me cookie
        if ($remember) {
            setcookie('lms_user', $email, time() + (86400 * 30), '/');
        }

        header('Location: dashboard.php');
        exit;
    }
}

// For demo: auto-fill check
$prefill_email = $_COOKIE['lms_user'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Lead Management System | Lead Management System">
    <title>Login | Lead Management System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <!-- Logo / Branding -->
        <div class="login-logo">
            <div class="logo-icon">
                <i class="bi bi-diagram-3-fill"></i>
            </div>
            <h1>Lead Management System</h1>
            <p>Lead Management System</p>
        </div>

        <!-- Error Message -->
        <?php if ($error_msg): ?>
        <div class="alert d-flex align-items-center gap-2 mb-3"
             style="background:rgba(239,68,68,0.10);color:#dc2626;border:none;border-radius:8px;font-size:13px;padding:12px;">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($error_msg) ?>
        </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="login.php" id="loginForm">
            <!-- Email -->
            <div class="mb-3">
                <label class="form-label-custom" for="email">
                    <i class="bi bi-envelope me-1"></i> Email Address
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control-custom"
                       placeholder="Enter your email"
                       value="<?= htmlspecialchars($prefill_email ?: ($_POST['email'] ?? '')) ?>"
                       autocomplete="email"
                       required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label-custom" for="password">
                    <i class="bi bi-lock me-1"></i> Password
                </label>
                <div style="position:relative;">
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control-custom"
                           placeholder="Enter your password"
                           autocomplete="current-password"
                           required>
                    <button type="button"
                            onclick="togglePassword()"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox"
                           id="remember"
                           name="remember"
                           style="width:15px;height:15px;accent-color:#2563EB;cursor:pointer;"
                           <?= $prefill_email ? 'checked' : '' ?>>
                    <label for="remember" style="font-size:13px;color:#475569;cursor:pointer;margin:0;">Remember me</label>
                </div>
                <a href="#" style="font-size:13px;color:#2563EB;">Forgot password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="height:42px;font-size:14px;font-weight:600;">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>

        <!-- Demo Credentials -->
        <div style="margin-top:20px;background:#f8fafc;border-radius:8px;padding:14px;border:1px solid #e2e8f0;">
            <div class="fs-12 fw-600 mb-2" style="color:#475569;">
                <i class="bi bi-info-circle-fill me-1" style="color:#2563EB;"></i> Demo Credentials
            </div>
            <div style="font-size:12px;color:#64748b;line-height:1.8;">
                <div><strong>Admin:</strong> admin@leadms.com / admin123</div>
                <div><strong>Team Lead:</strong> rohit@leadms.com / lead123</div>
                <div><strong>Sales:</strong> sneha@leadms.com / sales123</div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-4" style="font-size:11px;color:#94a3b8;">
            &copy; 2026 Lead Management System | Lead Management System v2.0
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const pwd  = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pwd.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
