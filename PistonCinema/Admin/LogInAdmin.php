<?php
    class LoginAdmin{
        public $CODE_STAFF;
        public $NAME_STAFF;
        public $ADDRESS_STAFF;
        public $SEX_STAFF;
        public $PERMISSION;
        public $ACCOUNT;
        public $PASSWORD;
        public static function checkLogin($pdo, $account, $password) {
            try {
                $sql = "SELECT PASSWORD FROM staff WHERE ACCOUNT = :account";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':account', $account, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($row) {
                    if ($password === $row['PASSWORD']) {
                        return true; 
                    } else {
                        error_log("Password mismatch for account: $account");
                    }
                } else {
                    error_log("No account found for: $account");
                }
                return false; 
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                return false; 
            }
        }
        
    }