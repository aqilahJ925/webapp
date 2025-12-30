<?php
require 'admin/connection.php';
session_start();

$booking_id = (int) ($_GET['booking_id'] ?? 0);
if ($booking_id <= 0)
    die("Invalid booking.");


$stmt = $con->prepare("
    SELECT 
        b.bookingID,
        b.booking_status,
        sp.package_name,
        pd.duration_type,
        p.amount,
        p.payment_status
    FROM booking b
    JOIN storagepackage sp ON b.packageID = sp.packageID
    JOIN payment p ON b.bookingID = p.bookingID
    JOIN package_durations pd 
        ON pd.packageID = b.packageID 
       AND pd.price = p.amount
    WHERE b.bookingID = ?
    LIMIT 1
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$receipt = $result->fetch_assoc();

if (!$receipt) {
    die("Receipt not found.");
}
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

                <h3 style="margin-bottom:15px;">Payment Receipt</h3>

                <p><b>Booking ID:</b> <?= $receipt['bookingID'] ?></p>
                <p><b>Package:</b> <?= htmlspecialchars($receipt['package_name']) ?></p>
                <p><b>Duration:</b> <?= htmlspecialchars($receipt['duration_type']) ?></p>

                <hr style="margin:15px 0;">

                <p style="font-size:1.2rem;font-weight:600;color:blue;">
                    Total Amount: RM <?= number_format($receipt['amount'], 2) ?>
                </p>

                <p>
                    <b>Payment Status:</b>
                    <span style="font-weight:600;text-transform:uppercase;
        color:<?= $receipt['payment_status'] === 'paid' ? 'green' : '#d97706' ?>">
                        <?= htmlspecialchars($receipt['payment_status']) ?>
                    </span>
                </p>

                <br>

                <?php if ($receipt['payment_status'] === 'paid'): ?>
                    <p style="color:green;font-weight:600;">
                        ✔ Payment successful. Thank you for choosing EasyStorage.
                    </p>
                <?php else: ?>
                    <p style="color:#d97706;font-weight:600;">
                        ⏳ Please complete your cash payment during pick-up.
                    </p>
                <?php endif; ?>

                <br>

                <a href="index.php" class="btn">Back to Home</a>

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