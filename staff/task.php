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
body { min-height: 100vh; background-color: #f8f9fa; }
.sidebar { width: 250px; min-height: 100vh; background: #212529; }
.sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; }
.sidebar a:hover, .sidebar a.active { background: #343a40; color: #fff; }
.content { padding: 25px; }
</style>
</head>

<body>

<!-- TOP NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-semibold">EasyStorage Staff Panel</span>
    <form action="logout.php" method="POST" class="mb-0">
        <button class="btn btn-outline-light btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</nav>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="task.php" class="active"><i class="bi bi-calendar-check me-2"></i> Assigned Task</a>
        <a href="bookitem.php"><i class="bi bi-box-seam me-2"></i> Manage Storage Item</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 content">

        <!-- ================= ASSIGNED TASK SECTION ================= -->
        <div id="assigned" class="card shadow-sm mb-5">
            <div class="card-header bg-white fw-semibold">
                Assigned Task
            </div>

            <div class="card-body">

                <!-- Availability -->
                <h6 class="mb-3">Set Availability</h6>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option>Available</option>
                            <option>Busy</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-dark px-4">Update</button>
                    </div>
                </div>

                <!-- Task Table -->
                <h6 class="mb-3">My Work Schedule</h6>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-01-10</td>
                            <td>Item Pickup</td>
                            <td>UNIMAS Kolej Cempaka</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                            <td><button class="btn btn-sm btn-warning">Request Replacement</button></td>
                        </tr>
                            <td>2025-01-10</td>
                            <td>Item Pickup</td>
                            <td>UNIMAS Kolej Cempaka</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                            <td><button class="btn btn-sm btn-warning">Request Replacement</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

</body>
</html>
