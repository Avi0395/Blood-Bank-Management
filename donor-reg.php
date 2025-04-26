<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['un']) || empty($_SESSION['un'])) {
    header("Location: index.php");
    exit();
}
$un = $_SESSION['un'];
// Process form submission
$registrationStatus = '';
if (isset($_POST['sub'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    $bgroup = $_POST['bgroup'];
    $mno = $_POST['mno'];
    $email = $_POST['email'];

    $q = $db->prepare("INSERT INTO donor_regis (name, address, city, age, bgroup, mno, email) 
    VALUES (:name, :address, :city, :age, :bgroup, :mno, :email)");
    $q->bindValue(':name', $name);
    $q->bindValue(':address', $address);
    $q->bindValue(':city', $city);
    $q->bindValue(':age', $age);
    $q->bindValue(':bgroup', $bgroup);
    $q->bindValue(':mno', $mno);
    $q->bindValue(':email', $email);

    if ($q->execute()) {
        $registrationStatus = 'success';
    } else {
        $registrationStatus = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration - Blood Donation System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .donor-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 500;
        }
        .blood-group-select {
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
        .nav-link.active {
            background-color: #e63946 !important;
            border-color: #e63946 !important;
            color: white !important;
        }
        .nav-link {
            color: #e63946;
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
        <div class="donor-container">
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
                <!-- Alert Messages -->
                <?php if ($registrationStatus === 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Donor registration was successful!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($registrationStatus === 'error'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> Donor registration failed. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-user-plus me-2 text-danger"></i> Donor Registration Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="row g-3">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="age" class="form-label">Age</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="number" class="form-control" id="age" name="age" min="18" max="65" placeholder="Age (18-65)" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="bgroup" class="form-label">Blood Group</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                    <select class="form-select blood-group-select" id="bgroup" name="bgroup" required>
                                        <option value="">Select Blood Group</option>
                                        <option value="O+">O Positive (O+)</option>
                                        <option value="O-">O Negative (O-)</option>
                                        <option value="A+">A Positive (A+)</option>
                                        <option value="A-">A Negative (A-)</option>
                                        <option value="B+">B Positive (B+)</option>
                                        <option value="B-">B Negative (B-)</option>
                                        <option value="AB+">AB Positive (AB+)</option>
                                        <option value="AB-">AB Negative (AB-)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="mno" class="form-label">Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" id="mno" name="mno" placeholder="Enter mobile number" required>
                                </div>
                            </div>
                            
                            <!-- Address Information -->
                            <div class="col-md-8">
                                <label for="address" class="form-label">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter full address" required></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                    <button type="submit" name="sub" class="btn btn-danger px-4">
                                        <i class="fas fa-save me-1"></i> Register Donor
                                    </button>
                                </div>
                            </div>
                        </form>
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