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
.table th, .table td { vertical-align: middle; }
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
        <a href="task.php"><i class="bi bi-calendar-check me-2"></i> Assigned Task</a>
        <a href="bookitem.php" class="active"><i class="bi bi-box-seam me-2"></i> Manage Storage Item</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 content">

        <!-- ================= MANAGE STORAGE ITEM ================= -->
        <div id="storage" class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                Manage Storage Item
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ali</td>
                            <td>Suitcase (2)</td>
                            <td>Standard Pack</td>
                            <td><span class="badge bg-warning">Pending Pickup</span></td>
                            <td>
                                <select class="form-select form-select-sm">
                                    <option>Collected</option>
                                    <option>Stored</option>
                                    <option>Delivered</option>
                                </select>
                            </td>
<td>
    <button class="btn btn-sm btn-primary me-2" title="Add Picture">
        <i class="bi bi-image"></i>
    </button>
    <button class="btn btn-sm btn-secondary" title="Update Info">
        <i class="bi bi-pencil"></i>
    </button>
</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Siti</td>
                            <td>Box (5)</td>
                            <td>Starter Pack</td>
                            <td><span class="badge bg-info">In Storage</span></td>
                            <td>
                                <select class="form-select form-select-sm">
                                    <option>Stored</option>
                                    <option>Out for Delivery</option>
                                    <option>Delivered</option>
                                </select>
                            </td>
<td>
    <button class="btn btn-sm btn-primary me-2" title="Add Picture">
        <i class="bi bi-image"></i>
    </button>
    <button class="btn btn-sm btn-secondary" title="Update Info">
        <i class="bi bi-pencil"></i>
    </button>
</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
