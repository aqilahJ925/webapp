<?php
require('connection.php');

/* ================== ADMIN SESSION CHECK ================== */
function adminLogin() {
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true)) {
        echo "<script>window.location.href='index.php';</script>";
        exit;  
    }
}
adminLogin();

/* ================== DASHBOARD SUMMARY ================== */
$totalUsers = $con->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];
$totalStaff = $con->query("SELECT COUNT(*) AS total FROM staff")->fetch_assoc()['total'];
$totalBookings = $con->query("SELECT COUNT(*) AS total FROM booking")->fetch_assoc()['total'];
$totalRevenue = $con->query("SELECT SUM(amount) AS total FROM payment WHERE LOWER(payment_status)='paid'")->fetch_assoc()['total'] ?? 0;
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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body { background-color: #f8f9fa; min-height: 100vh; }
.sidebar { width: 250px; background: #212529; min-height: 100vh; }
.sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; }
.sidebar a:hover, .sidebar a.active { background: #343a40; color: #fff; }
.content { padding: 25px; }
.card-icon { font-size: 2rem; opacity: 0.7; }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-semibold">EasyStorage Admin</span>
    <form action="logout.php" method="POST" class="mb-0">
        <button class="btn btn-outline-light btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</nav>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="staff.php"><i class="bi bi-people me-2"></i> Staff</a>
        <a href="users.php"><i class="bi bi-person-lines-fill me-2"></i> Users</a>
        <a href="packages.php"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 content">

        <h4 class="mb-4">Dashboard</h4>

        <!-- SUMMARY CARDS -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Users</h6>
                            <h4><?= $totalUsers ?></h4>
                        </div>
                        <i class="bi bi-people card-icon text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Staff</h6>
                            <h4><?= $totalStaff ?></h4>
                        </div>
                        <i class="bi bi-person-badge card-icon text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Bookings</h6>
                            <h4><?= $totalBookings ?></h4>
                        </div>
                        <i class="bi bi-box-seam card-icon text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Revenue</h6>
                            <h4>RM <?= number_format($totalRevenue, 2) ?></h4>
                        </div>
                        <i class="bi bi-currency-dollar card-icon text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- REVENUE CHART -->
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <span>Revenue Overview</span>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary active" onclick="loadRevenue('daily', this)">Daily</button>
                    <button class="btn btn-outline-primary" onclick="loadRevenue('weekly', this)">Weekly</button>
                    <button class="btn btn-outline-primary" onclick="loadRevenue('monthly', this)">Monthly</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="90"></canvas>
            </div>
        </div>

        <!-- RECENT BOOKINGS -->
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-white fw-semibold">Recent Bookings</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Pickup Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recentBookings = $con->query("
                            SELECT b.bookingID, u.name AS user_name, p.package_name, b.pickup_date, b.return_date, b.booking_status
                            FROM booking b
                            JOIN user u ON b.userID = u.userID
                            JOIN storagepackage p ON b.packageID = p.packageID
                            ORDER BY b.bookingID DESC
                            LIMIT 5
                        ");
                        while ($b = $recentBookings->fetch_assoc()):
                            $badge = 'secondary';
                            if ($b['booking_status'] === 'Confirmed') $badge = 'success';
                            elseif ($b['booking_status'] === 'Pending') $badge = 'warning';
                            elseif ($b['booking_status'] === 'Cancelled') $badge = 'danger';
                        ?>
                        <tr>
                            <td><?= $b['bookingID'] ?></td>
                            <td><?= htmlspecialchars($b['user_name']) ?></td>
                            <td><?= htmlspecialchars($b['package_name']) ?></td>
                            <td><?= $b['pickup_date'] ?></td>
                            <td><?= $b['return_date'] ?></td>
                            <td><span class="badge bg-<?= $badge ?>"><?= $b['booking_status'] ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- REVENUE CHART SCRIPT -->
<script>
let revenueChart;

function loadRevenue(type, btn) {
    document.querySelectorAll('.btn-group button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    fetch('revenue_data.php?type=' + type)
        .then(res => res.json())
        .then(data => {
            if (!data.labels || !data.values) return;

            if (revenueChart) revenueChart.destroy();

            const ctx = document.getElementById('revenueChart').getContext('2d');
            revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Revenue (RM)',
                        data: data.values,
                        backgroundColor: 'rgba(13,110,253,0.6)',
                        borderColor: 'rgba(13,110,253,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'RM ' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Revenue (RM)' }
                        }
                    }
                }
            });
        })
        .catch(err => console.error(err));
}

// Load default daily chart
document.addEventListener("DOMContentLoaded", () => {
    loadRevenue('daily', document.querySelector('.btn-group button.active'));
});
</script>

</body>
</html>
