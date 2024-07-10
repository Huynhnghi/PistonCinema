<?php
    $title = 'Trang chủ';
    require './class/Film.php';
    require './class/Database.php';

    $db = new Database();
    $pdo = $db->getConnect();

    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 8;

    $paginationData = Film::sessionPage($pdo, $page, $perPage);
    
    
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
        
        /* banner */
        .carousel-item img {
            margin: 0 auto; 
            max-width: 70%; 
        }

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
        

        .row_top {
            display: flex;
            justify-content: center; 
            align-items: center; 
        }

        .page-item-container {
            border: 1px solid #ccc;
            background-color: #f8f9fa;
            margin-right: 5px;
            text-align: center; 
            line-height: 40px; 
        }

        .page-item {
            display: flex;
            align-items: center; 
            justify-content: center; 
            padding: 10px;
            text-decoration: none;
            color: #333;
            width: 40px; 
            height: 40px;
        }

        .page-item.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .button-container {
            display: flex;
            justify-content: space-between; /* Đảm bảo nút nằm ở hai cạnh */
            align-items: center; /* Canh giữa theo chiều dọc */
        }

        .btn {
            width: 150px; /* Định kích thước nút */
        }


        
    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;  ">
    <div id="wrapper">
        <div>
        <?php require 'header.php'; ?>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="Images/banner1.jpg" class="d-block w-100" alt="Lật mặt 7">
                </div>
                <div class="carousel-item">
                <img src="Images/banner2.JPG" class="d-block w-100" alt="Đào, phở và piano">
                </div>
                <div class="carousel-item">
                <img src="Images/banner3.jpg" class="d-block w-100" alt="Tee Yob">
                </div>
                <div class="carousel-item">
                <img src="Images/banner.jpg" class="d-block w-100" alt="Cái giá của hạnh phúc">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div id="content" class="container">
            <br />
            <div class="ron">
                <h2 style="color: dark; background-color: #fc7511; font-size: 16px; line-height: 28px; margin: 0; padding: 6px 15px; position: relative; text-transform: uppercase; float: left; border-radius: 0 3px 3px 0;">DANH SÁCH PHIM</h2>
                <span><i class="fa-solid fa-caret-right" style="color: #fc7511; margin: 10px 0px 0px -2px;"></i></span>
            </div> 
            
            <div class="row">
                
                <?php foreach ($paginationData['data'] as $film): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img src="Images/<?= $film["IMAGES"] ?>" alt="images" style="width: 196px; height: 297px; margin-left: 50px;">
                                <div class="card-body">
                                    <h5 class="card-title" ><?= $film['NAME_FILM'] ?></h5>
                                    <p class="card-text"><b>Thời lượng:</b><?= $film['TIME'] ?></p>
                                    <p class="card-text"><b>Ngày chiếu:</b><?= $film['PREMIERE'] ?></p>
                                    <div class="button-container">
                                        <a href="details_film.php?CODE_FILM=<?=$film['CODE_FILM']?>" class="btn">Xem thêm</a>
                                        <form action="select_seat.php" method="GET">
                                            <input type="hidden" name="CODE_FILM" value="<?= $film['CODE_FILM'] ?>">
                                            <input type="hidden" name="CODE_CUSTOMER" value="<?= $code_customer?>">
                                            <button type="submit" class="btn">Đặt vé</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <br />
            <div class="row_top">
                <?php for ($num = 1; $num <= $paginationData['totalPages']; $num++): ?>
                    <a class="page-item <?= ($num == $paginationData['currentPage']) ? 'active' : '' ?>" href="?page=<?= $num ?>&perpage=<?= $paginationData['perPage'] ?>"><?= $num ?></a>
                <?php endfor; ?>

                <?php if ($paginationData['currentPage'] < $paginationData['totalPages']): ?>
                    <a class="page-item" href="?page=<?= $paginationData['currentPage'] + 1 ?>&perpage=<?= $paginationData['perPage'] ?>"></a>
                <?php endif; ?>
            </div>

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
