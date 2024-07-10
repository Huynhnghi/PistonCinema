<?php
session_start();

if (!isset($_SESSION['username'])) {
     
    header("Location: login.php");
    exit;  
}

 
require '../class/Database.php';
require '../class/Film.php';

 
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $pdo = $db->getConnect();
     
    $codeFilm = $_POST['codeFilm'];
    $nameFilm = $_POST['nameFilm'];
    $director = $_POST['nameDirec'];
    $actor = $_POST['nameActor']; 
    $codeType = $_POST['namecodeType'];
    $premiere = $_POST['nameDate'];
    $time = $_POST['nameTime'];
    $codeLanguage = $_POST['namecodeLanguage'];
    $rated = $_POST['nameRated'];
    $dis = $_POST['nameDisc'];
    
     
    if ($_FILES['nameImages']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['nameImages']['name'];
        $imageTempName = $_FILES['nameImages']['tmp_name'];
        $targetDirectory = "../Images/";
        $targetFilePath = $targetDirectory . basename($imageFileName);

        if (move_uploaded_file($imageTempName, $targetFilePath)) {
            
            $filmData = array(
                'CODE_FILM' => $codeFilm,
                'NAME_FILM' => $nameFilm,
                'DIRECTOR' => $director,
                'ACTOR' => $actor,
                'CODE_TYPE' => $codeType,
                'PREMIERE' => $premiere,
                'TIME' => $time,
                'CODE_LANGUAGE' => $codeLanguage,
                'RATED' => $rated,
                'IMAGES' => $targetFilePath ,
                'DISCRIPTION' => $dis 
            );
        } else {
            $errorMessage = "Có lỗi xảy ra khi tải lên hình ảnh. Vui lòng thử lại sau.";
        }
    } else { 
        $currentFilmInfo = Film::getFilmById($pdo, $codeFilm);

// Tạo một mảng dữ liệu phim từ thông tin phim hiện tại
$filmData = array(
    'CODE_FILM' => $codeFilm,
    'NAME_FILM' => $nameFilm,
    'DIRECTOR' => $director,
    'ACTOR' => $actor,
    'CODE_TYPE' => $codeType,
    'PREMIERE' => $premiere,
    'TIME' => $time,
    'CODE_LANGUAGE' => $codeLanguage,
    'RATED' => $rated,
    'DISCRIPTION' => $dis
);

// Kiểm tra xem có hình ảnh mới được tải lên hay không
if ($_FILES['nameImages']['error'] === UPLOAD_ERR_OK) {
    $imageFileName = $_FILES['nameImages']['name'];
    $imageTempName = $_FILES['nameImages']['tmp_name'];
    $targetDirectory = "../Images/";
    $targetFilePath = $targetDirectory . basename($imageFileName);

    if (move_uploaded_file($imageTempName, $targetFilePath)) {
        // Nếu có hình ảnh mới, cập nhật đường dẫn hình ảnh trong mảng dữ liệu phim
        $filmData['IMAGES'] = $targetFilePath;
    } else {
        $errorMessage = "Có lỗi xảy ra khi tải lên hình ảnh. Vui lòng thử lại sau.";
    }
} else {
    // Nếu không có hình ảnh mới, giữ nguyên đường dẫn hình ảnh từ thông tin phim hiện tại
    $filmData['IMAGES'] = isset($currentFilmInfo['IMAGES']) ? $currentFilmInfo['IMAGES'] : '';
}

        // Cập nhật thông tin phim vào cơ sở dữ liệu
        if (Film::update($pdo, $filmData)) {
            header("Location: listFilm.php");
            exit;
        } else {
            $errorMessage = "Có lỗi xảy ra khi cập nhật phim. Vui lòng thử lại sau. Lỗi: " . implode(" ", $pdo->errorInfo());
        }
    } }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin phim</title>
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
    <h2>Sửa thông tin phim</h2>
    <?php if (isset($errorMessage)) : ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <div class="row-2" style="background: #222;">  
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" id="codeFilm" name="codeFilm"  class="form-control" value="<?php echo isset($filmInfo['CODE_FILM']) ? $filmInfo['CODE_FILM'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameFilm">Tên phim:</label>
            <input type="text" id="nameFilm" name="nameFilm"  class="form-control" value="<?php echo isset($filmInfo['NAME_FILM']) ? $filmInfo['NAME_FILM'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameDirec">Đạo diễn:</label>
            <input type="text" id="nameDirec" name="nameDirec"  class="form-control" value="<?php echo isset($filmInfo['DIRECTOR']) ? $filmInfo['DIRECTOR'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameActor">Diễn viên:</label>
            <input type="text" id="nameActor" name="nameActor"  class="form-control" value="<?php echo isset($filmInfo['ACTOR']) ? $filmInfo['ACTOR'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="namecodeType">Mã loại phim:</label>
            <input type="text" id="namecodeType" name="namecodeType"  class="form-control" value="<?php echo isset($filmInfo['CODE_TYPE']) ? $filmInfo['CODE_TYPE'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameDate">Ngày công chiếu:</label>
            <input type="date" id="nameDate" name="nameDate"  class="form-control" value="<?php echo isset($filmInfo['PREMIERE']) ? $filmInfo['PREMIERE'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameTime">Thời lượng:</label>
            <input type="text" id="nameTime" name="nameTime"  class="form-control" value="<?php echo isset($filmInfo['TIME']) ? $filmInfo['TIME'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="namecodeLanguage">Mã ngôn ngữ:</label>
            <input type="text" id="namecodeLanguage" name="namecodeLanguage"  class="form-control" value="<?php echo isset($filmInfo['CODE_LANGUAGE']) ? $filmInfo['CODE_LANGUAGE'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameRated">Mã rated:</label>
            <input type="text" id="nameRated" name="nameRated"  class="form-control" value="<?php echo isset($filmInfo['RATED']) ? $filmInfo['RATED'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameImages">Hình ảnh</label>
            <input type="file" id="nameImages" name="nameImages"   value="<?php echo isset($filmInfo['IMAGES']) ? $filmInfo['IMAGES'] : ''; ?>"><br><br>
        </div>

        <div class="form-group">
            <label for="nameDisc">Mô tả</label>
            <input type="text" id="nameDisc" name="nameDisc" class="form-control"   value="<?php echo isset($filmInfo['DISCRIPTION']) ? $filmInfo['DISCRIPTION'] : ''; ?>"><br><br>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    </div>
    </div>
</body>

</html>
