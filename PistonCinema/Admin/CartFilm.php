<?php
session_start();
$is_admin = isset($_SESSION['username']) && ($_SESSION['username'] === 'admin' || $_SESSION['username'] === 'admin1');
    require '../class/Database.php';
    require '../class/Ticket.php';
    

    $db = new Database();
    $pdo = $db->getConnect();
    $ticket = Ticket::getAllTicket($pdo);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Danh sách giỏ hàng
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
 
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <style>
           
        table {
          width: 100%;
          border-collapse: collapse;
          margin-bottom: 20px;
        }

         
        th {
          background-color: #007bff;
          color: white;
          text-align: left;
          padding: 10px;
        }

         
        td {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 10px;
        }

         
        tr:nth-child(even) {
          background-color: #f2f2f2;
        }

        
        td img {
          width: 200px;
          height: auto;
          display: block;
          margin: 0 auto;
        }

       
        button.add, button.edit, button.del {
          padding: 5px 10px;
          border: none;
          border-radius: 3px;
          cursor: pointer;
          margin-right: 5px;
          color: white;
        }

        button.add {
          background-color: #28a745;  
        }

        button.edit {
          background-color: #007bff;  
        }

        button.del {
          background-color: #dc3545;  
        }

         
        button.add:hover, button.edit:hover, button.del:hover {
          opacity: 0.8;
        }
        .card-body {
          overflow-x: auto;  
          padding: 15px;
        }
       
        .logout-link {
          display: block;
          padding: 10px 20px;
          color: #fff;
          background-color: #dc3545;  
          border: none;
          border-radius: 5px;
          cursor: pointer;
        }

         
        .logout-link:hover {
          background-color: #c82333;  
        }

        /* Dropdown Menu */ 
        .dropdown-menu {
          background-color: #fff !important;
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
  </style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
          </div>
          <!-- <p>CT</p> -->
            <?php if ($is_admin && $_SESSION['username'] === 'admin' || $_SESSION['username'] === 'admin1'): ?>
                <?php
                $username = $_SESSION["username"];
                ?>
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#fc7511;">
                    <?php echo $username; ?>
                    
                </a>
                <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../Logout.php">ĐĂNG XUẤT</a>
                </div>

                <!-- <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="Logout.php">ĐĂNG XUẤT</a></li>
                </ul> -->
            <?php else: ?>
                <p>You are not an admin. No special links for you.</p>
            <?php endif; ?> <br />
            </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="./listFilm.php">
              <i class="nc-icon nc-bank"></i>
              <p>Danh sách phim</p>
            </a>
          </li>
          <li>
            <a href="./CartFilm.php">
              <i class="nc-icon nc-diamond"></i>
              <p>Giỏ hàng</p>
            </a>
          </li>
          <li>
          </li>
          <li>
            <a href="./infoCus.php">
              <i class="nc-icon nc-bell-55"></i>
              <p>Thông tin khách hàng</p>
            </a>
          </li>
          <li>
            <a href="./infoStaff.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Thông tin nhân viên</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;"></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-magnify" href="javascript:;">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="javascript:;">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Danh sách giỏ hàng</h5>
              </div>
              <div class="card-body ">
              <table>
                  <tr>
                    <th>MÃ VÉ</th>
                    <th>MÃ KHÁCH HÀNG</th>
                    <th>MÃ GHẾ</th>
                    <th>NGÀY MUA</th>
                    <th>MÃ PHÒNG</th>
                    <th>MÃ PHIM</th>
                  </tr>
                  <?php if (isset($ticket) && is_array($ticket) && !empty($ticket)): ?>
                    <?php foreach ($ticket as $Ticket): ?>
                      <tr>
                        <td><?= htmlspecialchars($Ticket['CODE_TICKET']) ?></td>
                        <td><?= htmlspecialchars($Ticket['CODE_CUSTOMER']) ?></td>
                        <td><?= htmlspecialchars($Ticket['SEAT']) ?></td>
                        <td><?= htmlspecialchars($Ticket['SALE_DATE']) ?></td>
                        <td><?= htmlspecialchars($Ticket['CODE_ROOM']) ?></td>
                        <td><?= htmlspecialchars($Ticket['CODE_FILM']) ?></td>
                        <td>
                          <button class="btn edit" onclick="editCus(<?= htmlspecialchars($Ticket['CODE_TICKET']) ?>)">Sửa</button>
                          <button class="btn del" onclick="deleteCus(<?= htmlspecialchars($Ticket['CODE_TICKET']) ?>)">Xóa</button>
                        </td>
                      </tr>
                      
                    <?php endforeach; ?>
                    <button class="btn add" onclick="addCus(<?= htmlspecialchars($Ticket['CODE_TICKET']) ?>)">Thêm</button>
                  <?php else: ?>
                    <tr>
                      <td colspan="9">No customers found.</td>
                    </tr>
                  <?php endif; ?>
                </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li><a href="https://www.creative-tim.com" target="_blank">Creative Tim</a></li>
                <li><a href="https://www.creative-tim.com/blog" target="_blank">Blog</a></li>
                <li><a href="https://www.creative-tim.com/license" target="_blank">Licenses</a></li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by Creative Tim
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>

<script>
  function addCus() {
    window.location.href = "addCart.php";
  }
</script>
<script>
  function deleteCus(CODE_TICKET) {
    if (confirm("Bạn có chắc chắn muốn xóa khách hàng này không?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "delCart.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) { 
          window.location.reload();
        }
      };
      xhr.send("CODE_TICKET=" + CODE_TICKET);

    }
  }
</script>
</body>

</html>
