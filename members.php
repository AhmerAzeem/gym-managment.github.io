<?php
include "partials/header.php";
if (!isset($_SESSION['unique_id'])) {
  header('location: index.php');
  die();
}

$unique_id = $_SESSION['unique_id'];
?>
<style>
  .hide {
    display: none;
  }

  #payment th,
  #payment td {
    padding: 8px;
  }
</style>

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
              <li>
                <a href="dashboard.php"><i class="ti-dashboard"></i><span>Dashboard</span></a>
              </li>
              <li class="active">
                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-keyboard-o"></i><span>Encoding Form</span></a>
                <ul class="collapse">
                  <li class="active"><a href="members.php">Members</a></li>
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
              <h4 class="page-title pull-left">Membership</h4>
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

        <?php
        $sql2 = "SELECT * FROM members";
        $sql2_result = mysqli_query($connection, $sql2);
        ?>

        <div class="row">
          <!-- Primary table start -->
          <div class="col-12 mt-5">
            <div class="card">
              <div class="card-body">
                <button type="button" class="btn btn-success btn-xs mb-3" data-toggle="modal" data-target="#add" style="margin-left: 95%">
                  <i class="fa fa-plus"></i>Add
                </button>
                <p class="alert__message text-center bg-danger text-white my-2" style="width: 400px;margin:0 auto"></p>
                <button type="button" class="btn btn-success btn-xs mb-3" data-toggle="modal" data-target="#generate_fee" style="margin-left: 93%">
                  Generate Fee
                </button>
                <h4 class="header-title">Data Table</h4>
                <div class="data-tables datatable-primary">
                  <table id="dataTable2" class="text-center">
                    <thead class="text-capitalize">
                      <tr>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Date joined</th>
                        <th>Fee</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($row2 = mysqli_fetch_assoc($sql2_result)) : ?>
                        <tr>
                          <td><?= $row2['id'] ?></td>
                          <td><?= "{$row2['fname']} {$row2['lname']}" ?></td>
                          <td><?= $row2['contact'] ?></td>
                          <td><?= $row2['address'] ?></td>
                          <td><?= $row2['email'] ?></td>
                          <td><?= $row2['datejoined'] ?></td>
                          <td><?= $row2['fee'] ?></td>
                          <td>


                            <?php if ($row2['status'] == 'absent') : ?>
                              <button type="button" class="btn btn-info btn-xs" id="activate__member" data-toggle="modal" data-id="<?= $row2['id'] ?>">
                                Activate
                              </button>
                            <?php else : ?>

                              <button type="button" class="btn btn-danger btn-xs" id="deactivate__member" data-toggle="modal" data-id="<?= $row2['id'] ?>">
                                Deactivate
                              </button>
                            <?php endif ?>
                            <button type="button" class="btn btn-info btn-xs" data-id="<?= $row2['id'] ?>" id="receivefee__btn" data-toggle="modal" data-target="#payment">
                              <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            </button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-info btn-xs mb-3" data-toggle="modal" data-target="#update__member" data-id="<?= $row2['id'] ?>" data-fname="<?= $row2['fname'] ?>" data-lname="<?= $row2['lname'] ?>" data-contact="<?= $row2['contact'] ?>" data-email="<?= $row2['email'] ?>" data-address="<?= $row2['address'] ?>" data-fee="<?= $row2['fee'] ?>">
                              <i class="fa fa-edit"></i> Edit
                            </button>
                          </td>
                        </tr>
                      <?php endwhile ?>
                    </tbody>
                  </table>
                  <!-- MODAL -->
                  <div class="modal fade" id="add" aria-hidden="true" style="display: none">
                    <div class="modal-dialog">
                      <form id="addmember__form">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Add Member</h5>
                            <button type="button" class="close" data-dismiss="modal">
                              <span>×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="card-body">
                              <p class="alert__message text-center bg-danger text-white my-2"></p>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">First Name</span>
                                </div>
                                <input type="text" name="fname" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter First Name" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Last Name</span>
                                </div>
                                <input type="text" name="lname" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Last Name" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Contact</span>
                                </div>
                                <input type="text" name="contact" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Contact" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Address</span>
                                </div>
                                <input type="text" name="address" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Address" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Email</span>
                                </div>
                                <input type="email" name="email" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Email -@-" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Fee</span>
                                </div>
                                <input type="number" name="fee" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Fee" />
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 65%">
                              <i class="fa fa-times"></i> Close
                            </button>
                            <button type="submit" form="addmember__form" id="addmembership__btn" class="btn btn-primary">
                              <i class="fa fa-check"></i> Save
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="update__member" aria-hidden="true" style="display: none">
                    <div class="modal-dialog">
                      <form id="updatemember__from">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Update Member</h5>
                            <button type="button" class="close" data-dismiss="modal">
                              <span>×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="card-body">
                              <p class="alert__message text-center bg-danger text-white my-2"></p>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Member ID</span>
                                </div>
                                <input type="text" name="memberid" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Id" disabled />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">First Name</span>
                                </div>
                                <input type="text" name="fname" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter First Name" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Last Name</span>
                                </div>
                                <input type="text" name="lname" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Last Name" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Contact</span>
                                </div>
                                <input type="text" name="contact" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Contact" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Address</span>
                                </div>
                                <input type="text" name="address" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Address" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Email</span>
                                </div>
                                <input type="email" name="email" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Email -@-" />
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Fee</span>
                                </div>
                                <input type="number" name="fee" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Fee" />
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 65%">
                              <i class="fa fa-times"></i> Close
                            </button>
                            <button type="submit" id="editmembership__btn" class="btn btn-primary">
                              <i class="fa fa-check"></i> Save
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="generate_fee" aria-hidden="true" style="display: none">
                    <div class="modal-dialog">
                      <form id="generatefee__form">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Generate Fee</h5>
                            <button type="button" class="close" data-dismiss="modal">
                              <span>×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="card-body">
                              <p class="error__message text-center bg-danger text-white my-2"></p>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Fee Month</span>
                                </div>
                                <select class="form-control" name="feemonth">
                                  <option>Select Month</option>
                                  <option value="1">January</option>
                                  <option value="2">February</option>
                                  <option value="3">March</option>
                                  <option value="4">April</option>
                                  <option value="5">May</option>
                                  <option value="6">June</option>
                                  <option value="7">July</option>
                                  <option value="8">August</option>
                                  <option value="9">September</option>
                                  <option value="10">October</option>
                                  <option value="11">November</option>
                                  <option value="12">December</option>
                                </select>
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon3">Fee Year</span>
                                </div>
                                <select class="form-control" name="feeyear">
                                  <option>Select Year</option>
                                  <?php
                                  for ($i = 2011; $i <= date("Y"); $i++) {
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="input-group mb-3 d-flex align-items-center">
                                <input type="radio" id="generatefee" value="allmembers" name="generatefee" class="mr-2" checked>
                                <label for="allmember" class="mb-0">For all members</label>
                              </div>
                              <div class="input-group mb-3 d-flex align-items-center">
                                <input type="radio" id="generatefee" value="singlemember" name="generatefee" class="mr-2">
                                <label for="allmember" class="mb-0">For single members</label>
                              </div>
                              <div id="forsingle" class="hide">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Member ID</span>
                                  </div>
                                  <input type="number" name="memberid" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member ID" />
                                </div>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Member Name</span>
                                  </div>
                                  <input type="text" name="name" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Enter Member Name" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 60%">
                              <i class="fa fa-times"></i> Close
                            </button>
                            <button type="submit" id="generatefee__btn" form="addpayment__form" class="btn btn-primary">
                              <i class="fa fa-check"></i> Generate
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="payment" aria-hidden="true" style="display: none">
                    <div class="modal-dialog" style="max-width: 1200px;">
                      <form id="receivefee__form">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Receive Fee</h5>
                            <button type="button" class="close" data-dismiss="modal">
                              <span>×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="error__message text-center bg-danger text-white my-2 d-none"></p>
                            <div class="card-body">
                              <table id="recievefeetable" class="w-100">
                                <thead>
                                  <tr>
                                    <th>Member ID</th>
                                    <th>Name</th>
                                    <th>Month</th>
                                    <th>Total</th>
                                    <th>Due</th>
                                    <th>Pay</th>
                                  </tr>
                                </thead>
                                <tbody id="payment_body">

                                </tbody>
                                <tfoot>
                                  <?php
                                  $time = date("d/m/Y");
                                  ?>
                                  <tr>
                                    <td></td>
                                    <td class="d-flex align-items-center">
                                      <span style="font-size: 15px;">Date:</span>
                                      <input type="text" id="currunt_date" class="form-control" value="<?= $time ?>" style="width: 200px;font-size:16px">
                                    </td>
                                    <td>Total</td>
                                    <td id="totalamountsum"></td>
                                    <td id="actualdueamount"></td>
                                    <td><input type="text" id="TotalReceived" class="form-control" style="width: 250px;margin:0" readonly></td>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 60%">
                                <i class="fa fa-times"></i> Close
                              </button>
                              <button type="submit" form="receivefee__form" id="recievefee__btn" class="btn btn-primary">
                                <i class="fa fa-check"></i> Save
                              </button>
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

  </div>
  <!-- page container area end -->
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