<?php
require 'admin/connection.php';
session_start();

$booking_id = (int) ($_GET['booking_id'] ?? 0);
$duration_id = (int) ($_GET['duration_id'] ?? 0);

if (!$booking_id || !$duration_id) {
  die("Invalid booking.");
}

// Get booking
$stmt = $con->prepare("
    SELECT b.bookingID, b.booking_status, b.packageID
    FROM booking b
    WHERE b.bookingID = ?
    LIMIT 1
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
if (!$booking)
  die("Booking not found.");

// Get duration price and type
$stmt = $con->prepare("SELECT duration_type, price FROM package_durations WHERE duration_id = ? LIMIT 1");
$stmt->bind_param("i", $duration_id);
$stmt->execute();
$duration = $stmt->get_result()->fetch_assoc();
if (!$duration)
  die("Duration not found.");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Payment | EasyStorage</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
</head>

<body>

  <!-- HEADER (same as booking page) -->
  <header class="header">
    <nav>
      <div class="nav__bar">
        <div class="logo nav__logo">
          <a href="index.php">
            <img src="assets/logo.png" alt="logo" />
          </a>
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

  <!-- PAYMENT SECTION -->
  <section class="section__container">
    <p class="section__subheader">PAYMENT</p>
    <h2 class="section__header">Booking Summary</h2>
    <p class="section__description">
      Please review your booking details and choose a payment method.
    </p>

    <div class="booking__grid">
      <div class="booking__card">

        <h2>Booking Summary</h2>
        <p>Booking ID: <?= $booking['bookingID'] ?></p>
        <p>Duration: <?= htmlspecialchars($duration['duration_type']) ?></p>
        <p style="font-size:1.2rem; font-weight:600; color: blue;">Total Amount: RM <?= number_format($duration['price'], 2) ?></p>

        <form method="POST" action="payment_process.php">
          <input type="hidden" name="booking_id" value="<?= $booking['bookingID'] ?>">
          <input type="hidden" name="duration_id" value="<?= $duration_id ?>">

            <h4>Select Payment Method</h4>

            <label style="display:block; margin:10px 0;">
              <input type="radio" name="method" value="online" required>
              Online Banking
            </label>

            <label style="display:block; margin:10px 0;">
              <input type="radio" name="method" value="cash" required>
              Cash (Pay at Counter)
            </label>

            <br>

            <button type="submit" class="btn">
              Confirm Payment
            </button>
          </form>

      </div>
    </div>
  </section>

  <!-- FOOTER (same as booking page) -->
  <footer class="footer">
    <div class="footer__bar">
      SEG01-02 - TMF3973 Web Application Development
    </div>
  </footer>

</body>

</html>