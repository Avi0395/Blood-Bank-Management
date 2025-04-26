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
    <title>Admin Dashboard - Blood Donation System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
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
        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }
        .card-icon {
            font-size: 3rem;
            color: #e63946;
        }
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card-link:hover {
            color: inherit;
        }
        .dashboard-stats {
            background-color: rgba(230, 57, 70, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #e63946;
        }
        .stats-label {
            font-size: 1rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .nav-link.active {
            background-color: #e63946 !important;
            border-color: #e63946 !important;
            color: white !important;
        }
        .nav-link {
            color: #e63946;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="admin-container">
            <!-- Header with Navigation -->
            <div class="header-nav d-flex justify-content-between align-items-center px-4">
                <h2 class="text-white mb-0">
                    <i class="fas fa-heartbeat me-2"></i>
                    <a href="admin-home.php" class="text-white text-decoration-none">Blood Donation System</a>
                </h2>
                <div class="d-flex align-items-center">
                    <span class="welcome-text me-3">Welcome, <?php echo htmlspecialchars($un); ?></span>
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
                <div class="mb-4">
                    <h3>
                        <i class="fas fa-tachometer-alt me-2 text-danger"></i>
                        Admin Dashboard
                    </h3>
                    <p class="text-muted">Manage blood donation system activities and monitor statistics.</p>
                </div>
                
                <!-- Quick Stats Row -->
                <div class="row dashboard-stats mb-4">
                    <div class="col-md-3 col-sm-6 text-center">
                        <div class="stats-number">
                            <?php
                            // Get total donors count
                            $q = $db->query("SELECT COUNT(*) as total FROM donor_regis");
                            $donor_count = $q->fetch(PDO::FETCH_OBJ)->total ?? 0;
                            echo number_format($donor_count);
                            ?>
                        </div>
                        <div class="stats-label">Total Donors</div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center">
                        <div class="stats-number">
                            <?php
                            // Get blood units in stock - modify this to match your actual table structure
                            $q = $db->query("SELECT COUNT(*) as total FROM donor_regis");
                            $stock_count = $q->fetch(PDO::FETCH_OBJ)->total ?? 0;
                            echo number_format($stock_count);
                            ?>
                        </div>
                        <div class="stats-label">Blood Units</div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center">
                        <div class="stats-number">
                            <?php
                            // Most common blood type - modify query to match your structure
                            $q = $db->query("SELECT bgroup, COUNT(*) as count FROM donor_regis GROUP BY bgroup ORDER BY count DESC LIMIT 1");
                            $result = $q->fetch(PDO::FETCH_OBJ);
                            echo $result ? $result->bgroup : 'N/A';
                            ?>
                        </div>
                        <div class="stats-label">Common Blood Type</div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center">
                        <div class="stats-number">
                            <?php
                            // Recent donations count (last 30 days) - modify to match structure
                            $q = $db->query("SELECT COUNT(*) as total FROM donor_regis WHERE registration_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
                            $recent_count = $q->fetch(PDO::FETCH_OBJ)->total ?? 0;
                            echo number_format($recent_count);
                            ?>
                        </div>
                        <div class="stats-label">Recent Donations</div>
                    </div>
                </div>
                
                <!-- Main Actions Cards -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="donor-reg.php" class="card-link">
                            <div class="dashboard-card">
                                <div class="card-body text-center p-4">
                                    <div class="card-icon mb-3">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <h4 class="card-title">Donor Registration</h4>
                                    <p class="card-text text-muted">Register new blood donors with complete details.</p>
                                    <div class="mt-3">
                                        <span class="btn btn-outline-danger">Add New Donor</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-4">
                        <a href="donor-list.php" class="card-link">
                            <div class="dashboard-card">
                                <div class="card-body text-center p-4">
                                    <div class="card-icon mb-3">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <h4 class="card-title">Donor List</h4>
                                    <p class="card-text text-muted">View and manage all registered blood donors.</p>
                                    <div class="mt-3">
                                        <span class="btn btn-outline-danger">View Donors</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-4">
                        <a href="stock-blood.php" class="card-link">
                            <div class="dashboard-card">
                                <div class="card-body text-center p-4">
                                    <div class="card-icon mb-3">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <h4 class="card-title">Blood Stock</h4>
                                    <p class="card-text text-muted">Check available blood units by blood group.</p>
                                    <div class="mt-3">
                                        <span class="btn btn-outline-danger">View Stock</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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