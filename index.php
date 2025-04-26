<?php 
// Make sure there's no whitespace or output before this
session_start();
include("connection.php"); 
 
// Process form submission before any HTML output
$loginError = false;
if (isset($_POST['sub'])) {
    $un = $_POST['un'];
    $ps = $_POST['ps'];
    $q = $db->prepare("SELECT * FROM login WHERE uname = :un AND pas = :ps");
    $q->bindValue(':un', $un);
    $q->bindValue(':ps', $ps);
    $q->execute();
    $res = $q->fetchAll(PDO::FETCH_OBJ);
    if ($res) {
        $_SESSION['un'] = $un;
        header("Location: admin-home.php");
        exit(); // Always exit after redirect
    } else {
        $loginError = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blood Donation System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('OIP (1).jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
        }
        .login-header {
            background: linear-gradient(to right, #d62839, #e63946);
            padding: 25px;
            text-align: center;
        }
        .login-body {
            padding: 35px;
        }
        .btn-login {
            background: linear-gradient(to right, #d62839, #e63946);
            border: none;
            font-weight: 600;
            letter-spacing: 0.6px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.4);
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-radius: 8px 0 0 8px;
        }
        .login-footer {
            padding: 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }
        .blood-icon {
            color: #e63946;
            margin-right: 10px;
        }
        .alert {
            border-radius: 8px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <div class="login-header">
                        <h2 class="text-white mb-0">
                            <i class="fas fa-heartbeat blood-icon"></i>
                            Blood Donation System
                        </h2>
                    </div>
                    <div class="login-body">
                        <h3 class="text-center mb-4">
                            <i class="fas fa-user-lock me-2"></i>
                            User Login
                        </h3>
                        
                        <?php if ($loginError): ?>
                        <div class='alert alert-danger d-flex align-items-center' role='alert'>
                            <i class='fas fa-exclamation-circle me-2'></i>
                            <div>Invalid username or password. Please try again.</div>
                        </div>
                        <?php endif; ?>
                        
                        <form action="" method="post">
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" name="un" placeholder="Username" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" name="ps" placeholder="Password" required>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="sub" class="btn btn-danger btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="login-footer text-center">
                        <p class="mb-0 text-muted">
                            <i class="far fa-copyright me-1"></i> 
                            2023 Blood Donation System. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>