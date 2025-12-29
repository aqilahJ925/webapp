<?php
require __DIR__ . "/config/db.php";

$packageID = isset($_GET['packageID']) ? (int)$_GET['packageID'] : 0;
if ($packageID <= 0) {
  die("Missing package selection. Please go back to services.");
}


$stmt = $pdo->prepare("SELECT packageID, package_name, item_limit FROM storagepackage WHERE packageID = ?");
$stmt->execute([$packageID]);
$package = $stmt->fetch();

if (!$package) {
  die("Invalid package selected.");
}


$stmt2 = $pdo->prepare("SELECT duration_id, duration_type, price FROM package_durations WHERE packageID = ? ORDER BY duration_id");
$stmt2->execute([$packageID]);
$duration_rows = $stmt2->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Booking | EasyStorage</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <header class="header">
      <nav>
        <div class="nav__bar">
          <div class="logo nav__logo">
            <a href="#"><img src="assets/logo.png" alt="logo" /></a>
          </div>
          <div class="nav__menu__btn" id="menu-btn">
            <i class="ri-menu-3-line"></i>
          </div>
        </div>
        <ul class="nav__links" id="nav-links">
          <li><a href="index.php">HOME</a></li>
          <a href="logincustomer.php" class="btn">Login</a>
        </ul>
      </nav>
    </header>

    <section class="section__container">
        <p class="section__subheader">BOOKING DETAILS</p>
        <h2 class="section__header"><?= htmlspecialchars($package['package_name']) ?></h2>
        <p class="section__description">
            Up to <?= $package['item_limit'] ?> items · Campus Pickup & Delivery
        </p>
        <div class="booking__grid">
            <div class="booking__card">

                <form method="POST" action="confirm_booking.php">

                    <input type="hidden" name="packageID" value="<?= $packageID ?>">

                    <!-- Duration -->
                    <h4>Select Storage Duration</h4>
                    <?php foreach ($duration_rows as $row): ?>
                      <label style="display:block; margin:10px 0;">
                        <input type="radio" name="duration_id" value="<?= (int)$row['duration_id'] ?>" required>
                        <?= htmlspecialchars($row['duration_type']) ?> — RM <?= number_format((float)$row['price'], 2) ?>
                    </label>
                <?php endforeach; ?>


                    <br>

                    <!-- Address -->
                    <h4>Pickup Address</h4>
                    <textarea name="pickup_address" required placeholder="Example: Kolej Dahlia, UNIMAS"
                        style="width:100%; padding:10px;"></textarea>

                    <br><br>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500;">Pickup Date</label>
                            <input type="date" class="form-control shadow-none" name="pickup_date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500;">Return Date</label>
                            <input type="date" class="form-control shadow-none" name="return_date" required>
                        </div>
                    </div>


                    <br><br>

                    <button class="btn" type="submit">
                        Confirm Booking
                    </button>

                </form>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer__bar">
            SEG01-02 - TMF3973 Web Application Development
        </div>
    </footer>

</body>
</html>