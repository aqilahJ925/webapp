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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking & Payments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #212529;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #343a40;
            color: #fff;
        }
        .content {
            padding: 25px;
        }
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
        <a href="user.php"><i class="bi bi-person-lines-fill me-2"></i> Users</a>
        <a href="packages.php"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php" class="active"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 content">

        <h4 class="mb-4">Booking & Payment History</h4>

        <!-- Booking History -->
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white fw-semibold">
                Booking History
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Items</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nur Aisyah</td>
                            <td>Starter Pack</td>
                            <td>8</td>
                            <td>10 Aug 2025</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Mohd Hafiz</td>
                            <td>Standard Pack</td>
                            <td>20</td>
                            <td>12 Aug 2025</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Emily Tan</td>
                            <td>Max Pack</td>
                            <td>45</td>
                            <td>14 Aug 2025</td>
                            <td><span class="badge bg-danger">Cancelled</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment History -->
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                Payment History
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Amount (RM)</th>
                            <th>Payment Method</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nur Aisyah</td>
                            <td>Starter Pack</td>
                            <td>50</td>
                            <td>Online Banking</td>
                            <td>10 Aug 2025</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Mohd Hafiz</td>
                            <td>Standard Pack</td>
                            <td>100</td>
                            <td>Credit Card</td>
                            <td>12 Aug 2025</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Emily Tan</td>
                            <td>Max Pack</td>
                            <td>180</td>
                            <td>E-Wallet</td>
                            <td>14 Aug 2025</td>
                            <td><span class="badge bg-danger">Failed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
