<?php
    class Room{
        public $CODE_ROOM;
        public $NAME_ROOM;

        public static function getAllRoom($pdo)
        {
            $sql = "SELECT * FROM room";
            $stmt = $pdo->prepare($sql);
            if($stmt->execute())
            {
                $room = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 return $room;
            }
        }

        public static function getCodeRoom($pdo)
        {
            $sql = "SELECT CODE_ROOM FROM room ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $cus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $cus;
            }
            return null;
        }
    }