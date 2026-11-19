<?php
// ===== Database connection =====
mysqli_report(MYSQLI_REPORT_OFF);
// EXPLAIN: What are the four values mysqli needs?
$conn = new mysqli("localhost", "root", "", "portfolio_db");
// EXPLAIN: What happens if the connection fails?
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>