    <?php
    require 'class/Database.php';
    require 'class/Room.php';
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu số ghế đã chọn
        $selectedSeats = $_POST['selectedSeats'] ?? null;
        // Lấy dữ liệu tổng giá tiền
        $totalPrice = $_POST['totalPrice'] ?? null;
    }
    

    $cus = Login::getUserByAccount($pdo, $_SESSION['username']);
    $film = Film::getOneByID($pdo, $filmCode);
    $room = Room::getAllRoom($pdo);
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
            header {
                position: fixed;
                z-index: 999999;
                top: 0;
                left: 0;
                width: 100%;
                border-bottom: 1px solid #f5f5f5;
                padding: 10px 0;
                transition: all 0.5s ease-in-out;
            }
            header.sticky {
                background: #fff;
                opacity: 0.9;
                padding: 15px 0;
                box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.5);
            }
            #logo {
                color: #fff;
                text-transform: uppercase;
                font-weight: bold;
                font-size: 1.5rem;
                letter-spacing: 2px;
                text-decoration: none;
            }
            header.sticky #logo, header.sticky #main-menu a {
                color: #000;
            }
            .inner-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            ul#main-menu {
                display: flex;
                list-style: none;
            }
            ul#main-menu a {
                text-transform: uppercase;
                padding: 10px 20px;
                color: #fff;
                font-size: 20px;
                font-weight: bold;
                text-decoration: none;
            }
            #search-box {
                width: 300px;
                position: relative;
            }
            #search-box #search-text {
                width: 50px;
                height: 50px;
                background: rgba(255, 255, 255, 0.3);
                border: none;
                font-size: 10pt;
                float: left;
                color: #fff;
                padding-left: 45px;
                border-radius: 5px;
                transition: width .55s ease;
            }
            #search-box #search-text:focus, #search-box:hover #search-text {
                width: 300px;
            }
            #search-box .icon {
                position: absolute;
                top: 50%;
                margin-left: 17px;
                margin-top: 17px;
                z-index: 1;
                color: #fff;
            }
            #search-box:hover .icon {
                color: #93a2ad;
            }
            .btn {
                display: inline-block !important;
                padding: 10px 20px !important;
                background-color: #007bff !important;
                color: #fff !important;
                text-decoration: none !important;
                border-radius: 5px !important;
            }

            .btn:hover {
                background-color: #0056b3 !important;
            }
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
            
            /* Room Selection */
            .room {
                width: 125px;
                height: 62px;
                margin: 5px;
                cursor: pointer;
                border: 1px solid #ced4da;
                border-radius: 5px;
                text-align: center;
                line-height: 50px;
                color: #fff;
                background-color: #222;
            }

            .room.selected {
                background-color: gray;
                border-color: #fff;
                animation: glow 1.5s linear infinite;
            }
        </style>
    </head>
    <body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div id="wrapper">
            <?php require 'header.php'; ?>
            <br> <br> 
            <div class="container seat-main">
            <form id="room-form" action="Cart.php" method="get">
                <table>
                    <tr>
                        <?php foreach ($room as $roomItem) : ?>
                            <td>
                                <div class="room" data-room="<?= $roomItem['NAME_ROOM'] ?>">
                                    <?= $roomItem['NAME_ROOM'] ?>
                                </div>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
                <!-- Pass film code, customer ID, selected seats, and total price to Cart.php -->
                <input type="hidden" name="CODE_FILM" value="<?= $filmCode ?>">
                <input type="hidden" name="CODE_CUSTOMER" value="<?= $customerID ?>">
                <input type="hidden" name="selectedSeats" value="<?= htmlspecialchars(json_encode($selectedSeats)) ?>">
                <input type="hidden" name="totalPrice" value="<?= htmlspecialchars($totalPrice) ?>">
                <p id="room-info" style="color: #fff;"></p>
                <input type="hidden" name="selectedRoom" id="selectedRoom">
                <button type="submit" class="btn" id="purchase-btn">Đặt mua</button>
            </form>
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

                let selectedRoom = '';

                $('.room').on('click', function () {
                    $('.room').removeClass('selected');
                    $(this).addClass('selected');

                    selectedRoom = $(this).data('room');
                    $('#room-info').text('Phòng: ' + selectedRoom);

                    // Đưa tên phòng vào input ẩn để gửi dữ liệu đi
                    $('#selectedRoom').val(selectedRoom);
                });

                $('#purchase-btn').on('click', function () {
                    const selectedSeats = JSON.parse($('input[name="selectedSeats"]').val());
                    const totalPrice = $('input[name="totalPrice"]').val();

                    if (selectedSeats.length === 0 || selectedRoom === '') {
                        alert('Bạn chưa chọn ghế hoặc phòng.');
                        return false;
                    }
    
                    $('#seat-form').append('<input type="hidden" name="selectedSeats" value="' + JSON.stringify(selectedSeats) + '">');
                    $('#seat-form').append('<input type="hidden" name="totalPrice" value="' + totalPrice + '">');
                    $('#seat-form').submit();
                
                    alert('Đặt mua ghế ' + selectedSeats.map(seat => seat.number).join(', ') + ' với giá ' + parseInt(totalPrice).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) +
                        '. Đặt phòng: ' + selectedRoom);
                    // Submit form
                    $('#room-form').submit();
                });
            });
        </script>t>


    </body>
    </html>
