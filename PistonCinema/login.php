<?php
require 'class/Database.php';
require 'Auth/Auth.php';
require 'Admin/LoginAdmin.php';

session_start(); // Start the session at the beginning

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $pdo = $db->getConnect();

    $account = $_POST['account'];
    $password = $_POST['password'];

    // Check login for both regular users and admin users
    $isLoggedIn = Login::checkLogin($pdo, $account, $password);
    $isLoggedInAdmin = LoginAdmin::checkLogin($pdo, $account, $password);

    if ($isLoggedIn || $isLoggedInAdmin) {
        $_SESSION['username'] = $account;

        if ($isLoggedInAdmin == 'admin' || $isLoggedInAdmin == 'admin1') {
            // Admin login
            header("Location: ./Admin/listFilm.php");
            exit;

        // }else if($isLoggedInAdmin != 'admin' && $isLoggedInAdmin != 'admin1'){
        //     header("Location: index.php");
        //     exit;
        } else {
            // Regular user login
            $user = Login::getUserByAccount($pdo, $account); // Fetch user details
            if ($user) {
                $_SESSION['username'] = $user['ACCOUNT'];
                $_SESSION['CODE_CUSTOMER'] = $user['CODE_CUSTOMER']; // Assuming 'code_customer' is the correct field
                error_log("User session set: " . print_r($_SESSION, true));
            } else {
                error_log("User not found");
            }
            // Debugging: Confirm reaching this point
            error_log("Redirecting to index.php");
            header("Location: index.php");
            exit;
        }
    } else {
        $message = "Error: Invalid account or password.";
    }
}

// Check and remove reset token if exists
if (isset($_SESSION['reset_token'])) {
    unset($_SESSION['reset_token']);
}

// Generate a new token for the current session
$reset_token = bin2hex(random_bytes(32)); 
$_SESSION['reset_token'] = $reset_token;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .row {
            background-image: linear-gradient(#fbc2eb, #a6c1ee) !important; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto; 
        }
        h2 {
            text-align: center;
            color: black; 
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
            color: black; 
        }
        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-primary {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 5px;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }
        #showPassword i {
            font-size: 18px; 
            color: #6c757d; 
        }
        #showPassword i:hover {
            color: #007bff; 
        }
    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;">
    <div id="wrapper">
        <div>
            <?php require 'header.php'; ?>
        </div>
        <div class="row" style="background: #222; margin-top:200px;">
            <h2>Login</h2>
            <?php if (!empty($message)): ?>
                <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="account">Account</label>
                    <input type="text" name="account" id="account" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <span class="input-group-append input-group-text" id="showPassword" style="background: none; border: none; cursor: pointer;">
                            <i class="fas fa-eye" style="color: #6c757d;"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div class="mt-3">
                <a href="Reset_Password.php?token=<?= htmlspecialchars($reset_token); ?>">Reset Password</a>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('showPassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var eyeIcon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>
</html>
