<?php
require 'class/Seat.php';
require 'class/Database.php';
require 'class/Film.php';
require 'Auth/Auth.php';

$db = new Database();
$pdo = $db->getConnect();

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); // After redirecting, exit to prevent further execution
}

$customerID = $_GET['CODE_CUSTOMER'] ?? null;
$filmCode = $_GET['CODE_FILM'] ?? null;

if (!$customerID || !$filmCode) {
    die("Customer ID or Film Code is missing.");
}
$cus = Login::getUserByAccount($pdo, $_SESSION['username']);
$film = Film::getOneByID($pdo, $filmCode);
$seats = Seat::getAllSeats($pdo);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Ghế Xem Phim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        
        .seat-main{
            background-color: #222;
            border: 1px solid #ced4da;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        @keyframes glow {
            0% {
                box-shadow: 0 0 5px purple, 0 0 10px purple, 0 0 15px purple, 0 0 20px purple, 0 0 25px purple;
            }
            50% {
                box-shadow: 0 0 10px purple, 0 0 20px purple, 0 0 30px purple, 0 0 40px purple, 0 0 50px purple;
            }
            100% {
                box-shadow: 0 0 5px purple, 0 0 10px purple, 0 0 15px purple, 0 0 20px purple, 0 0 25px purple;
            }
        }
        table {
            margin: 0 auto;
        }
        .seat {
            width: 50px;
            height: 50px;
            margin: 5px;
            cursor: pointer;
            border: 1px solid pink;
            border-radius: 5px;
            text-align: center;
            line-height: 50px;
            color: #fff;
            position: relative;
        }

        .seat.booked {
            background-color: #ff0000;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: gray;
            border-color: #fff;
            animation: glow 1.5s linear infinite;
        }
        .seat {
            width: 50px;
            height: 50px;
            margin: 5px;
            cursor: pointer;
            border: 1px solid pink;
            border-radius: 5px;
            text-align: center;
            line-height: 50px;
            color: #fff;
        }
        #selected-seat-info {
            margin-top: 20px;
            display: none;
        }
        #selected-seat-info p {
            font-size: 18px;
            margin: 10px 0;
        }
         /* Ghế VIP 1 */
         .seat[data-seat^="D"]:not([data-seat$="4"]):not([data-seat$="5"]):not([data-seat$="6"]),
        .seat[data-seat^="E"]:not([data-seat$="4"]):not([data-seat$="5"]):not([data-seat$="6"]),
        .seat[data-seat^="F"]:not([data-seat$="4"]):not([data-seat$="5"]):not([data-seat$="6"]) {
            background-color: red; 
        }

        /*Thường 2 */
        .seat[data-seat^="B"]:not([data-seat$="1"]):not([data-seat$="9"]),
        .seat[data-seat^="C"]:not([data-seat$="1"]):not([data-seat$="9"]):not([data-seat$="4"]):not([data-seat$="5"]):not([data-seat$="6"]):not([data-seat$="3"]):not([data-seat$="7"]),
        .seat[data-seat^="G"]:not([data-seat$="1"]):not([data-seat$="9"]) {
            border-color: DarkGreen;
        }

         /*Thường 1 */
        .seat[data-seat^="C"][data-seat$="3"],
        .seat[data-seat^="C"][data-seat$="4"],
        .seat[data-seat^="C"][data-seat$="5"],
        .seat[data-seat^="C"][data-seat$="6"],
        .seat[data-seat^="C"][data-seat$="7"]{
              border-color: yellow;
          }

        /* VIP 2 */
        .seat[data-seat^="D"][data-seat$="4"],
        .seat[data-seat^="D"][data-seat$="5"],
        .seat[data-seat^="D"][data-seat$="6"],
        .seat[data-seat^="E"][data-seat$="4"],
        .seat[data-seat^="E"][data-seat$="5"],
        .seat[data-seat^="E"][data-seat$="6"],
        .seat[data-seat^="F"][data-seat$="4"],
        .seat[data-seat^="F"][data-seat$="5"],
        .seat[data-seat^="F"][data-seat$="6"] {
            background-color: #800080;
        }
        .screen {
            width: 100%;
            height: 45px;
            margin: 20px auto 40px;
            text-align: center;
            background: url(Images/bg-screen.png) no-repeat top center transparent;
            background-size: 100% auto;
        }
    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-items: center; min-height: 100vh;">
<div id="wrapper">
        <?php  require 'header.php';?>
    <br> <br> <br> <br> <br>
    <div id="content" class="container">
        <div class="row seat-main" style="">
            <div class="screen"></div>
            <form id="seat-form" action="select_room.php" method="get">
                <table>
                    <?php
                    $seats_chunked = array_chunk($seats, 9);
                    foreach ($seats_chunked as $row) : ?>
                        <tr>
                            <?php foreach ($row as $seat) : ?>
                                <td>
                                    <div class="seat" data-seat="<?= $seat['NAME_SEAT'] ?>" data-price="<?= $seat['PRICE'] ?>">
                                        <?= $seat['NAME_SEAT'] ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <input type="hidden" name="CODE_FILM" value="<?= $filmCode ?>">
                <input type="hidden" name="CODE_CUSTOMER" value="<?= $customerID ?>">
                <p id="seat-number" style="color: #fff;"></p>
                <p id="seat-price" style="color: #fff;"></p>
                <input type="hidden" name="selectedSeats" id="selectedSeats" value="">
                <input type="hidden" name="totalPrice" id="totalPrice" value="">
                <button type="submit" class="btn" id="purchase-btn">Đặt mua</button>
            </form>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
        $(document).ready(function () {
            $(window).scroll(function () {
                if($(this).scrollTop() > 0){
                    $('header').addClass('sticky');
                } else {
                    $('header').removeClass('sticky');
                }
            });

            let selectedSeats = [];
            let totalPrice = 0;

            $('.seat').on('click', function () {
                const seatNumber = $(this).data('seat');
                const seatPrice = parseInt($(this).data('price'));

                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    selectedSeats = selectedSeats.filter(seat => seat.number !== seatNumber);
                    totalPrice -= seatPrice;
                } else {
                    $(this).addClass('selected');
                    selectedSeats.push({ number: seatNumber, price: seatPrice });
                    totalPrice += seatPrice;
                }

                updateSelectedSeats();
            });

            function updateSelectedSeats() {
                if (selectedSeats.length > 0) {
                    $('#selected-seat-info').show();
                    const seatNumbers = selectedSeats.map(seat => seat.number).join(', ');
                    const formattedPrice = totalPrice.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    $('#seat-number').text('Số ghế: ' + seatNumbers);
                    $('#seat-price').text('Giá: ' + formattedPrice);
                    $('#selectedSeats').val(JSON.stringify(selectedSeats));
                    $('#totalPrice').val(totalPrice);
                } else {
                    $('#selected-seat-info').hide();
                }
            }

            $('#purchase-btn').on('click', function () {
                if (selectedSeats.length === 0) {
                    alert('Bạn chưa chọn ghế nào.');
                    return false;
                }
                // Submit form
                $('#seat-form').submit();
            });

        });
    </script>
</body>
</html>