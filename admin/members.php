<?php
  /*
  ===================================================
  == Manage Members Page
  == You Can Add | Edit | Delete Members From Here
  ===================================================
  */
  session_start();
  $pageTitle = "Members";

  if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = (isset($_GET['do'])) ? $_GET['do'] : 'manage';
    if ($do == 'manage') { // Start Manage Page

    } elseif($do == 'edit') { // Start Edit Page
?>
      <h1 class="text-center">Edit Member</h1>
      <div class="container">
        <form action="" class="form-horizontal">
          <!-- Start Username -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="username" autocomplete="off">
            </div>
          </div>
          <!-- End Username -->

          <!-- Start Password -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-8">
              <input type="password" class="form-control" name="password" autocomplete="new-password">
            </div>
          </div>
          <!-- End Password -->

          <!-- Start Email -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
              <input type="email" class="form-control" name="email">
            </div>
          </div>
          <!-- End Email -->

          <!-- Start Full Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="fullname">
            </div>
          </div>
          <!-- End Full Name -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save">
            </div>
          </div>
          <!-- End Submit -->
        </form>
      </div>
<?php
    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
