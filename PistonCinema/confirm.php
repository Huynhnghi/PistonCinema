<?php
session_start();
$room = $_POST['room'];
$selected_seats = $_SESSION['selected_seats'];
$film_id = $_SESSION['film_id'];
$customer_id = 1; // Lấy từ tài khoản đăng nhập
$sale_date = date('Y-m-d H:i:s');

// Kết nối cơ sở dữ liệu và thêm vé
$conn = new mysqli('localhost', 'username', 'password', 'database');
foreach ($selected_seats as $seat) {
    $stmt = $conn->prepare("INSERT INTO Ticket (CODE_CUSTOMER, CODE_SEAT, SALE_DATE, CODE_ROOM, CODE_FILM) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisii", $customer_id, $seat, $sale_date, $room, $film_id);
    $stmt->execute();
}
$stmt->close();
$conn->close();

echo "Đặt vé thành công!";
?>
