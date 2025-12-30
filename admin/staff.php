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

// Fetch staff data
$staffResult = $con->query("SELECT * FROM staff");

// Summary counts
$totalStaff = $con->query("SELECT COUNT(*) AS count FROM staff")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
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
        <a href="staff.php" class="active"><i class="bi bi-people me-2"></i> Staff</a>
        <a href="users.php"><i class="bi bi-person-lines-fill me-2"></i> Users</a>
        <a href="packages.php"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 content">
        <h4 class="mb-4">Staff Management</h4>

        <!-- Summary Card -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Staff</h6>
                            <h4 class="mb-0"><?= $totalStaff ?></h4>
                        </div>
                        <i class="bi bi-people card-icon text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Staff Button -->
        <div class="mb-3 d-flex justify-content-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="bi bi-person-plus"></i> Add Staff
            </button>
        </div>

        <!-- Add Staff Modal -->
        <div class="modal fade" id="addStaffModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="add_staff.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="staff_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="staff_email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="staff_phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Add Staff</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Assign Task Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Assign Task</div>
            <div class="card-body">
                <form action="assign_task.php" method="POST" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Booking</label>
                        <select name="bookingID" class="form-select" required>
                            <option value="">-- Select Booking --</option>
                            <?php
                            $bookings = $con->query("SELECT bookingID FROM booking WHERE booking_status != 'Delivered'");
                            while($b = $bookings->fetch_assoc()):
                            ?>
                                <option value="<?= $b['bookingID'] ?>">Booking #<?= $b['bookingID'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Task Type</label>
                        <select name="task_type" class="form-select" required>
                            <option value="">-- Select Task --</option>
                            <option value="Collect">Collect</option>
                            <option value="Deliver">Deliver</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Assign Staff</label>
                        <select name="staffID" class="form-select" required>
                            <option value="">-- Select Staff --</option>
                            <?php
                            $staffList = $con->query("SELECT staffID, staff_name FROM staff");
                            while($s = $staffList->fetch_assoc()):
                            ?>
                                <option value="<?= $s['staffID'] ?>"><?= htmlspecialchars($s['staff_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Assign Task</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Assigned Tasks Table -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Assigned Tasks</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Staff Name</th>
                            <th>Task Type</th>
                            <th>Task Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $assigned = $con->query("
                            SELECT a.taskID, a.bookingID, s.staff_name, a.task_type, a.task_status
                            FROM assignedtask a
                            JOIN staff s ON a.staffID = s.staffID
                            ORDER BY a.taskID DESC
                        ");
                        if($assigned->num_rows > 0):
                            $i = 1;
                            while($row = $assigned->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row['bookingID'] ?></td>
                                <td><?= htmlspecialchars($row['staff_name']) ?></td>
                                <td><?= $row['task_type'] ?></td>
                                <td><?= $row['task_status'] ?></td>
                            </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                            <tr><td colspan="5" class="text-center">No tasks assigned yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Staff Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Staff List</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Staff Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($staffResult->num_rows > 0): ?>
                            <?php $i = 1; while($row = $staffResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['staff_name']) ?></td>
                                    <td><?= htmlspecialchars($row['staff_email']) ?></td>
                                    <td><?= htmlspecialchars($row['staff_phone']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['staffID'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="if(confirm('Delete this staff?')) { window.location='delete_staff.php?id=<?= $row['staffID'] ?>'; }">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $row['staffID'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="edit_staff.php" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Staff</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="staffID" value="<?= $row['staffID'] ?>">

                                                    <div class="mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" name="staff_name" class="form-control"
                                                               value="<?= htmlspecialchars($row['staff_name']) ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="staff_email" class="form-control"
                                                               value="<?= htmlspecialchars($row['staff_email']) ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Phone</label>
                                                        <input type="text" name="staff_phone" class="form-control"
                                                               value="<?= htmlspecialchars($row['staff_phone']) ?>" required>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No staff found.</td>
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
