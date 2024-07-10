<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require '../class/Database.php';
require '../class/Ticket.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CODE_TICKET"])) {
    $db = new Database();
    $pdo = $db->getConnect();

    $codeTicketToDelete = $_POST["CODE_TICKET"];

    if (Ticket::DelCart($pdo, $codeTicketToDelete)) {
        echo "Vé đã được xóa thành công.";
        header("Location: infoCus.php");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa vé.";
    }
}
?>
