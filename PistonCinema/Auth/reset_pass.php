<?php
class Reset {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createResetToken($email) {
        // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE EMAIL = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(50)); // Tạo token ngẫu nhiên
            $expires = strtotime('+30 minutes'); // Token hết hạn sau 30 phút
    
            // Lưu token vào cơ sở dữ liệu
            $stmt = $this->pdo->prepare("INSERT INTO password_reset (customer_id, token, expires) VALUES ((SELECT CODE_CUSTOMER FROM customer WHERE EMAIL = :email), :token, :expires)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires', $expires);
            $stmt->execute();
    
            // Gửi email
            $this->sendResetEmail($email, $token);
    
            echo "Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.";
        } else {
            echo "Email không tồn tại trong hệ thống.";
        }
    }

    public function getEmailFromToken($token) {
        // Truy vấn email từ token trong bảng password_reset
        $stmt = $this->pdo->prepare("SELECT c.EMAIL FROM password_reset pr INNER JOIN customer c ON pr.customer_id = c.CODE_CUSTOMER WHERE pr.token = :token AND pr.expires >= NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['EMAIL'];
        } else {
            return false;
        }
    }

    public function verifyToken($token) {
        $currentDate = date("Y-m-d H:i:s");
        $stmt = $this->pdo->prepare("SELECT c.EMAIL FROM password_reset pr INNER JOIN customer c ON pr.customer_id = c.CODE_CUSTOMER WHERE pr.token = :token AND pr.expires >= :currentDate");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':currentDate', $currentDate);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['EMAIL'];
        } else {
            return false;
        }
    }

    public function resetPassword($token, $new_password) {
        $email = $this->verifyToken($token);

        if ($email) {
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            // Update user's password
            $stmt = $this->pdo->prepare("UPDATE customer SET PASSWORD = :new_password WHERE EMAIL = :email");
            $stmt->bindParam(':new_password', $new_password_hashed);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Delete the token
            $stmt = $this->pdo->prepare("DELETE FROM password_reset WHERE customer_id = (SELECT CODE_CUSTOMER FROM customer WHERE EMAIL = :email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "Mật khẩu đã được đặt lại.";
        } else {
            echo "Liên kết không hợp lệ hoặc đã hết hạn.";
        }
    }

    private function sendResetEmail($email, $token) {
        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token;
        $subject = "Đặt lại mật khẩu";
        $message = "Click vào liên kết sau để đặt lại mật khẩu của bạn: " . $resetLink;
        $headers = "From: no-reply@yourwebsite.com";

        mail($email, $subject, $message, $headers);
    }
}
?>
