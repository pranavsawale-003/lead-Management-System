<?php
// ============================================================
// Lead Management System
// Lead Management System - Footer Partial
// Developer: Intern

// ============================================================

$current_page_footer = basename($_SERVER['PHP_SELF']);
?>

<?php if ($current_page_footer !== 'login.php'): ?>
    </div><!-- /.page-content -->
</div><!-- /#main-content -->
<?php endif; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- Custom Chart Configuration -->
<script src="assets/js/chart_config.js"></script>

<!-- Footer Note -->
<?php if ($current_page_footer !== 'login.php'): ?>
<script>
// Inline page-specific scripts can be added here
console.log("Lead Management System | Lead Management System");
console.log("Module: <?= htmlspecialchars($current_page_footer) ?> | Loaded: " + new Date().toLocaleString());
</script>
<?php endif; ?>

</body>
</html>
