<?php
include "partials/header.php";
if (!isset($_SESSION['unique_id'])) {
    header('location: index.php');
    die();
}

$unique_id = $_SESSION['unique_id'];
?>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
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

                <!-- Logo Brand -->
                <div class="logo">
                    <a href="dashboard.php">
                        <h3>GymSystem</h3>
                    </a>
                </div>
            </div>

            <!-- Main Menu -->

            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="dashboard.php"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-keyboard-o"></i><span>Encoding Form</span></a>
                                <ul class="collapse">
                                    <li><a href="members.php">Members</a></li>
                                </ul>
                            </li>
                            <li class="active">
                                <a href="payment.php"><i class="fa fa-money"></i><span>Payment</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content" style="background-image: url(images/4.jpg); height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;">
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
            <?php
            $sql = "SELECT * FROM `user_admin` WHERE `unique_id`='$unique_id'";
            $sql_result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($sql_result) > 0) {
                $row = mysqli_fetch_assoc($sql_result);
            }
            ?>
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Payment</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="./assets/images/<?= $row['avatar'] ?>" alt="avatar" />
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?= $row['username'] ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./php/logout.php?logout_id=<?= $row['unique_id'] ?>">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">

                <div class="row">
                    <!-- Primary table start -->
                    <div class="col-12 mt-5">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Data Table</h4>

                                <!-- Data Table -->

                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center">

                                        <!-- Table Head -->

                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>Member ID</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Fee Month</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <!-- Table Body -->

                                        <?php
                                        $sql3 = "SELECT * FROM `payments`";
                                        $sql3_result = mysqli_query($connection, $sql3);
                                        ?>

                                        <tbody>
                                            <?php while ($row2 = mysqli_fetch_assoc($sql3_result)) : ?>
                                                <tr>
                                                    <td><?= $row2['memberid'] ?></td>
                                                    <td><?= $row2['name'] ?></td>
                                                    <td><?= $row2['fee'] ?></td>
                                                    <?php
                                                    $monthNum = $row2['month'];
                                                    $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                                    $monthName = $dateObj->format('F');
                                                    $month = $monthName . " " . $row2['year'];
                                                    ?>
                                                    <td><?= $month ?></td>
                                                    <td><?= $row2['created_at'] ?></td>
                                                    <td><?= $row2['updated_at'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs mb-3" data-toggle="modal" data-target="#update__payment">
                                                            <i class="fa fa-edit"></i>
                                                            Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile ?>
                                        </tbody>
                                    </table>

                                    <!-- Add Payment Form Modal -->

                                    <div class="modal fade" id="add" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <form id="addpayment__form">
                                                <div class="modal-content">


                                                    <!-- Modal Header -->

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add Payment</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                                                    </div>

                                                    <!-- Modal Body -->

                                                    <div class="modal-body">
                                                        <?php
                                                        $sql2 = "SELECT * FROM members";
                                                        $sql2_result = mysqli_query($connection, $sql2);
                                                        ?>
                                                        <div class="card-body">
                                                            <p class="alert__message text-center bg-danger text-white my-2"></p>
                                                            <p class="alert__message bg-danger text-white text-center my-2"></p>
                                                            <div class="form-group">
                                                                <select class="form-control" name="memberid">
                                                                    <option>Select Member ID</option>
                                                                    <?php while ($row3 = mysqli_fetch_assoc($sql2_result)) : ?>
                                                                        <option><?= $row3['memberid'] ?></option>
                                                                    <?php endwhile ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 65%"><i class="fa fa-times"></i> Close</button>
                                                        <button type="submit" form="addpayment__form" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                    $sql2 = "SELECT * FROM members";
                                    $sql2_result = mysqli_query($connection, $sql2);
                                    ?>

                                    <!-- Edit Payment Form Modal -->


                                    <div class="modal fade" id="update__payment" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <form id="updatepayment__form">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Payment</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <p class="alert__message bg-danger text-white text-center my-2"></p>
                                                            <div class="form-group">
                                                                <select class="form-control" name="memberid" disabled>
                                                                    <option>Select Member ID</option>
                                                                    <?php while ($row3 = mysqli_fetch_assoc($sql2_result)) : ?>
                                                                        <option><?= $row3['memberid'] ?></option>
                                                                    <?php endwhile ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3">Amount</span>
                                                                </div>
                                                                <input type="number" name="amount" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Amount Payment">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 65%"><i class="fa fa-times"></i> Close</button>
                                                        <button type="submit" id="editpayment__btn" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Primary table end -->
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
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>