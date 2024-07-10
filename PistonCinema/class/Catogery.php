<?php
    class Catogery{
        public $CODE_CATOGERY;
        public $NAME_CATOGERY;

        public static function getCategoryInfo($pdo, $CODE_CATOGERY)
        {
            $sql = "SELECT NAME_CATOGERY FROM CATOGERY_FILM WHERE CODE_CATOGERY = :CODE_CATOGERY";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":CODE_CATOGERY", $CODE_CATOGERY, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return false;
        }
    }
?>
