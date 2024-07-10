<?php
$title = 'Chi tiết';
require 'class/Film.php';
require 'class/Database.php';
require 'class/Comment.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['CODE_CUSTOMER'])) {
    die("Customer ID is not set. Please log in again.");
}

$code_customer = $_SESSION['CODE_CUSTOMER'];
if (!isset($_SESSION['CODE_CUSTOMER']) || empty($_SESSION['CODE_CUSTOMER'])) {
    die("Customer ID is not set or invalid. Please log in again.");
}

if (isset($_GET['CODE_FILM'])) {
    $CODE_FILM = $_GET['CODE_FILM'];

    $db = new Database();
    $pdo = $db->getConnect();

    $film = Film::getOneByID($pdo, $CODE_FILM);
    if (!$film) {
        die("Id không hợp lệ");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_POST['comment-author'])) {
        $newComment = $_POST['comment'];
        $author = $_POST['comment-author'];

        // Attempt to add the comment
        $result = Comment::addComment($pdo, $CODE_FILM, $author, $newComment);

    }

    $comments = Comment::getCommentsByFilmId($pdo, $CODE_FILM);
    $cmt = Comment::getAllCmt($pdo);
    // Debug: Print comments to check if they are fetched correctly
    // echo '<pre>';
    // print_r($comments);
    // echo '</pre>';
} else {
    die("Vui lòng cung cấp mã phim (CODE_FILM)");
}
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
       
        .ron{
            width: 100%;
            padding: 0;
            margin: 0px 0px 0px 10px;
            overflow: hidden;
            background: #222;
            font-weight: bold;
        }
        
        #content {
            margin-top: 70px;
            color: #fff;
            padding: 20px;
        }

        h3 {
            font-size: 24px;
        }

        .main {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left img {
            width: 345px;
            height: 387px;
            margin-left: 50px;
        }

        .right {
            flex-grow: 1;
            margin-left: 20px;
        }

        .card-body {
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
        }

        .card-title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 10px;
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

        /* Phần tổng thể */
        #comment-section {
            margin-top: 50px;
            background-color: #222; 
            color: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        /* Phần danh sách bình luận */
        .comment-list {
            margin-top: 20px;
        }

        /* Mỗi phần bình luận */
        .comment {
            border: 1px solid #333; 
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #333;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .comment-author {
            font-weight: bold;
        }

        .comment-date {
            color: #777;
        }

        .comment-content {
            margin-top: 5px;
        }

        /* Form nhập bình luận mới */
        .new-comment-form {
            margin-top: 20px;
        }

        .new-comment-form h3 {
            margin-bottom: 10px;
        }

        .new-comment-form .form-group {
            margin-bottom: 15px;
        }

        .new-comment-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .new-comment-form input[type="text"],
        .new-comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc; 
            border-radius: 5px;
            background-color: #444; 
            color: #fff;
        }

        .new-comment-form button[type="submit"] {
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .new-comment-form button[type="submit"]:hover {
            background-color: #fff;
            color: #222;
        }

        input[type="text"],
        textarea {
            padding: 10px; 
            border: 2px solid #ccc; 
            border-radius: 50px; 
            transition: border 0.3s; 
        }

        /* Khi input hoặc textarea được focus */
        input[type="text"]:focus,
        textarea:focus {
            outline: none; 
            border-color: #fc7511; 
            box-shadow: 0 0 10px rgba(252, 117, 17, 0.5); 
        }

        /* CSS cho tab panel */
        .tab {
            overflow: hidden;
            border: 1px solid #ddd; /* Thay đổi màu border */
            background-color: #f1f1f1;
            border-radius: 5px; /* Kích thước bo tròn cho tab panel */
        }

        /* Tab links */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            border-right: 1px solid #ddd; /* Thêm border phân cách giữa các tab */
        }

        /* Loại bỏ border-right cho tab cuối cùng */
        .tab button:last-child {
            border-right: none;
        }

        /* Thêm một border hoặc background màu khác khi nút được active */
        .tab button.active {
            background-color: #ccc;
            border-bottom: 1px solid #fff; /* Thêm border dưới khi active */
        }

        /* Nội dung mỗi tab */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ddd; /* Thay đổi màu border */
            border-top: none;
            border-radius: 0 0 5px 5px; /* Kích thước bo tròn cho phần nội dung */
        }

        

    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;  ">
    <div id="wrapper">
            <?php require 'header.php'; ?>
            <br> <br> 
            <div id="content" class="container">
                <div class="ron">
                    <h2 style="color: dark; background-color: #fc7511; font-size: 16px; line-height: 28px; margin: 0; padding: 6px 15px; position: relative; text-transform: uppercase; float: left; border-radius: 0 3px 3px 0;">NỘI DUNG PHIM</h2>
                    <span><i class="fa-solid fa-caret-right" style="color: #fc7511; margin: 10px 0px 0px -2px;"></i></span>
                </div> 
                <hr>
                <div class="main">
                    <?php if(isset($film) && !empty($film)):?>
                        
                        <div class="left">
                            <img src="Images/<?= $film["IMAGES"] ?>" alt="images" style="width: 345px; height: 387px; margin-left: 50px;">
                        </div>
                        <div class="right">
                            <div class="card-body">
                                <h5 class="card-title" style=" color: #fc7511; font-size: 35px;"><?= $film['NAME_FILM'] ?></h5>
                                <hr>
                                <p class="card-text" ><b>Đạo diễn:</b> <?= $film['DIRECTOR'] ?></p>
                                <p class="card-text"><b>Diễn viên:</b> <?= $film['ACTOR'] ?></p>
                                <p class="card-text"><b>Thể loại:</b> <?= $film['NAME'] ?></p>
                                <p class="card-text"><b>Ngày chiếu:</b> <?= $film['PREMIERE'] ?></p>
                                <p class="card-text"><b>Thời lượng:</b> <?= $film['TIME'] ?></p>
                                <p class="card-text"><b>Ngôn ngữ:</b> <?= $film['NAME_LANGUAGE'] ?></p>
                                <p class="card-text"><b>Rated:</b> <?= $film['NAME_CATOGERY'] ?></p>
                                <form action="select_seat.php" method="GET">
                                    <input type="hidden" name="CODE_FILM" value="<?= $film['CODE_FILM'] ?>">
                                    <input type="hidden" name="CODE_CUSTOMER" value="<?= $code_customer?>">
                                    <button type="submit" class="btn">Đặt vé</button>
                                </form>
                            </div>
                        </div>
                   
                </div>
                <hr />
                <div class="tab" >
                    <button style="color: #fc7511;" class="tablinks" onclick="openTab(event, 'description')">Mô tả</button>
                    <button style="color: #fc7511;" class="tablinks" onclick="openTab(event, 'reviews')">Đánh giá</button>
                </div>
                <div id="description" class="tabcontent">
                    <p class="card-text" ><?= $film['DISCRIPTION'] ?></p>
                </div>
                 <?php else: ?>
                    <p>Không có dữ liệu phim.</p>
                    <?php endif; ?>
                    <div id="reviews" class="tabcontent">
                <div class="comment-list">
                    <?php if (!empty($cmt)): ?>
                        <?php foreach ($cmt as $comment): ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <span class="comment-author"><?= htmlspecialchars($comment['author']) ?></span>
                                    <span class="comment-date"><?= htmlspecialchars($comment['time']) ?></span>
                                </div>
                                <div class="comment-content">
                                    <p><?= htmlspecialchars($comment['content']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No comments yet.</p>
                    <?php endif; ?>
                </div>
                <div class="new-comment-form">
                    <h3>Thêm bình luận mới</h3>
                    <form action="details_film.php?CODE_FILM=<?= htmlspecialchars($film['CODE_FILM']) ?>" method="POST">
                        <div class="form-group">
                            <label for="comment-author">Tên:</label>
                            <input type="text" id="comment-author" name="comment-author" required>
                        </div>
                        <div class="form-group">
                            <label for="comment-content">Nội dung:</label>
                            <textarea id="comment-content" name="comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </form>
                </div>
            </div>
            <hr>
                </div>
                
                <?php require 'footer.php'; ?>
            </div>
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
    <script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
</body>
</html>
