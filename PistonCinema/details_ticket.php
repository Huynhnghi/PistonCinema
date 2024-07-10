<?php
session_start();

$title = 'Chi tiết vé';
require 'class/Ticket.php';
require 'class/Database.php';

$db = new Database();
$pdo = $db->getConnect();

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$tickets = [];
if (!empty($cartItems)) {
    foreach ($cartItems as $item) {
        $ticket = Ticket::getInfoTicket($pdo, $item['CODE_TICKET']);
        if ($ticket) {
            $tickets[] = $ticket;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem chi tiết vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body { background: #000; font-family: 'Courier New', Courier, monospace; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        #wrapper { width: 100%; }
        #content { background: #222; padding: 20px; border-radius: 10px; }
        .ron { display: flex; align-items: center; margin-bottom: 20px; }
        .ron h2 { color: dark; background-color: #fc7511; font-size: 16px; line-height: 28px; margin: 0; padding: 6px 15px; position: relative; text-transform: uppercase; float: left; border-radius: 0 3px 3px 0; }
        .ron span { margin-left: 10px; }
        .main { background: #333; padding: 20px; border-radius: 10px; color: #fff; }
        .right { margin-top: 20px; }
        .card-body table { width: 100%; color: #fff; }
        .card-body table tr td { padding: 10px; }
        .card-body table tr td img { width: 65px; height: 67px; margin-left: 50px; }
    </style>
</head>
<body>
    <div id="wrapper">
        <?php require 'header.php'; ?>
        <div id="content" class="container">
            <div class="ron">
                <h2>NỘI DUNG PHIM</h2>
                <span><i class="fa-solid fa-caret-right" style="color: #fc7511; margin-top: 10px;"></i></span>
            </div>
            <hr>
            <div class="main">
                <?php if (!empty($tickets)): ?>
                    <div class="right">
                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>MÃ VÉ</td>
                                        <td>TÊN PHIM</td>
                                        <td>TÊN PHÒNG</td>
                                        <td>SỐ GHẾ</td>
                                        <td>TÊN KHÁCH HÀNG</td>
                                        <td>NGÀY MUA</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tickets as $ticket): ?>
                                        <tr>
                                            <td>
                                                <img src="Images/<?= htmlspecialchars($ticket['IMAGES']) ?>" alt="images">
                                            </td>
                                            <td><b><?= htmlspecialchars($ticket['CODE_TICKET']) ?></b></td>
                                            <td><h5 style="color: #fc7511; font-size: 35px;"><?= htmlspecialchars($ticket['NAME_FILM']) ?></h5></td>
                                            <td><b><?= htmlspecialchars($ticket['NAME_ROOM']) ?></b></td>
                                            <td><b><?= htmlspecialchars($ticket['NAME_SEAT']) ?></b></td>
                                            <td><b><?= htmlspecialchars($ticket['NAME_CUSTOMER']) ?></b></td>
                                            <td><b><?= htmlspecialchars($ticket['SALE_DATE']) ?></b></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Không có dữ liệu phim.</p>
                <?php endif; ?>
            </div>
            <?php require 'footer.php'; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 0) {
                    $('header').addClass('sticky');
                } else {
                    $('header').removeClass('sticky');
                }
            });
        });
    </script>
</body>
</html>
