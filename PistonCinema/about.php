<?php
 session_start();

 if (!isset($_SESSION['username'])) {
     header("Location: login.php");
 }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu - Hệ Thống Quản Lý Rạp Chiếu Phim</title>
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* CSS styling */
        .row {
            background-color: #fff;
            border: 1px solid #ced4da;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #fc7511 !important;
            text-align: center !important;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px !important;
        }
    </style>
</head>
<body style="background: #000; font-family: Courier new; display: flex; justify-content: center; align-item: center; min-height: 100vh;  ">
    <div id="wrapper">
        <?php require 'header.php'; ?>
        <br> <br> <br> <br> <br>
        <div id="content" class="container">
            <div class="row">
                <h1><b>Giới Thiệu - Hệ Thống Quản Lý Rạp Chiếu Phim </b></h1>
                <p>Chào mừng bạn đến với dự án Hệ Thống Quản Lý Rạp Chiếu Phim của chúng tôi! Dự án này nhằm mục đích cung cấp một giải pháp toàn diện cho việc quản lý rạp chiếu phim, bao gồm đặt vé, lập lịch chiếu phim, quản lý nhân viên và nhiều hơn nữa.</p>
                
                <h2><b>Tổng Quan Dự Án</b></h2>
                <p>Hệ Thống Quản Lý Rạp Chiếu Phim của chúng tôi được phát triển dưới dạng một ứng dụng web sử dụng các công nghệ hiện đại như HTML, CSS, JavaScript, PHP và MySQL. Nó cung cấp một giao diện thân thiện với người dùng cho cả quản trị viên và khách hàng.</p>
                
                <h2><b>Thành viên</b></h2>
                <ul>
                    <li><strong>Nguyễn Thị Huỳnh Nghi</strong> - Quản Lý Dự Án</li>
                    <li><strong>Vẫn là Nghi nè</strong> - Nhà Phát Triển Chính</li>
                    <li><strong>Lại là Nghi</strong> - Nhà Phát Triển Backend</li>
                    <li><strong>Vẫn là Nghi</strong> - Nhà Phát Triển Frontend</li>
                    <li><strong>Cuối cùng cũng là Nghi</strong> - Quản Trị Cơ Sở Dữ Liệu</li>
                </ul>
                
                <p>Đối với mọi thắc mắc hoặc phản hồi, vui lòng liên hệ với chúng tôi qua email <a href="mailto:huynhnghi6809@gmail.com">liên hệ qua gmail</a>.</p>
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

