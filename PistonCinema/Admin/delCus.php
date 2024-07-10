<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require '../class/Database.php';
require '../class/Customer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CODE_CUSTOMER"])) {
    $db = new Database();
    $pdo = $db->getConnect();

    $codeCustomerToDelete = $_POST["CODE_CUSTOMER"];

    if (Customer::DelCus($pdo, $codeCustomerToDelete)) {
        echo "Khách hàng đã được xóa thành công.";
        header("Location: infoCus.php");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa khách hàng.";
    }
}
?>
