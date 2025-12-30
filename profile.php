<?php
session_start();
require_once "admin/connection.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: logincustomer.php");
  exit();
}

$user_id = $_SESSION['user_id'];

//update profile
if (isset($_POST['update_profile'])) {
  $fullname = $_POST['name'];
  $address  = $_POST['address'];
  $contact  = $_POST['contact'];
  $email    = $_POST['email'];

  $update = $con->prepare("
    UPDATE users 
    SET name = ?, address = ?, phone_number = ?, email = ?
    WHERE userID = ?
  ");
  $update->bind_param("ssssi", $fullname, $address, $contact, $email, $user_id);
  $update->execute();
}

/* ==========================
   GET USER INFO
========================== */
$user = $con->prepare("SELECT * FROM user WHERE userID = ?");
$user->bind_param("i", $user_id);
$user->execute();
$userData = $user->get_result()->fetch_assoc();

/* ==========================
   GET BOOKING HISTORY
========================== */
$booking = $con->prepare("
  SELECT 
  b.bookingID,
  b.pickup_date,
  b.return_date,
  b.booking_status,
  p.package_name
FROM booking b
JOIN storagepackage p ON b.packageID = p.packageID
WHERE b.userID= ?
ORDER BY b.pickup_date DESC
");
$booking->bind_param("i", $user_id);
$booking->execute();
$bookingResult = $booking->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile | EasyStorage</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">

  <style>
    .profile__container {
      padding-top: 100px;
      max-width: 900px;
      margin: auto;
    }

    .profile__card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      margin-bottom: 40px;
    }

    .profile__card h3 {
      margin-bottom: 20px;
    }

    .profile__form label {
      font-weight: 600;
      display: block;
      margin-top: 15px;
    }

    .profile__form input,
    .profile__form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    .profile__form button {
      margin-top: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }

    table th {
      background: #f5f7fa;
    }

    .back__btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 30px;
      font-weight: 600;
      color: #333;
    }
  </style>
</head>
<body>

<section class="section__container profile__container">

  <a href="index.php" class="back__btn">
    <i class="ri-arrow-left-line"></i> Back to Homepage
  </a>

  <p class="section__subheader">MY ACCOUNT</p>
  <h2 class="section__header">User Profile</h2>

  <!-- ================= USER INFO ================= -->
  <div class="profile__card">
    <h3>Personal Information</h3>

    <form method="POST" class="profile__form">
      <label>Full Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>

      <label>Address</label>
      <textarea name="address" rows="3"><?= htmlspecialchars($userData['address']) ?></textarea>

      <label>Contact Number</label>
      <input type="text" name="contact" value="<?= htmlspecialchars($userData['phone_number']) ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

      <button type="submit" name="update_profile" class="btn">Update Profile</button>
    </form>
  </div>

  <!-- ================= BOOKING HISTORY ================= -->
  <div class="profile__card">
    <h3>Booking History</h3>

    <?php if ($bookingResult->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>Pickup Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Package Name</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $bookingResult->fetch_assoc()): ?>
            <tr>
              <td><?= $row['bookingID'] ?></td>
              <td><?= $row['pickup_date'] ?></td>
              <td><?= $row['return_date'] ?></td>
              <td><?= $row['booking_status'] ?></td>
              <td><?= htmlspecialchars($row['package_name']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No booking history found.</p>
    <?php endif; ?>
  </div>

  <a href="logout.php" class="btn">Logout</a>

</section>

<footer class="footer__bar">
  SEG01-02 - TMF3973 Web Application Development | NetworkClan Team
</footer>

</body>
</html>
