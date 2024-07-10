<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    require 'class/Database.php';
    require 'class/Film.php';

    $db = new Database();
    $pdo = $db->getConnect();

    $nowShowingFilms = Film::getNowShowingFilms($pdo, '2024-05-10');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phim đang chiếu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .ron{
            width: 100%;
            padding: 0;
            margin: 0px 0px 0px 10px;
            overflow: hidden;
            background: rgba(191 239 255);
            font-weight: bold;
        }
         /* card sản phẩm */
         .card {
            width: 100%;
            height: 95%;
            margin: 10px; 
            opacity: 0.8; 
            transition: opacity 0.3s ease; 
        }

        .card:hover {
            opacity: 1;
        }
        .card-title{
            font-weight: bold;
        }
        

    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;  ">
    <div id="wrapper">
        <?php require 'header.php'; ?>
        <br /> <br /> <br /> <br />
        <div id="content" class="container">
                <br />
                <div class="ron">
                    <h2 style="color: dark; background-color: #fc7511; font-size: 16px; line-height: 28px; margin: 0; padding: 6px 15px; position: relative; text-transform: uppercase; float: left; border-radius: 0 3px 3px 0;">DANH SÁCH PHIM</h2>
                    <span><i class="fa-solid fa-caret-right" style="color: #fc7511; margin: 10px 0px 0px -2px;"></i></span>
                </div>   
                <div class="row">
                    <?php if (!empty($nowShowingFilms)): ?>
                    <?php foreach ($nowShowingFilms as $film): ?>
                        <div class="col-md-3">
                                <div class="card">
                                    <img src="Images/<?= $film["IMAGES"] ?>" alt="images" style="width: 196px; height: 297px; margin-left: 50px;">
                                        <div class="card-body">
                                            <h5 class="card-title" ><?= $film['NAME_FILM'] ?></h5>
                                            <p class="card-text"><b>Thời lượng:</b><?= $film['TIME'] ?></p>
                                            <p class="card-text"><b>Ngày chiếu:</b><?= $film['PREMIERE'] ?></p>
                                            <a href="details_film.php?CODE_FILM=<?=$film['CODE_FILM']?>" class="btn">Xem thêm</a>
                                            <a href="select_seat.php?proid=<?= $film['CODE_FILM']?>" class="btn">Đặt vé</a>
                                        </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Hiện không có bộ phim nào đang chiếu.</li>
                    <?php endif; ?>
                </div>

            <br />

            </div>
            <br />
            <footer>
            <?php require 'footer.php'; ?>
            </footer>
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
        });
    </script>
</body>
</html>
