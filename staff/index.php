<?php
require('connection.php');

session_start();
if (isset($_SESSION['staffLogin']) && $_SESSION['staffLogin'] == true) {
    redirect('dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('links.php'); ?>
  <title>Staff Login | EasyStorage</title>

  <style>
    div.login-form {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
    }
  </style>
</head>

<body class="bg-light">

  <!-- STAFF LOGIN FORM -->
  <div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form method="POST">
      <h4 class="bg-dark text-white py-3">STAFF LOGIN PANEL</h4>

      <div class="p-4">
        <div class="mb-3">
          <input 
            name="staff_name" 
            required 
            type="text" 
            class="form-control shadow-none text-center" 
            placeholder="Staff Name"
          >
        </div>

        <div class="mb-4">
          <input 
            name="staff_pass" 
            required 
            type="password" 
            class="form-control shadow-none text-center" 
            placeholder="Password"
          >
        </div>

        <button name="login" type="submit" class="btn text-white bg-dark shadow-none w-100">
          LOGIN
        </button>
      </div>
    </form>
  </div>

<?php

/* ---------- HELPER FUNCTIONS ---------- */

function redirect($url) {
  echo "<script>window.location.href='$url';</script>";
  exit;
}

function alert($type, $msg) {
  $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

  echo <<<alert
  <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
    <strong class="me-3">$msg</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
alert;
}

/* ---------- LOGIN LOGIC ---------- */

if (isset($_POST['login'])) {

  $frm_data = filteration($_POST);

  $query = "SELECT * FROM `staff_cred` WHERE `staff_name`=? AND `staff_pass`=?";
  $values = [$frm_data['staff_name'], $frm_data['staff_pass']];

  $res = select($query, $values, "ss");

  if ($res->num_rows == 1) {
    $row = mysqli_fetch_assoc($res);

    $_SESSION['staffLogin'] = true;
    $_SESSION['staffId'] = $row['sr_no'];

    redirect('dashboard.php');
  } else {
    alert('error', 'Login failed - Invalid Staff Credentials!');
  }
}

?>

<?php require('scripts.php'); ?>
</body>
</html>
