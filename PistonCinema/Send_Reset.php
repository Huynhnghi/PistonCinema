<?php
session_start();
require 'db_connection.php';
require 'Reset.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $reset = new Reset($pdo); // Pass the PDO connection
    $reset->requestReset($email);
}
?>
