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
    <title>Storage Packages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
        <a href="packages.php" class="active"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Storage Packages</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                <i class="bi bi-plus-circle"></i> Add Package
            </button>
        </div>

        <!-- Package Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                Package List
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Price (RM)</th>
                            <th>Description</th>
                            <th>Max Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Starter Pack</td>
                            <td>50</td>
                            <td>Basic storage for small items</td>
                            <td>10</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPackageModal">Edit</button>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Standard Pack</td>
                            <td>100</td>
                            <td>Suitable for medium storage needs</td>
                            <td>25</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPackageModal">Edit</button>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Max Pack</td>
                            <td>180</td>
                            <td>Large storage with maximum capacity</td>
                            <td>50</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPackageModal">Edit</button>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Add Package Modal -->
<div class="modal fade" id="addPackageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        <input type="text" class="form-control" placeholder="e.g. Starter Pack">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (RM)</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Max Items</label>
                        <input type="number" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Package Modal -->
<div class="modal fade" id="editPackageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        <input type="text" class="form-control" value="Starter Pack">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (RM)</label>
                        <input type="number" class="form-control" value="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control">Basic storage for small items</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Max Items</label>
                        <input type="number" class="form-control" value="10">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
