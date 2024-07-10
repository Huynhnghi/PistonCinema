<?php
    class Staff{
        public $CODE_STAFF;
        public $NAME_STAFF;
        public $ADDRESS_STAFF;
        public $SEX_STAFF;
        public $PERMISSION;
        public $ACCOUNT;
        public $PASSWORD;
        
        public static function getAllStaff($pdo)
        {
            $sql = "SELECT * FROM staff ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $staff;
            }
            return null;
        }

        public static function DelStaff($pdo, $code)
        {
            $sql = "DELETE FROM staff WHERE CODE_STAFF = :code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":code", $code, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false; 
            }
        }

        public static function addStaff($pdo, $code, $name, $dob, $address, $phone, $sex, $permission, $account, $password) {
            $sql = "INSERT INTO  staff ( CODE_STAFF ,  NAME_STAFF ,  DATE_OF_BIRTH ,  ADDRESS_STAFF ,  PHONE_NUMBER ,  SEX_STAFF ,  PERMISSION ,  ACCOUNT ,  PASSWORD ) 
                    VALUES (:code,:name,:dob,:address,:phone,:sex,:permission,:account,:password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':code', $code, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindParam(':permission', $permission, PDO::PARAM_STR);
            $stmt->bindParam(':account', $account, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            

            if ($stmt->execute()) {
                return true; // Trả về true nếu thêm khách hàng thành công
            } else {
                return false; // Trả về false nếu có lỗi xảy ra
            }
        }

        
    }