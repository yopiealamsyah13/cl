<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $page_name; ?></title>
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/css/main2.css">
<!--===============================================================================================-->
  </head>

  <body style="background-image: url('<?php echo base_url();?>assets/login/images/BG_tracy_rev_WEBCL.jpg');">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-4 ml-auto card-cov">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center"><b>CREDIT LIMIT</b></h5>
            <form class="form-signin" role="form" method="post" accept-charset="utf-8" action="<?php echo site_url('login'); ?>">
              
              <input type="hidden" name="prev" value="<?php echo $this->session->userdata('previous_url'); ?>">
              
              <div class="form-label-group">
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required autofocus>
                <label for="inputEmail">Email</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              <input type="checkbox" onclick="myFunction()">Show Password
              <br>
              <div class="col text-center">
              <button class="btn btn-xl text-uppercase" type="submit">LOG IN</button>
              </div>
            </form>
            <br>
            <a class="col text-center alert">
            <?php echo $error_message;?>
            </a>
          </div>
            <p class="text-center">Property of <a style="color:#f36a22;">SEFAS Group</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
function myFunction() {
  var x = document.getElementById("inputPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

</script>

<!--===============================================================================================-->
<script src="<?php echo base_url(); ?>assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="<?php echo base_url(); ?>assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="<?php echo base_url(); ?>assets/login/js/main.js"></script>

</html>
