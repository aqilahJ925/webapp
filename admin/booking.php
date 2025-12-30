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

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "storagedb";

$con = new mysqli($host, $user, $pass, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch booking history
$bookingQuery = $con->query("SELECT * FROM booking ORDER BY bookingID DESC");

// Fetch payment history
$paymentQuery = $con->query("SELECT * FROM payment ORDER BY paymentID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking & Payment History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { min-height: 100vh; background-color: #f8f9fa; }
        .sidebar { width: 250px; min-height: 100vh; background: #212529; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: #fff; }
        .content { padding: 25px; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-semibold">EasyStorage Admin</span>
    <form action="logout.php" method="POST" class="mb-0">
        <button class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </form>
</nav>

<div class="d-flex">

    <div class="sidebar">
        <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="staff.php"><i class="bi bi-people me-2"></i> Staff</a>
        <a href="users.php"><i class="bi bi-person-lines-fill me-2"></i> Users</a>
        <a href="packages.php"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php" class="active"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <div class="flex-grow-1 content">
        <h4 class="mb-4">Booking History</h4>

        <!-- Booking History -->
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white fw-semibold">Booking History</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
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
                        $i = 1;
                        while ($row = $bookingQuery->fetch_assoc()):
                            $status = $row['booking_status'];
                            $badge = 'secondary';
                            if ($status == 'Confirmed') $badge = 'success';
                            elseif ($status == 'Pending') $badge = 'warning';
                            elseif ($status == 'Cancelled') $badge = 'danger';
                        ?>
                        <tr>
                            <td><?= $row['bookingID'] ?></td>
                            <td><?= $row['userID'] ?></td>
                            <td><?= $row['packageID'] ?></td>
                            <td><?= $row['pickup_date'] ?></td>
                            <td><?= $row['return_date'] ?></td>
                            <td><span class="badge bg-<?= $badge ?>"><?= $status ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <h4 class="mb-4">Payment History</h4>

        <!-- Payment History -->
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white fw-semibold">Payment History</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Payment ID</th>
                            <th>Booking ID</th>
                            <th>Amount (RM)</th>
                            <th>Payment Method</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $j = 1;
                        while ($row = $paymentQuery->fetch_assoc()):
                            $status = $row['payment_status'];
                            $badge = 'secondary';
                            if ($status == 'Paid') $badge = 'success';
                            elseif ($status == 'Pending') $badge = 'warning';
                            elseif ($status == 'Failed') $badge = 'danger';
                        ?>
                        <tr>
                            <td><?= $row['paymentID'] ?></td>
                            <td><?= $row['bookingID'] ?></td>
                            <td><?= $row['amount'] ?></td>
                            <td><?= $row['payment_method'] ?></td>
                            <td><?= $row['payment_date'] ?></td>
                            <td><span class="badge bg-<?= $badge ?>"><?= $status ?></span></td>
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
