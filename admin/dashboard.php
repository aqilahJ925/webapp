<?php
require('connection.php');

function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}
adminLogin();

// Summary counts from database
$totalUsers = $con->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];
$totalStaff = $con->query("SELECT COUNT(*) AS count FROM staff")->fetch_assoc()['count'];
$totalBookings = $con->query("SELECT COUNT(*) AS total FROM booking")->fetch_assoc()['total'];
$totalRevenue = $con->query("SELECT SUM(amount) AS total FROM payment WHERE payment_status='Paid'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
        <a href="dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="staff.php"><i class="bi bi-people me-2"></i> Staff</a>
        <a href="users.php"><i class="bi bi-person-lines-fill me-2"></i> Users</a>
        <a href="packages.php"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 content">
        <h4 class="mb-4">Dashboard</h4>

        <!-- Dashboard Cards -->
        <div class="row g-4">

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Users</h6>
                            <h4 class="mb-0"><?= $totalUsers ?></h4>
                        </div>
                        <i class="bi bi-people card-icon text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Staff</h6>
                            <h4 class="mb-0"><?= $totalStaff ?></h4>
                        </div>
                        <i class="bi bi-person-badge card-icon text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Bookings</h6>
                            <h4 class="mb-0"><?= $totalBookings ?></h4>
                        </div>
                        <i class="bi bi-box-seam card-icon text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Revenue</h6>
                            <h4 class="mb-0">RM <?= number_format($totalRevenue ?? 0, 2) ?></h4>
                        </div>
                        <i class="bi bi-currency-dollar card-icon text-danger"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Bookings Table -->
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-white fw-semibold">Recent Bookings</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>User ID</th>
                            <th>Package ID</th>
                            <th>Pickup Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recentBookings = $con->query("
                            SELECT bookingID, userID, packageID, pickup_date, return_date, booking_status
                            FROM booking
                            ORDER BY bookingID DESC LIMIT 5
                        ");
                        $count = 1;
                        while($b = $recentBookings->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $b['bookingID'] ?></td>
                            <td><?= $b['userID'] ?></td>
                            <td><?= $b['packageID'] ?></td>
                            <td><?= $b['pickup_date'] ?></td>
                            <td><?= $b['return_date'] ?></td>
                            <td>
                                <?php
                                $status = $b['booking_status'];
                                $badge = 'secondary';
                                if ($status == 'Confirmed') $badge = 'success';
                                elseif ($status == 'Pending') $badge = 'warning';
                                elseif ($status == 'Cancelled') $badge = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</body>
</html>
