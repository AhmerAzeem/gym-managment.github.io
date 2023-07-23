<?php
include "partials/header.php";

if (isset($_SESSION['unique_id'])) {
  header('location: ./dashboard.php');
  die();
}
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
  <!-- login area start -->
  <div class="login-area" style="
        background-image: url(images/4.jpg);
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      ">
    <div class="container">
      <div class="login-box ptb--100">
        <form id="loginform">
          <div class="login-form-head">
            <h4>Sign In</h4>
            <div class="error__message bg-danger text-white"></div>
          </div>
          <div class="login-form-body">
            <div class="form-gp">
              <label for="exampleInputEmail1">Username or email</label>
              <input type="text" name="username_or_email" />
              <i class="fa fa-user"></i>

            </div>
            <div class="form-gp">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" id="exampleInputPassword1" />
              <i class="ti-lock"></i>

            </div>
            <div class="text-left mb-3">
              <a href="#">Forgot Password?</a>
            </div>
            <div class="submit-btn-area">
              <button id="form_submit" type="submit">
                Submit <i class="ti-arrow-right"></i>
              </button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- login area end -->

  <!-- jquery latest version -->
  <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
  <!-- bootstrap 4 js -->
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/metisMenu.min.js"></script>
  <script src="assets/js/jquery.slimscroll.min.js"></script>
  <script src="assets/js/jquery.slicknav.min.js"></script>

  <!-- others plugins -->
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script src="./assets/js/main.js"></script>
</body>

</html>