<?php

    class Database{
        public function getConnect()
        {
            $host = "localhost";
            $db = "db_cinema";
            $username = "db_mainCINEMa";
            $password = "119741";
            
            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            try{
                $pdo = new PDO($dsn, $username, $password);
                if($pdo)
                {
                    return $pdo;
                }
            }catch(PDOException $ex)
            {
                echo $ex->getMessage();
                exit;
            }
        }
        
    }