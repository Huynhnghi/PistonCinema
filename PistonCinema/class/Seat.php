<?php
    class Seat {
        public $CODE_SEAT;
        public $NAME_SEAT;
        public $PRICE;
        public static function getAllSeats($pdo) {
            $sql = "SELECT * FROM seat";
            $stmt = $pdo->prepare($sql);
            if($stmt->execute())
            {
                $seat = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 return $seat;
            }
        
        }
        public static function getCodeSeat($pdo)
        {
            $sql = "SELECT CODE_SEAT FROM seat ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $cus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $cus;
            }
            return null;
        }

        public static function selectedSeats($selectedSeatNames, $customerID, $filmCode, $pdo) {
            try {
                if (!is_array($selectedSeatNames) || empty($selectedSeatNames)) {
                    throw new Exception("Không có ghế đặt hoặc dữ liệu không hợp lệ");
                }
                $sql = "UPDATE seat SET STATUS = 'Đã đặt' WHERE NAME_SEAT = ?";
                $stmt = $pdo->prepare($sql);
        
                foreach ($selectedSeatNames as $seatName) {
                    $stmt->execute([$seatName]);
                }
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        
        

        public static function getNameSeat($pdo)
        {
            $sql = "SELECT NAME_SEAT FROM seat";
            $stmt = $pdo->query($sql);

            if ($stmt->execute()) {
                $seat = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $seat;
            }
            return [];
        }
        
        public static function calculateTotalPrice($selectedSeatNames, $pdo) {
            $totalPrice = 0;
            foreach ($selectedSeatNames as $seatNumber) {
                $stmt = $pdo->prepare("SELECT PRICE FROM seat WHERE NAME_SEAT = ?");
                $stmt->execute([$seatNumber]);
                $price = $stmt->fetchColumn();
                $totalPrice += $price;
            }
            return $totalPrice;
        }
        
    }
    