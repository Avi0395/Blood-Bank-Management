<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['un']) || empty($_SESSION['un'])) {
    header("Location: index.php");
    exit();
}
$un = $_SESSION['un'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Blood List - Blood Donation System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .stock-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .header-nav {
            background: linear-gradient(to right, #d62839, #e63946);
            padding: 15px;
            border-radius: 15px 15px 0 0;
        }
        .welcome-text {
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="stock-container">
            <!-- Header with Navigation -->
            <div class="header-nav d-flex justify-content-between align-items-center px-4">
                <h2 class="text-white mb-0">
                    <i class="fas fa-heartbeat me-2"></i>
                    <a href="admin-home.php" class="text-white text-decoration-none">Blood Donation System</a>
                </h2>
                <div class="d-flex align-items-center">
                    <span class="welcome-text me-3">Welcome, <?php echo htmlspecialchars($_SESSION['un']); ?></span>
                    <a href="logout.php" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>

             <!-- Tab Navigation -->
             <ul class="nav nav-tabs px-4 pt-3 pb-2 bg-light">
                <li class="nav-item">
                    <a class="nav-link active" href="admin-home.php">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="donor-reg.php">
                        <i class="fas fa-user-plus me-1"></i> Add Donor
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="donor-list.php">
                        <i class="fas fa-list me-1"></i> Donor List
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stock-blood.php">
                        <i class="fas fa-database me-1"></i> Blood Stock
                    </a>
                </li>
            </ul>
            
            <!-- Main Content -->
            <div class="p-4">
                <h1 class="text-center">Stock Blood List</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Blood Group</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>O+</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='O+'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>O-</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='O-'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>A+</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='A+'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>A-</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='A-'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>B+</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='B+'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>B-</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='B-'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>AB+</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='AB+'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                            <tr>
                                <td>AB-</td>
                                <td><?php 
                                    $q = $db->query("SELECT * FROM donor_regis WHERE bgroup='AB-'");
                                    echo $q->rowCount(); 
                                ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>          
            </div>

            <!-- Footer -->
            <div class="bg-light p-3 text-center border-top">
                <p class="mb-0 text-muted">
                    <i class="far fa-copyright me-1"></i> 2023 Blood Donation System. All rights reserved.
                </p>
            </div>
        </div>
    </div>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


                           