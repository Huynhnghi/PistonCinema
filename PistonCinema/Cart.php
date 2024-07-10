<?php
require 'class/Database.php';
require 'class/Room.php';
require 'class/Film.php';
require 'Auth/Auth.php';
require 'class/Seat.php';
$db = new Database();
$pdo = $db->getConnect();

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); 
}

$customerID = $_GET['CODE_CUSTOMER'] ?? null;
$filmCode = $_GET['CODE_FILM'] ?? null;
if (!$customerID || !$filmCode || empty($customerID) || empty($filmCode)) {
    header("Location: error.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedSeats = $_POST['selectedSeats'] ?? null;
    $totalPrice = $_POST['totalPrice'] ?? null;

    $selectRoom = $_POST['selectedRoom'] ?? null;
}

$cus = Login::getUserByAccount($pdo, $_SESSION['username']);
$film = Film::getOneByID($pdo, $filmCode);
$room = Room::getAllRoom($pdo);
$seat = Seat::getAllSeats($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piston</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .ron {
            width: 100%;
            padding: 0;
            margin: 0px 0px 0px 10px;
            overflow: hidden;
            background: #222;
            font-weight: bold;
        }

        #content {
            color: #fff;
            padding: 20px;
        }

        h3 {
            font-size: 24px;
        }

        .main {
            width: 100%;
            max-width: 900px;
            margin: 70px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
        }

        .main h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
        }

        .main ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .main ul li {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .main ul li:nth-child(odd) {
            background-color: #e9ecef;
        }

        .main ul li:hover {
            background-color: #ced4da;
        }

        .main ul li span {
            font-weight: bold;
            color: #495057;
        }

        .main p {
            font-size: 20px;
            color: #495057;
            font-weight: bold;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .main {
                margin: 50px auto;
                padding: 20px;
            }

            .main h2 {
                font-size: 24px;
            }

            .main p {
                font-size: 18px;
            }
        }
    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;">
    <div id="wrapper">
        <?php require 'header.php'; ?>
        <br> <br>
        <div id="content" class="container">
            <div class="main">
                <h2>Chi tiết vé</h2>
                <form action="process_payment.php" method="POST">
                    <?php if (!empty($selectedSeats)) : ?>
                        <ul>
                            <?php foreach ($selectedSeats as $seat) : ?>
                                <li>
                                    <span>Tên Phim: <?= $film['NAME_FILM'] ?></span>
                                    <span>Số ghế: <?= htmlspecialchars($seat['number']) ?></span>
                                    <span><?= number_format($seat['price'], 0, ',', '.') ?> VND</span>
                                    <!-- Assuming $room is an array, you might want to access a specific room based on seat information -->
                                    <!-- If $room is not an array, adjust this accordingly -->
                                    <span>Phòng: <?= htmlspecialchars($room[$seat['room_id']]['NAME_ROOM']) ?></span>
                                    <span>Tên khách hàng: <?= $customerID['NAME_CUSTOMER'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p>Tổng giá: <?= number_format($totalPrice, 0, ',', '.') ?> VND</p>
                        <button type="submit" class="btn btn-primary">Thanh toán</button>
                        <input type="hidden" name="CODE_FILM" value="<?= $filmCode ?>">
                        <input type="hidden" name="CODE_CUSTOMER" value="<?= $customerID ?>">
                        <input type="hidden" name="selectedSeats" value='<?= htmlspecialchar($selectedSeats)?>'>
                        <input type="hidden" name="totalPrice" value='<?= htmlspecialchars($totalPrice)?>'>
                        <input type="hidden" name="selectedRoom" id="selectedRoom" value = '<?htmlspecialchars($selectedRoom)?>'>
                    <?php else : ?>
                        <p>Giỏ hàng của bạn trống.</p>
                    <?php endif; ?>
                </form>

            </div>
            </div>
        <?php require 'footer.php'; ?>
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
