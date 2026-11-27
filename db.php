<?php
// ===== Database connection =====
mysqli_report(MYSQLI_REPORT_OFF);
// the 4 values mysqli needs is the host, username, password and database name
$conn = new mysqli("localhost", "root", "", "portfolio_db");

// it shows a page that says "Connection Failed"
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>