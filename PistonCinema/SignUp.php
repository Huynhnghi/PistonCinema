<?php
    // Include database connection and Customer class
    require 'class/Database.php';
    require 'Auth/Auth.php';

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new Database();
        $pdo = $db->getConnect();

        // Retrieve form data
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $account = $_POST['account'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if (Login::isAccountExists($pdo, $account)) {
            $message = "Error: Account already exists.";
        } elseif (Login::isEmailExists($pdo, $email)) {
            $message = "Error: Email already exists.";
        } else {
            $result = Login::addCustomer($pdo, $name, $dob, $address, $phone, $account, $password, $email);

            if ($result['status'] == 'success') {
                header("Location: login.php?message=" . urlencode("Đăng ký tài khoản thành công. Vui lòng đăng nhập."));
                exit;
            } else {
                $message = "Error: " . $result['message'];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .row {
            background-image: linear-gradient(#fbc2eb, #a6c1ee) !important; 
            color: #fff !important;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 700px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #000; 
        }

        .form-group label {
            font-weight: bold;
            color: #000 !important; 
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

    </style>
</head>
<body>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;  ">
    <div id="wrapper">
        <div>
            <?php require 'header.php'; ?>
        </div>
        <div class="row" style=" background: #222; margin-top:200px;">
            <h2>Đăng ký</h2>
            <?php if (!empty($message)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form action="SignUp.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="account">Account</label>
                    <input type="text" name="account" id="account" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
            </div>
    </div>
            </div>
</body>
    
</div>
</body>
</html>
