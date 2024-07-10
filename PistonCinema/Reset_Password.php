<?php
// Kết nối CSDL
require 'class/Data'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy email từ form
    $email = $_POST["email"];

    // Validate form
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email không hợp lệ.";
    } else {
        // Kiểm tra email có tồn tại trong CSDL không
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            // Tạo token và thời gian yêu cầu reset
            $token = bin2hex(random_bytes(32));
            $timestamp = time();
            
            // Lưu token và thời gian vào CSDL
            $query = "UPDATE users SET reset_token='$token', reset_requested_at='$timestamp' WHERE email='$email'";
            mysqli_query($conn, $query);

            // Gửi email reset password
            $reset_link = "http://ten_mien_cua_ban/Reset_Password.php?email=$email&token=$token";
            // Gửi email ở đây

            echo "Email đã được gửi chứa liên kết để reset mật khẩu.";
        } else {
            echo "Email không tồn tại.";
        }
    }
}
?>

<!-- Form Forget Password -->
<form method="post" action="">
    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email"><br>
    <input type="submit" value="Submit">
</form>
