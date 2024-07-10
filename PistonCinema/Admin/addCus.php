<?php 
    require '../class/Database.php';
    require '../class/Customer.php';

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new Database();
        $pdo = $db->getConnect();

        
        $code = $_POST['codeCus'];
        $name = $_POST['nameCus'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $account = $_POST['account'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $result = Customer::addCustomer($pdo, $code, $name, $dob, $address, $phone, $account, $password, $email);
        if ($result) {
            
            header("Location: infoCus.php");
            exit;  
        } else {
            
            $errorMessage = "Có lỗi xảy ra khi thêm phim. Vui lòng thử lại sau.";
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khách hàng mới</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .row-2 {
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
            width: 100% !important;
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
<body>
<div class="wrapper">
    <?php if (isset($errorMessage)) : ?>
                    <p><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <h2>Thêm thông tin khách hàng</h2>
        <div class="row-2" style=" background: #222;">  
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="codeCus">Mã khách hàng:</label>
                            <input type="text" name="codeCus" id="codeCus" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="nameCus">Tên khách hàng:</label>
                            <input type="text" name="nameCus" id="nameCus" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="dob">Ngày sinh:</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="account">Tài khoản:</label>
                            <input type="text" name="account" id="account" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
    </div>
</body>
</html>




