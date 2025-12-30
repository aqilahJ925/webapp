<?php
require 'admin/connection.php';
session_start();

$booking_id = (int)($_GET['booking_id'] ?? 0);
if ($booking_id <= 0) die("Invalid booking.");

$stmt = $con->prepare("SELECT booking_status FROM booking WHERE bookingID = ? LIMIT 1");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if (!$row) die("Booking not found.");
$status = $row['booking_status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Payment Result | EasyStorage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

<!-- HEADER (same as booking & payment pages) -->
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

<!-- PAYMENT RESULT SECTION -->
<section class="section__container">
    <p class="section__subheader">PAYMENT STATUS</p>
    <h2 class="section__header">Payment Result</h2>
    <p class="section__description">
        Your booking payment has been processed successfully.
    </p>

    <div class="booking__grid">
        <div class="booking__card">

            <p><b>Booking ID:</b> <?= $booking_id ?></p>
            <p>
                <b>Status:</b>
                <span style="font-weight:600;text-transform:uppercase;">
                    <?= htmlspecialchars($status) ?>
                </span>
            </p>

            <br>

            <?php if ($status === 'paid'): ?>
                <p style="color:green;font-weight:600;">
                    Payment successful. Online banking has been confirmed.
                </p>
            <?php else: ?>
                <p style="color:#d97706;font-weight:600;">
                    Payment successful. Cash payment has been confirmed.
                </p>
            <?php endif; ?>

            <br>

            <a href="index.php" class="btn">
                Back to Home
            </a>

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
