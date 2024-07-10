
<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* head */
        header{
            position: fixed !important;  
            z-index: 999999 !important;
            top: 0!important; 
            left: 0!important;
            width: 100%!important;
            border-bottom: 1px solid #f5f5f5!important;
            padding: 10px 0px!important;
            transition: all 0.5s ease-in-out!important;
        }

        header.sticky{
            background: #fff!important;
            opacity: 0.9!important;
            padding: 15px 0px!important;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.5)!important;
        }
        header.sticky #logo{
            color: #000!important;
        }
        header.sticky #main-menu a{
            color: #000!important;
        }

        @keyframes changeColor {
            0% { color: #ff0000; } 
            25% { color: #00ff00; } 
            50% { color: #0000ff; } 
            75% { color: #ffff00; } 
            100% { color: #ff0000; } 
        }

        #logo {
            text-transform: uppercase!important;
            font-weight: bold!important;
            font-size: 1.5rem!important;
            letter-spacing: 2px!important;
            font-size: 24px !important; 
            font-weight: bold !important; 
            text-decoration: none !important;
            animation: changeColor 5s infinite !important; 
        }
        .inner-header{
            display: flex!important;
            justify-content: space-between!important;
            align-items: center!important;
        }

        /* Menu */
        ul#main-menu{
            display: flex;
        }

        ul#main-menu a{
            text-transform: uppercase;
            padding: 10px 20px; 
            color: #fff;
            font-size: 17px!important;
            font-weight: bold!important;
            display: block!important;
            text-decoration: none!important;
        }

        #search-box {
            width: 300px!important;
            vertical-align: middle!important;
            white-space: nowrap!important;
            position: relative!important;
        }
        #search-box #search-text {
            width: 50px!important;
            height: 50px!important;
            background: rgba(255, 255, 255, 0.3)!important;
            border: none!important;
            font-size: 10pt!important;
            float: left!important;
            color: #fff!important;
            padding-left: 45px!important;
            -webkit-border-radius: 5px!important;
            -moz-border-radius: 5px!important;
            border-radius: 5px!important;
            color: #fff!important;
            -webkit-transition: width .55s ease!important;
            -moz-transition: width .55s ease!important;
            -ms-transition: width .55s ease!important;
            -o-transition: width .55s ease!important;
            transition: width .55s ease!important;
        }
        #search-box #search-text::-webkit-input-placeholder {
            color: #fff!important;
        }
        #search-box #search-text:-moz-placeholder { 
            color: #65737e!important;  
        }
        #search-box #search-text::-moz-placeholder {  
            color: #65737e!important;  
        }
        #search-box #search-text:-ms-input-placeholder {  
            color: #65737e!important;  
        }

        #search-box .icon{
            position: absolute!important;
            top: 50%!important;
            margin-left: 20px!important;
            margin-top: -6px!important;
            z-index: 1!important;
            color: #fff!important;
        }
        #search-box #search-text:focus, .container-2 input#search:active{
            
            outline:none!important;
            width: 300px!important;
        }
        #search-box:hover input#search{
            width: 300px!important;
        }
        #search-box:hover .icon{
            color: #fc7511!important; 
        }

        /* Custom CSS for Dropdown */
        .dropdown-menu {
            background-color: #6c757d !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15 !important);
        }

        .dropdown-item {
            color: #333 !important;
            padding: 10px 20px !important;
        }

        .dropdown-item:hover {
            background-color: #1AAB8A !important ;
            color: #000 !important;
        }

        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: #fff !important;
            padding: 10px 20px !important;
            border-radius: 0.5rem !important;
        }

        .btn-secondary:hover, .btn-secondary:focus {
            background-color: #1AAB8A  !important;
            border-color: #545b62 !important;
            color: #fff !important;
        }
        /* banner */
        .carousel-item img {
            width: 1000px;
            height: 500px; 
            margin-top: 120px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px; 
            height: 30px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: auto; 
        }

        .carousel-control-prev {
            left: -30px; 
        }

        .carousel-control-next {
            right: -30px; 
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
        
        .btn{
            background:#1AAB8A !important;
            color:#fff !important;
            border:none !important;
            position:relative !important;
            width: 130px !important;
            height:40px !important;
            font-size:16px !important;
            padding:8px 2px !important;
            cursor:pointer !important;
            transition:800ms ease all !important;
            outline:none !important;
        }
        .btn:hover{
            background:#fff !important;
            color:#1AAB8A !important;
            font-weight: bold !important;
        }
        .btn:before,button:after{
            content:'' !important;
            position:absolute !important;
            top:0 !important;
            right:0 !important;
            height:2px !important;
            width:0 !important;
            background: #1AAB8A !important;
            transition:400ms ease all !important;
        }
        .btn:after{
            right:inherit !important;
            top:inherit !important;
            left:0 !important;
            bottom:0 !important;
        }
        .btn:hover:before,button:hover:after{
            width:100% !important;
            transition:800ms ease all !important;
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            background-color: #fff; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            padding: 0; 
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); 
        }

        .dropdown-menu li {
            list-style: none; 
        }

        .dropdown-item {
            padding: 8px 12px; 
            text-decoration: none;
            color: #fff !important; 
            display: block; 
            transition: background-color 0.3s ease; 
        }

        .dropdown-item:hover {
            background-color: #f2f2f2; 
        }

    </style>
