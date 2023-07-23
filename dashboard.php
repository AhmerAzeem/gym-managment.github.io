<?php

include "partials/header.php";

require "./php/config/database.php";

if (!isset($_SESSION['unique_id'])) {
  header('location: index.php');
  die();
}

$unique_id = $_SESSION['unique_id'];
?>

<body>
  <!--[if lt IE 8]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a> to improve
        your experience.
      </p>
    <![endif]-->
  <!-- preloader area start -->
  <div id="preloader">
    <div class="loader"></div>
  </div>
  <!-- preloader area end -->
  <!-- page container area start -->
  <div class="page-container">
    <!-- sidebar menu area start -->
    <div class="sidebar-menu">
      <div class="sidebar-header">
        <div class="logo">
          <a href="dashboard.php">
            <h3>GymSystem</h3>
          </a>
        </div>
      </div>
      <div class="main-menu">
        <div class="menu-inner">
          <nav>
            <ul class="metismenu" id="menu">
              <li class="active">
                <a href="dashboard.php"><i class="ti-dashboard"></i><span>Dashboard</span></a>
              </li>
              <li>
                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-keyboard-o"></i><span>Encoding Form</span></a>
                <ul class="collapse">
                  <li><a href="members.php">Members</a></li>
                </ul>
              </li>
              <li>
                <a href="payment.php"><i class="fa fa-money"></i><span>Payment</span></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- sidebar menu area end -->
    <!-- main content area start -->
    <div class="main-content" style="
          background-image: url(images/4.jpg);
          height: 100%;
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
        ">
      <!-- header area start -->
      <div class="header-area">
        <div class="row align-items-center">
          <!-- nav and search button -->
          <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <!-- profile info & task notification -->
          <div class="col-md-6 col-sm-4 clearfix">
            <ul class="notification-area pull-right">
              <li id="full-view"><i class="ti-fullscreen"></i></li>
              <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- header area end -->
      <!-- page title area start -->
      <div class="page-title-area">
        <?php
        $sql = "SELECT * FROM `user_admin` WHERE `unique_id`='$unique_id'";
        $sql_result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($sql_result) > 0) {
          $row = mysqli_fetch_assoc($sql_result);
        }
        ?>
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
              <h4 class="page-title pull-left">Dashboard</h4>
            </div>
          </div>
          <div class="col-sm-6 clearfix">
            <div class="user-profile pull-right">
              <img class="avatar user-thumb" src="./assets/images/<?= $row['avatar'] ?>" alt="avatar" />
              <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
                <?= $row['username'] ?> <i class="fa fa-angle-down"></i>
              </h4>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="./php/logout.php?logout_id=<?= $row['unique_id'] ?>">Log Out</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- page title area end -->
      <div class="main-content-inner">
        <!-- sales report area start -->
        <?php
        $sql2 = "SELECT * FROM members";
        $sql2_result = mysqli_query($connection, $sql2);

        $total_members = mysqli_num_rows($sql2_result);
        ?>
        <div class="sales-report-area mt-5 mb-5">
          <div class="row">
            <div class="col-md-4">
              <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="s-report-title d-flex justify-content-between">
                    <h4 class="header-title mb-0">Total Members</h4>
                    <h3><?= $total_members ?></h3>
                  </div>
                </div>
                <canvas id="coin_sales2" height="100"></canvas>
              </div>
            </div>
            <?php
            $sql3 = "SELECT SUM(`fee`) AS `total_income` FROM `payments`";
            $sql3_result = mysqli_query($connection, $sql3);

            $row2 = mysqli_fetch_assoc($sql3_result);

            $sum_result = $row2['total_income'];

            ?>
            <div class="col-md-4">
              <div class="single-report">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                  <div class="icon"><i class="fa fa-money"></i></div>
                  <div class="s-report-title d-flex justify-content-between">
                    <h4 class="header-title mb-0">Total Income</h4>
                    <h3><?= $sum_result ?></h3>
                  </div>
                </div>
                <canvas id="coin_sales3" height="100"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- main content area end -->
    <!-- footer area start-->
    <footer>
      <div class="footer-area">
        <p>
          © Copyright 2023. All right reserved.
          <a href="#">Gym Managment System</a>.
        </p>
      </div>
    </footer>
    <!-- footer area end-->
  </div>
  <!-- page container area end -->
  <!-- offset area start -->

  <!-- offset area end -->
  <!-- jquery latest version -->
  <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
  <!-- bootstrap 4 js -->
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/metisMenu.min.js"></script>
  <script src="assets/js/jquery.slimscroll.min.js"></script>
  <script src="assets/js/jquery.slicknav.min.js"></script>

  <!-- start chart js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <!-- start highcharts js -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <!-- start zingchart js -->
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = [
      "569d52cefae586f634c54f86dc99e6a9",
      "ee6b7db5b51705a13dc2339db3edaf6d",
    ];
  </script>
  <!-- all line chart activation -->
  <script src="assets/js/line-chart.js"></script>
  <!-- all pie chart -->
  <script src="assets/js/pie-chart.js"></script>
  <!-- others plugins -->
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/scripts.js"></script>
</body>

</html>