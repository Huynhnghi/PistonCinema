<?php
    class Customer{
        public $CODE_CUSTOMER;
        public $NAME_CUSTOMER;
        public $DATE_OF_BIRTH;
        public $ADDRESS_CUSTOMER;
        public $PHONE_NUMBER;
        public $ACCOUNT;
        public $PASSWORD;
        public $EMAIL;
        
        public static function getAllCus($pdo)
        {
            $sql = "SELECT * FROM customer ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $cus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $cus;
            }
            return null;
        }
        public static function getCodeCus($pdo)
        {
            $sql = "SELECT CODE_CUSTOMER FROM customer ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $cus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $cus;
            }
            return null;
        }

        public static function DelCus($pdo, $code)
        {
            $sql = "DELETE FROM customer WHERE CODE_CUSTOMER = :code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":code", $code, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false; 
            }
        }

        

        public static function addCustomer($pdo, $code, $name, $dob, $address, $phone, $account, $password, $email) {
                $sql = "INSERT INTO customer (CODE_CUSTOMER, NAME_CUSTOMER, DATE_OF_BIRTH, ADDRESS_CUSTOMER, PHONE_NUMBER, ACCOUNT, PASSWORD, EMAIL) 
                        VALUES (:code, :name, :dob, :address, :phone, :account, :password, :email)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':code', $code, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':account', $account, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                

                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;  
                }
        }
}