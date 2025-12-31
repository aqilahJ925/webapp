<?php
session_start();
require_once __DIR__ . '/../admin/connection.php';

// Fetch bookings with customer info and package info
$sql = "
SELECT 
    b.bookingID,
    u.name AS customer_name,
    u.phone_number AS customer_no,
    sp.package_name,
    b.booking_status
FROM booking b
JOIN user u ON b.userID = u.userID
JOIN storagepackage sp ON b.packageID = sp.packageID
ORDER BY u.name, b.bookingID
";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Storage Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        .card-customer {
            margin-bottom: 20px;
        }

        .card-item {
            margin-bottom: 10px;
        }
    </style>

    <script>
        function addItemRow(containerId) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
        <input type="text" name="item_name[]" class="form-control" placeholder="Item Name" required>
        <input type="file" name="item_image[]" class="form-control" onchange="previewImage(event)">
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Remove</button>
    `;
            container.appendChild(div);
        }

        // Preview image before upload
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    let preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.style.width = '80px';
                    preview.style.marginRight = '5px';
                    input.parentElement.insertBefore(preview, input);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-semibold">EasyStorage Staff</span>
        <form action="logout.php" method="POST" class="mb-0">
            <button class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
            <a href="task.php"><i class="bi bi-calendar-check me-2"></i> Assigned Task</a>
            <a href="bookitem.php" class="active"><i class="bi bi-box-seam me-2"></i> Manage Storage Item</a>
        </div>

        <div class="flex-grow-1 content">
            <h4 class="mb-4">Manage Storage Items</h4>

            <?php while ($booking = $result->fetch_assoc()): ?>
                <div class="card shadow-sm card-customer">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($booking['customer_name']) ?></strong>
                            (<?= htmlspecialchars($booking['customer_no']) ?>) |
                            Package: <?= htmlspecialchars($booking['package_name']) ?> |
                            BookingID: <?= htmlspecialchars($booking['bookingID']) ?>
                            Status:
                            <form action="update_booking_status.php" method="POST" class="d-inline">
                                <input type="hidden" name="bookingID" value="<?= $booking['bookingID'] ?>">
                                <select name="booking_status" class="form-select form-select-sm d-inline w-auto"
                                    onchange="this.form.submit()">
                                    <?php foreach ([' ', 'Stored', 'Delivered'] as $status): ?>
                                        <option value="<?= $status ?>" <?= $booking['booking_status'] == $status ? 'selected' : '' ?>>
                                            <?= $status ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">

                        <?php
                        $bid = $booking['bookingID'];
                        $itemsRes = $con->query("SELECT * FROM storageitem WHERE bookingID=$bid");
                        $items = $itemsRes->fetch_all(MYSQLI_ASSOC);
                        ?>

                        <?php if ($items): ?>
                            <?php foreach ($items as $item): ?>
                                <div class="card card-item p-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <?= htmlspecialchars($item['item_name']) ?>
                                        (<?= htmlspecialchars($item['storage_location']) ?>)
                                        <?php if (!empty($item['item_image'])): ?>
                                            <img src="<?= htmlspecialchars($item['item_image']) ?>" width="50">
                                        <?php endif; ?>
                                    </div>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editItem<?= $item['itemID'] ?>">Edit</button>
                                </div>

                                <!-- ITEM EDIT MODAL -->
                                <div class="modal fade" id="editItem<?= $item['itemID'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="update_item.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Item</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="itemID" value="<?= $item['itemID'] ?>">
                                                    <div class="mb-3">
                                                        <label>Item Name</label>
                                                        <input type="text" name="item_name" class="form-control"
                                                            value="<?= htmlspecialchars($item['item_name']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Storage Location</label>
                                                        <input type="text" name="storage_location" class="form-control"
                                                            value="<?= htmlspecialchars($item['storage_location']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Item Image</label>
                                                        <?php if (!empty($item['item_image'])): ?>
                                                            <img src="../<?= htmlspecialchars($item['item_image']) ?>" width="80"
                                                                class="img-thumbnail">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>

                                                        <input type="file" name="item_image" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No items yet. Add new items below.</p>
                        <?php endif; ?>

                        <!-- ADD MULTIPLE ITEMS FORM -->
                        <form action="update_item.php" method="POST" enctype="multipart/form-data" class="mt-3">
                            <input type="hidden" name="bookingID" value="<?= $booking['bookingID'] ?>">
                            <div class="mb-2">
                                <label>Storage Location (all items same)</label>
                                <input type="text" name="storage_location" class="form-control" required>
                            </div>
                            <div id="itemsContainer<?= $booking['bookingID'] ?>"></div>
                            <button type="button" class="btn btn-sm btn-secondary mb-2"
                                onclick="addItemRow('itemsContainer<?= $booking['bookingID'] ?>')">Add Item</button>
                            <button type="submit" class="btn btn-success btn-sm">Save Items</button>
                        </form>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>