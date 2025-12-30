<?php
require 'admin/connection.php';
session_start();

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) {
    die("Invalid booking.");
}

$stmt = $con->prepare("
    SELECT b.bookingID, b.booking_status,
           pd.duration_type, pd.price
    FROM booking b
    LEFT JOIN package_durations pd ON pd.packageID = b.packageID
    WHERE b.bookingID = ?
    LIMIT 1
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}
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

            <!-- Booking Info -->
            <p><b>Booking ID:</b> <?= (int)$booking['bookingID'] ?></p>
            <p><b>Storage Duration:</b> <?= htmlspecialchars($booking['duration_type']) ?></p>
            <p style="font-size:1.2rem; font-weight:600; color: blue;">
                Total Amount: RM <?= number_format($booking['price'], 2) ?>
            </p>

            <br>

            <!-- Payment Form -->
            <form method="POST" action="payment_process.php">
                <input type="hidden" name="booking_id" value="<?= (int)$booking['bookingID'] ?>">

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
