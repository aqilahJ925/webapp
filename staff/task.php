<?php
session_start();
require_once __DIR__ . '/../admin/connection.php';

// Check login
if (!isset($_SESSION['staffLogin']) || $_SESSION['staffLogin'] !== true) {
    header("Location: index.php");
    exit();
}

$staffID = $_SESSION['staffID'];

// Fetch assigned tasks for this staff
$sql = "
SELECT 
    a.taskID,
    a.task_type,
    a.task_status,
    b.pickup_date,
    b.return_date,
    b.booking_status,
    u.phone_number AS cust_no,
    u.address AS location
FROM assignedtask a
JOIN booking b ON a.bookingID = b.bookingID
JOIN user u ON b.userID = u.userID
WHERE a.staffID = ?
ORDER BY b.pickup_date ASC
";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();

$incompleteTasks = [];
$completedTasks = [];

while ($row = $result->fetch_assoc()) {
    if ($row['task_status'] === 'Completed') {
        $completedTasks[] = $row;
    } else {
        $incompleteTasks[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Panel | EasyStorage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
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

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-semibold">EasyStorage Staff Panel</span>
        <form action="logout.php" method="POST" class="mb-0">
            <button class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
            <a href="task.php" class="active"><i class="bi bi-calendar-check me-2"></i> Assigned Task</a>
            <a href="bookitem.php"><i class="bi bi-box-seam me-2"></i> Manage Storage Item</a>
        </div>

        <div class="flex-grow-1 content">

            <!-- Incomplete Tasks Section -->
            <div id="incomplete" class="card shadow-sm mb-5">
                <div class="card-header bg-white fw-semibold">Upcoming Tasks</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Task</th>
                                <th>Customer No</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($incompleteTasks)): ?>
                                <?php foreach ($incompleteTasks as $row): ?>
                                    <tr>
                                        <td><?= ($row['task_type'] == 'Pickup') ? $row['pickup_date'] : $row['return_date'] ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['task_type']) ?></td>
                                        <td><?= htmlspecialchars($row['cust_no']) ?></td>
                                        <td><?= htmlspecialchars($row['location']) ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $row['task_status'] ?></span>
                                        </td>
                                        <td>
                                            <a href="update_task.php?id=<?= $row['taskID'] ?>" class="btn btn-sm btn-dark">Mark
                                                Complete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No upcoming tasks</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Completed Tasks Section -->
            <div id="completed" class="card shadow-sm mb-5">
                <div class="card-header bg-white fw-semibold">Completed Tasks</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Task</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($completedTasks)): ?>
                                <?php foreach ($completedTasks as $row): ?>
                                    <tr>
                                        <td><?= ($row['task_type'] == 'Pickup') ? $row['pickup_date'] : $row['return_date'] ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['task_type']) ?></td>
                                        <td>Customer Location</td>
                                        <td>
                                            <span class="badge bg-success"><?= $row['task_status'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No completed tasks</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>

</html>