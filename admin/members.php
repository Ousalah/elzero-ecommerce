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

      // Check if Get Request userid is Numeric & Get The Interger Value of it
      $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET["userid"]) : 0;

      $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
      $stmt->execute(array($userid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();

      // Start Check if Member Exist
      if ($count > 0) :
?>
        <h1 class="text-center">Edit Member</h1>
        <div class="container">
          <form action="" class="form-horizontal">
            <!-- Start Username -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10 col-md-8">
                <input type="text" class="form-control" value="<?php echo $row["Username"]; ?>" name="username" autocomplete="off">
              </div>
            </div>
            <!-- End Username -->

            <!-- Start Password -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10 col-md-8">
                <input type="password" class="form-control" value="<?php echo $row["Password"]; ?>" name="password" autocomplete="new-password">
              </div>
            </div>
            <!-- End Password -->

            <!-- Start Email -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10 col-md-8">
                <input type="email" class="form-control" value="<?php echo $row["Email"]; ?>" name="email">
              </div>
            </div>
            <!-- End Email -->

            <!-- Start Full Name -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Full Name</label>
              <div class="col-sm-10 col-md-8">
                <input type="text" class="form-control" value="<?php echo $row["FullName"]; ?>" name="fullname">
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
      else:
        echo "There's no user with this ID";
      endif;
      // End Check if Member Exist
    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
