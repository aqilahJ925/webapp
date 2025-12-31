<?php
require 'admin/connection.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

$booking_id = (int) ($_GET['booking_id'] ?? 0);
if ($booking_id <= 0) die("Invalid booking.");

// FETCH RECEIPT + USER EMAIL
$stmt = $con->prepare("
    SELECT 
        b.bookingID,
        b.booking_status,
        sp.package_name,
        pd.duration_type,
        p.amount,
        p.payment_status,
        p.ref_id,
        u.email,
        u.name
    FROM booking b
    JOIN user u ON b.userID = u.userID
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

if (!$receipt) die("Receipt not found.");

if ($receipt['payment_status'] === 'paid') {

    if (!isset($_SESSION['receipt_sent_' . $booking_id])) {

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'nuraqj925@gmail.com';        // YOUR GMAIL
            $mail->Password   = 'bzgz msbi icsk rids'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('nuraqj925@gmail.com', 'EasyStorage Hub');
            $mail->addAddress($receipt['email'], $receipt['name']);

            $mail->isHTML(true);
            $mail->Subject = 'EasyStorage Booking Receipt';

            $mail->Body = "
                <h3>Payment Successful ✅</h3>
                <p>Hi <b>{$receipt['name']}</b>,</p>

                <p>Thank you for your payment. Here is your booking receipt:</p>

                <hr>
                <p><b>Reference ID:</b> {$receipt['ref_id']}</p>
                <p><b>Booking ID:</b> {$receipt['bookingID']}</p>
                <p><b>Package:</b> {$receipt['package_name']}</p>
                <p><b>Duration:</b> {$receipt['duration_type']}</p>
                <p><b>Total Paid:</b> RM " . number_format($receipt['amount'], 2) . "</p>
                <p><b>Status:</b> PAID</p>

                <hr>

                <p>Please keep this email for your reference.</p>
                <p>Regards,<br><b>EasyStorage Team</b></p>
            ";

            $mail->send();

            // mark as sent
            $_SESSION['receipt_sent_' . $booking_id] = true;

        } catch (Exception $e) {
            // fail silently (do not break page)
        }
    }
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
                <p><b>Reference ID:</b> <?= $receipt['ref_id'] ?></p>
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