</head>
<body>
<div id="wrapper">
<header>
    <div class="inner-header container d-flex align-items-center">
        <a href="index.php" id="logo">PISTON CINEMA</a>
        <ul id="main-menu" class="navbar-nav flex-row" style="margin-left: 70px;">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Trang chủ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Phim
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <a href="filmShowing.php" id="nowShowingLink" class="dropdown-item">Phim đang chiếu</a>
                    </li>
                    <li>
                        <a href="filmUpcoming.php" id="upcomingLink" class="dropdown-item">Phim sắp chiếu</a>
                    </li>
                </ul>

            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Rạp chiếu
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <a href="filmShowing.php" id="nowShowingLink" class="dropdown-item">Thành phố Hồ Chí Minh</a>
                    </li>
                    <li>
                        <a href="filmUpcoming.php" id="upcomingLink" class="dropdown-item">Tiền giang</a>
                    </li>
                    <li>
                        <a href="filmUpcoming.php" id="upcomingLink" class="dropdown-item">Đồng Nai</a>
                    </li>
                    <li>
                        <a href="filmUpcoming.php" id="upcomingLink" class="dropdown-item">Long An</a>
                    </li>
                </ul>

            </li>
            <li class="nav-item">
                <a href="about.php" class="nav-link">Giới thiệu</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Giỏ hàng </a>
            </li>
            <?php
            if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
                $username = $_SESSION["username"];
                echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style ="color:#fc7511;">
                            '.$username.'
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="Logout.php">ĐĂNG XUẤT</a></li>
                        </ul>
                      </li>';
            } else {
                echo '<li class="nav-item">
                        <a href="login.php" class="nav-link">ĐĂNG NHẬP</a>
                      </li>';
                echo '<li class="nav-item">
                        <a href="SignUp.php" class="nav-link">ĐĂNG KÝ</a>
                      </li>';
            }
            ?>
        </ul>
        <div id="search-box" class="d-flex">
            <i class="fa fa-search icon"></i>
            <input type="text" id="search-text" placeholder="Tìm kiếm" class="form-control" style ="color:#fc7511 !important;">
        </div>
    </div>
</header>
       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
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
    $('#search-text').on('keyup', function() {
        searchFilms();
    });

    function searchFilms() {
        var keyword = $('#search-text').val().toLowerCase(); 

        $('.card').each(function() {
            var filmTitle = $(this).find('.card-title').text().toLowerCase();
            if (filmTitle.includes(keyword)) { 
                $(this).show(); 
            } else {
                $(this).hide(); 
            }
        });
    }
</script>




</body>
</html>