<?php
require_once "admin/connection.php";

if (!isset($_GET['package'])) {
    header("Location: index.php");
    exit;
}

$packageID = (int) $_GET['package'];

// Get package
$stmt = $con->prepare("SELECT * FROM storagepackage WHERE packageID = ?");
$stmt->bind_param("i", $packageID);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();

if (!$package) {
    header("Location: index.php");
    exit;
}

// Get durations
$durations = $con->prepare(
    "SELECT * FROM package_durations WHERE packageID = ?"
);
$durations->bind_param("i", $packageID);
$durations->execute();
$duration_result = $durations->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking | EasyStorage</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<header class="header">
  <nav>
    <div class="nav__bar">
      <div class="logo nav__logo">
        <a href="index.php"><img src="assets/logo.png" alt="logo"></a>
      </div>
    </div>
    <ul class="nav__links">
      <li><a href="index.php">HOME</a></li>
    </ul>
  </nav>
</header>

<section class="section__container">
    <p class="section__subheader">BOOKING DETAILS</p>

    <h2 class="section__header">
        <?= htmlspecialchars($package['package_name']) ?>
    </h2>

                    <!-- Duration -->
                    <h4>Select Storage Duration</h4>
                    <?php while ($row = $duration_result->fetch_assoc()): ?>
                        <label style="display:block; margin:10px 0;">
                            <input type="radio" name="duration_id" value="<?= $row['duration_id'] ?>" required>
                            <?= $row['duration_type'] ?> — RM <?= $row['price'] ?>
                        </label>
                    <?php endwhile; ?>

                <!-- ADDRESS -->
                <h4>Pickup Address</h4>
                <textarea name="pickup_address"
                          required
                          placeholder="Example: Kolej Dahlia, UNIMAS"
                          style="width:100%; padding:10px;"></textarea>

                <br><br>

                <!-- DATES -->
                <label>Pickup Date</label>
                <input type="date" name="pickup_date" required>

                <br><br>

                <label>Return Date</label>
                <input type="date" name="return_date" required>

                <br><br>

                <button class="btn" type="submit">
                    Confirm Booking
                </button>

            </form>

        </div>
    </div>
</section>

<footer class="footer">
  <div class="footer__bar">
    SEG01-02 - TMF3973 Web Application Development
  </div>
</footer>

</body>

</html>
