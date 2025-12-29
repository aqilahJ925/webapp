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

/* =====================
   UPDATE PACKAGE
===================== */
if (isset($_POST['updatePackage'])) {
    $packageID = $_POST['packageID'];
    $name = $_POST['package_name'];
    $limit = $_POST['item_limit'];
    $durations = $_POST['duration_type']; // array
    $prices = $_POST['duration_price']; // array

    // Update package info
    $stmt = $con->prepare("UPDATE storagepackage SET package_name=?, item_limit=? WHERE packageID=?");
    $stmt->bind_param("sii", $name, $limit, $packageID);
    $stmt->execute();

    // Delete old durations
    $stmtDel = $con->prepare("DELETE FROM package_durations WHERE packageID=?");
    $stmtDel->bind_param("i", $packageID);
    $stmtDel->execute();

    // Insert updated durations
    $stmtDur = $con->prepare("INSERT INTO package_durations (packageID, duration_type, price) VALUES (?, ?, ?)");
    foreach ($durations as $key => $dur) {
        $price = $prices[$key];
        $stmtDur->bind_param("isd", $packageID, $dur, $price);
        $stmtDur->execute();
    }

    header("Location: packages.php");
    exit;
}

/* =====================
   DELETE PACKAGE
===================== */
if (isset($_GET['delete'])) {
    $packageID = $_GET['delete'];

    $stmtDelDur = $con->prepare("DELETE FROM package_durations WHERE packageID=?");
    $stmtDelDur->bind_param("i", $packageID);
    $stmtDelDur->execute();

    $stmtDelPack = $con->prepare("DELETE FROM storagepackage WHERE packageID=?");
    $stmtDelPack->bind_param("i", $packageID);
    $stmtDelPack->execute();

    header("Location: packages.php");
    exit;
}

/* =====================
   FETCH PACKAGES
===================== */
$packages = $con->query("
    SELECT sp.packageID, sp.package_name, sp.item_limit,
           GROUP_CONCAT(CONCAT(pd.duration_type, ' (RM ', pd.price, ')') SEPARATOR '<br>') AS duration_info
    FROM storagepackage sp
    LEFT JOIN package_durations pd ON pd.packageID = sp.packageID
    GROUP BY sp.packageID
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Storage Packages</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
body { min-height: 100vh; background-color: #f8f9fa; }
.sidebar { width: 250px; min-height: 100vh; background: #212529; }
.sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; }
.sidebar a:hover, .sidebar a.active { background: #343a40; color: #fff; }
.content { padding: 25px; }
</style>

<script>
function addDuration(containerId) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="duration_type[]" class="form-control" placeholder="Duration" required>
        <input type="number" step="0.01" name="duration_price[]" class="form-control" placeholder="Price" required>
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(div);
}
</script>
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
        <a href="packages.php" class="active"><i class="bi bi-box-seam me-2"></i> Storage Packages</a>
        <a href="booking.php"><i class="bi bi-credit-card me-2"></i> Booking & Payments</a>
    </div>

    <div class="flex-grow-1 content">
        <h4 class="mb-4">Storage Packages</h4>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Package List</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Durations (Price)</th>
                            <th>Max Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; while($row = $packages->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['package_name']) ?></td>
                            <td><?= $row['duration_info'] ?></td>
                            <td><?= $row['item_limit'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?= $row['packageID'] ?>">Edit</button>
                                <a href="?delete=<?= $row['packageID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this package?')">Delete</a>
                            </td>
                        </tr>

                        <!-- EDIT MODAL -->
                        <?php
                        $packageID = $row['packageID'];
                        $durQuery = $con->prepare("SELECT duration_type, price FROM package_durations WHERE packageID=?");
                        $durQuery->bind_param("i", $packageID);
                        $durQuery->execute();
                        $durResult = $durQuery->get_result();
                        $durations = [];
                        while($d = $durResult->fetch_assoc()) $durations[] = $d;
                        ?>
                        <div class="modal fade" id="edit<?= $row['packageID'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Package</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="packageID" value="<?= $row['packageID'] ?>">

                                            <div class="mb-3">
                                                <label>Package Name</label>
                                                <input type="text" name="package_name" class="form-control" value="<?= $row['package_name'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Max Items</label>
                                                <input type="number" name="item_limit" class="form-control" value="<?= $row['item_limit'] ?>" required>
                                            </div>

                                            <label>Durations & Prices</label>
                                            <div id="editDurations<?= $row['packageID'] ?>">
                                                <?php foreach($durations as $d): ?>
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="duration_type[]" class="form-control" value="<?= htmlspecialchars($d['duration_type']) ?>" required>
                                                        <input type="number" step="0.01" name="duration_price[]" class="form-control" value="<?= $d['price'] ?>" required>
                                                        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Remove</button>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                            <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addDuration('editDurations<?= $row['packageID'] ?>')">Add Duration</button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary" name="updatePackage">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
