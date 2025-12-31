<?php 
include 'admin/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

$message = "";

if (isset($_POST['signUp'])) {

    $fullName = $_POST['fname'];
    $email    = $_POST['email'];
    $address  = $_POST['address'];
    $phone    = $_POST['phone'];
    $password = md5($_POST['password']); // keep md5 for now

    // Check email exists
    $checkEmail = "SELECT * FROM user WHERE email='$email'";
    $result = $con->query($checkEmail);

    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Email Address Already Exists!</div>";
    } else {

        // Insert user
        $insertQuery = "INSERT INTO user (name, email, address, phone_number, password)
                        VALUES ('$fullName', '$email', '$address', '$phone', '$password')";

        if ($con->query($insertQuery) === TRUE) {

            // SEND EMAIL AFTER SUCCESSFUL REGISTRATION
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'nuraqj925@gmail.com';       
                $mail->Password   = 'bzgz msbi icsk rids';    
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('nuraqj925@gmail.com', 'EasyStorage Hub');
                $mail->addAddress($email, $fullName);

                $mail->isHTML(true);
                $mail->Subject = 'Welcome to EasyStorage!';
                $mail->Body = "
                    <h3>Hi $fullName 👋</h3>
                    <p>Thank you for registering with <b>EasyStorage</b>.</p>
                    <p>You can now log in using your email.</p>
                    <br>
                    <p>Regards,<br>EasyStorage Team</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                // Email failure won't stop registration
            }

            session_start();
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: logincustomer.php");
            exit();

        } else {
            $message = "<div class='alert alert-danger'>Database Error</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Register | EasyStorage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body { background: #f8f9fa; }
        .register-card { max-width: 450px; margin: 80px auto; }
    </style>
</head>
<body>

<div class="container register-card">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h4 class="text-center mb-4">Customer Register</h4>

            <?php echo $message; ?>

            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="fname" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" name="signUp" class="btn btn-primary w-100">
                    Create Account
                </button>

                <div class="text-center mt-3">
                    <span>Already have an account?</span>
                    <a href="logincustomer.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>