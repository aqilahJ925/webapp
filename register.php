<?php 
include 'admin/connection.php';

$message="";

if(isset($_POST['signUp'])){
    $fullName=$_POST['fname'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    $password=md5($password);

     $checkEmail="SELECT * From user where email='$email'";
     $result=$con->query($checkEmail); 
     
     if($result->num_rows>0){
        $message = "<div class='alert alert-danger'>Email Address Already Exists!</div>";
     }
     else{
        $insertQuery="INSERT INTO user(name ,email, address, phone_number, password)
                       VALUES ('$fullName','$email','$address','$phone','$password')";
            
            if ($con->query($insertQuery) === TRUE) {
                session_start();
                $_SESSION['success'] = "Registration successful! Please login.";
                header("Location: logincustomer.php");
                exit();
            }
            else{
               $message = "<div class='alert alert-danger'>Error: " . $con->error . "</div>";
            }
     }
}

if(isset($_POST['signIn'])){
   $email=$_POST['email'];
   $password=$_POST['password'];
   $password=md5($password) ;
   
   $sql="SELECT * FROM user WHERE email='$email' and password='$password'";
   $result=$con->query($sql); 
   
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: homepage.php");
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
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