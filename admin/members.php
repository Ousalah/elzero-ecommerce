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
          <form class="form-horizontal" action="?do=update" method="post">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
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
                <input type="hidden" value="<?php echo $row["Password"]; ?>" name="oldpassword" >
                <input type="password" class="form-control" name="newpassword" autocomplete="new-password">
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
    } elseif($do == 'update') { // Start Update Page
      echo "<h1 class='text-center'>Update Member</h1>";

      // Check if User Access to These Page by Post Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get Variables from the form
        $member_id       = $_POST["userid"];
        $member_username = $_POST["username"];
        $member_email    = $_POST["email"];
        $member_fullname = $_POST["fullname"];
        // Password Trick
        $member_password = (empty($_POST["newpassword"])) ? $_POST["oldpassword"] : sha1($_POST["newpassword"]);

        // Validate The form
        $form_errors = array();
        if (strlen($member_username) < 4) { $form_errors[] = "Username Can't be Less Than 4 Characters."; }
        if (strlen($member_username) > 20) { $form_errors[] = "Username Can't be More Than 20 Characters."; }
        if (empty($member_username)) { $form_errors[] = "Username Can't be Empty."; }
        if (empty($member_email)) { $form_errors[] = "Email Can't be Empty."; }
        if (empty($member_fullname)) { $form_errors[] = "Full Name Can't be Empty."; }

        foreach ($form_errors as $error) {
          echo $error . "<br>";
        }


        // Update The Database with This Info
        $stmt = $con->prepare("UPDATE users SET
                              Username = ?,Password = ?, Email = ?, FullName = ?
                              WHERE UserID = ?");
        $stmt->execute(array($member_username, $member_password, $member_email, $member_fullname, $member_id));

        // Echo Success Message
        echo $stmt->rowCount() . " Record Updated";
      } else {
        echo "Your can not browse to this page directly";
      }

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
