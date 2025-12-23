<?php
session_start();

$error = "";

if (isset($_POST['login'])) {

    $user_id = trim($_POST['user_id']);
    $password = trim($_POST['password']);

    if ($user_id == "" || $password == "") {
        $error = "Please fill in all fields.";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // If password is stored as plain text
            if ($password === $user['password']) {

                $_SESSION['customerLogin'] = true;
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['customerName'] = $user['name'];

                header("Location: customerdashboard.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User ID not found.";
        }
    }
}
?>

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

<div class="container" id="signup" style="display:none;">
    <div class="card login-card shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center mb-4">Customer Register</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="user_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="user_email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="user_email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone number</label>
                    <input type="tel" name="phone_number" class="form-control" required>
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
                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                    <span>Already have account?</span>
                    <button type="button" class="switch-btn p-0" id="signInButton">
                    Sign In
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

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
                    <label class="form-label">Username</label>
                    <input type="text" name="user_id" class="form-control" required>
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
                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                    <span>Don't have an account?</span>
                    <button type="button" class="switch-btn p-0" id="signUpButton">
                    Sign Up
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script src="login.js"></script>
</body>
</html>
