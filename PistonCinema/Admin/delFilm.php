<?php
session_start();

  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require '../class/Database.php';
require '../class/Film.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CODE_FILM"])) {
    
    $db = new Database();
    $pdo = $db->getConnect();

    $codeFilmToDelete = $_POST["CODE_FILM"];

    if (Film::DelFilm($pdo, $codeFilmToDelete)) {
        echo "Phim đã được xóa thành công.";
        header("Location: listFilm.php");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa phim.";
    }
}
?>
