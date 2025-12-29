<?php
// Session protection
function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}
adminLogin();

require "connection.php";

// Fetch users
$userResult = $con->query("SELECT userID, name, email, address, phone_number FROM user");

// Summary count
$totalUsers = $con->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { min-height: 100vh; background-color: #f8f9fa; }
.sidebar { width: 250px; min-height: 100vh; background: #212529; }
.sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; }
.sidebar a:hover, .sidebar a.active { background: #343a40; color: #fff; }
.content { padding: 25px; }
.card-icon { font-size: 2rem; opacity: 0.7; }
</style>
</head>

<body>

<!-- Top Navbar -->
<nav class="navbar navbar-dark bg-dark px-4">
<span class="navbar-brand fw-semibold">EasyStorage Admin</span>
<form action="logout.php" method="POST" class="mb-0">
<button class="btn btn-outline-light btn-sm">
<i class="bi bi-box-arrow-right"></i> Logout
</button>
</form>
</nav>

<div class="d-flex">

<!-- Sidebar -->
<div class="sidebar">
<a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
<a href="staff.php"><i class="bi bi-people me-2"></i> Staff</a>
<a href="user.php" class="active"><i class="bi bi-person-lines-fill me-2"></i> Users</a>
<a href="packages.php"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
<a href="booking.php"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
</div>

<!-- Main Content -->
<div class="flex-grow-1 content">

<h4 class="mb-4">User Management</h4>

<!-- Summary Card -->
<div class="row g-4 mb-4">
<div class="col-md-4">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">
<div>
<h6 class="text-muted">Total Users</h6>
<h4 class="mb-0"><?= $totalUsers ?></h4>
</div>
<i class="bi bi-people card-icon text-primary"></i>
</div>
</div>
</div>
</div>

<!-- User Table -->
<div class="card shadow-sm">
<div class="card-header bg-white fw-semibold">User List</div>

<div class="card-body p-0">
<table class="table table-hover mb-0">
<thead class="table-light">
<tr>
<th>#</th>
<th>User Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
</tr>
</thead>
<tbody>

<?php if ($userResult->num_rows > 0): ?>
<?php $i = 1; while ($row = $userResult->fetch_assoc()): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['phone_number']) ?></td>
<td><?= htmlspecialchars($row['address']) ?></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-center">No users found.</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>
</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
