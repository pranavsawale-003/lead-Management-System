<?php
// ============================================================
// Lead Management System
// Lead Management System - Database Connection
// Developer: Intern

// ============================================================

$host     = 'localhost';
$dbname   = 'lead_management';
$username = 'root';
$password = 'PRANAVSS003';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('<div style="padding:20px;background:#fee;color:#c00;font-family:Arial;">
        <strong>Database Connection Failed:</strong> ' . $e->getMessage() . '
    </div>');
}

// Legacy mysqli connection (for compatibility)
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    // PDO already handles error above; this is a fallback reference
}
?>
