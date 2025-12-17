<?php
require('connection.php');
function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>
        window.location.href='index.php';
      </script>";
        exit;
    }
}
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }


        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #212529;
        }


        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }


        .sidebar a:hover,
        .sidebar a.active {
            background: #343a40;
            color: #fff;
        }


        .content {
            padding: 20px;
        }


        .navbar-brand {
            font-weight: 600;
        }
    </style>
</head>

<body>


    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand">EasyStorage Admin</span>


        <form action="logout.php" method="POST" class="mb-0">
            <button class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>


    <div class="d-flex">


        <!-- Sidebar -->
        <div class="sidebar">
            <a href="dashboard.php" class="active">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="staff.php">
                <i class="bi bi-people me-2"></i> Staff
            </a>
            <a href="users.php">
                <i class="bi bi-person-lines-fill me-2"></i> Users
            </a>
            <a href="packages.php">
                <i class="bi bi-box-seam me-2"></i> Storage Packages
            </a>
        </div>


        <!-- Main Content -->
        <div class="flex-grow-1 content">


            <h4 class="mb-4">Dashboard</h4>

        </div>
</body>

</html>