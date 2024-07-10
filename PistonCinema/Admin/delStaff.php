<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require '../class/Database.php';
require '../class/Staff.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CODE_STAFF"])) {
    $db = new Database();
    $pdo = $db->getConnect();

    $codeStaffToDelete = $_POST["CODE_STAFF"];

    if (Staff::DelStaff($pdo, $codeStaffToDelete)) {
        echo "Nhân viên đã được xóa thành công.";
        header("Location: infoCus.php");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa nhân viên.";
    }
}
?>
