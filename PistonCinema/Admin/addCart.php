<?php
// Thực hiện kết nối đến cơ sở dữ liệu
require '../class/Database.php';
require '../class/Ticket.php';
require '../class/Customer.php';
require '../class/Seat.php';
require '../class/Room.php';
require '../class/Film.php';

$db = new Database();
$pdo = $db->getConnect();

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codeCar = $_POST['codeCart'];
    $codeCus = $_POST['codeCus'];
    $codeSeat = $_POST['codeSeat'];
    $dob = $_POST['dob'];
    $codeRoom = $_POST['codeRoom'];
    $codeFilm = $_POST['codeFilm'];

    $ticket_data = array(
        'CODE_TICKET' => $codeCar,
        'CODE_CUSTOMER' => $codeCus,
        'SEAT' => $codeSeat,
        'SALE_DATE' => $dob,
        'CODE_ROOM' => $codeRoom,
        'CODE_FILM' => $codeFilm
    );

    $sqlCustomer = Customer::getAllCus($pdo);
    $sqlSeat = Seat::getAllSeats($pdo);
    $sqlRoom = Room::getAllRoom($pdo);
    $sqlFilm = Film::getAllFilms($pdo);

    if (Ticket::addTicket($pdo, $ticket_data)) {
        header("Location: CartFilm.php");
        exit; 
    } else {
        $errorMessage = "Có lỗi xảy ra khi thêm vé. Vui lòng thử lại sau.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .row-2 {
            background-image: linear-gradient(#fbc2eb, #a6c1ee) !important; 
            color: #fff !important;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 700px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #000; 
        }

        .form-group label {
            font-weight: bold;
            color: #000 !important; 
        }

        .form-control {
            width: 100% !important;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<div class="wrapper">
    <?php if (isset($errorMessage)) : ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <h2>Thêm thông tin giỏ hàng</h2>
    <div class="row-2" style="background: #222;">  
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="codeCart">Mã giỏ hàng:</label>
                <input type="text" name="codeCart" id="codeCart" class="form-control">
            </div>
            <div class="form-group">
                <label for="codeCus">Mã khách hàng:</label>
                <select name="codeCus" id="codeCus" class="form-control">
                    <?php
                    $sqlCustomer = Customer::getCodeCus($pdo);
                    if ($sqlCustomer && is_array($sqlCustomer) && !empty($sqlCustomer)) {
                        foreach ($sqlCustomer as $customer) {
                            echo '<option value="' . $customer['CODE_CUSTOMER'] . '">' . $customer['CODE_CUSTOMER'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="codeSeat">Mã ghế:</label>
                <select name="codeSeat" id="codeSeat" class="form-control">
                    <?php
                    $sqlSeat = Seat::getCodeSeat($pdo);
                    if ($sqlSeat && is_array($sqlSeat) && !empty($sqlSeat)) {
                        foreach ($sqlSeat as $seat) {
                            echo '<option value="' . $seat['CODE_SEAT'] . '">' . $seat['CODE_SEAT'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="dob">Ngày mua</label>
                <input type="date" name="dob" id="dob" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="codeRoom">Mã phòng:</label>
                <select name="codeRoom" id="codeRoom" class="form-control">
                    <?php
                    $sqlRoom = Room::getCodeRoom($pdo);
                    if ($sqlRoom && is_array($sqlRoom) && !empty($sqlRoom)) {
                        foreach ($sqlRoom as $room) {
                            echo '<option value="' . $room['CODE_ROOM'] . '">' . $room['CODE_ROOM'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="codeFilm">Mã phim</label>
                <select name="codeFilm" id="codeFilm" class="form-control">
                    <?php
                    $sqlFilm = Film::getCodeFilm($pdo);
                    if ($sqlFilm && is_array($sqlFilm) && !empty($sqlFilm)) {
                        foreach ($sqlFilm as $film) {
                            echo '<option value="' . $film['CODE_FILM'] . '">' . $film['CODE_FILM'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
</div>
</body>
</html>
