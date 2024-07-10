<?php
    class Login{
        public $CODE_CUSTOMER;
        public $NAME_CUSTOMER;
        public $DATE_OF_BIRTH;
        public $ADDRESS_CUSTOMER;
        public $PHONE_NUMBER;
        public $ACCOUNT;
        public $PASSWORD;
        public $EMAIL;
        public $CODE_STAFF;
        public $NAME_STAFF;
        public $ADDRESS_STAFF;
        public $PERMISSION;

        public static function addCustomer($pdo, $name, $dob, $address, $phone, $account, $password, $email) {
            try {
                $sql = "INSERT INTO CUSTOMER (NAME_CUSTOMER, DATE_OF_BIRTH, ADDRESS_CUSTOMER, PHONE_NUMBER, ACCOUNT, PASSWORD, EMAIL) 
                        VALUES (:name, :dob, :address, :phone, :account, :password, :email)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':account', $account, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
                if ($stmt->execute()) {
                    return [
                        'status' => 'success',
                        'message' => 'Customer added successfully.'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Failed to add customer.'
                    ];
                }
            } catch (PDOException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Database error: ' . $e->getMessage()
                ];
            }
        }

        public static function checkLogin($pdo, $account, $password) {
                // Kiểm tra trong bảng customer
                $sql = "SELECT PASSWORD FROM customer WHERE ACCOUNT = :account";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':account', $account, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($row) {
                    if (password_verify($password, $row['PASSWORD'])) {
                        error_log("Customer login successful for account: $account");
                        return true; // Đăng nhập thành công với customer
                    } else {
                        error_log("Customer password mismatch for account: $account");
                    }
                } else {
                    error_log("Customer account not found: $account");
                }
        }
        
        
        public static function getUserByAccount($pdo, $account) {
            $stmt = $pdo->prepare("SELECT * FROM customer WHERE ACCOUNT = :account");
            $stmt->bindParam(':account', $account, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    public static function isAccountExists($pdo, $account) {
        try {
            $sql = "SELECT COUNT(*) FROM customer WHERE ACCOUNT = :account";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':account', $account, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            return $count > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function isEmailExists($pdo, $email) {
        try {
            $sql = "SELECT COUNT(*) FROM customer WHERE EMAIL = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            return $count > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
