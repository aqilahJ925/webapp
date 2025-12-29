<?php
session_start();
$success = "";

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']); // remove after showing once
}

require __DIR__ . "/config/db.php";

$error = "";

if (isset($_POST['login'])) {

    $email_input = trim($_POST['email']); 
    $password_input = trim($_POST['password']);

    if ($email_input === "" || $password_input === "") {
        $error = "Please fill in all fields.";
    } else {

        $stmt = $pdo->prepare("
            SELECT customer_id, full_name, email, password_hash
            FROM customers
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->execute([$email_input]);
        $user = $stmt->fetch();

        if ($user && password_verify($password_input, $user['password_hash'])) {

            $_SESSION['customer_id'] = (int)$user['customer_id']; // ✅ untuk booking
            $_SESSION['user_id'] = (int)$user['customer_id'];     // ✅ untuk navbar index.php
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <?= $success ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login | EasyStorage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-card {
            max-width: 420px;
            margin: 80px auto;
        }
    </style>
</head>

<body>

<div class="container" id="signIn">
    <div class="card login-card shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center mb-4">Customer Login</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" name="login" class="btn w-100">
                    Login
                </button>

                <div class="text-center mt-3">
                    <a href="index.php">← Back to Home</a>
                </div>
                
                <div class="text-center mt-3">
                    <span>Don't have an account?</span>
                    <a href="register.php">Sign Up</a>
                </div>

            </form>

        </div>
    </div>
</div>
<script src="login.js"></script>
</body>
</html>
