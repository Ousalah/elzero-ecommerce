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

    $do = (isset($_GET['do']) && !empty($_GET['do'])) ? $_GET['do'] : 'manage';
    if ($do == 'manage') { // Start Manage Page

      $conditions = array(array('key' => "GroupID", "operator" => "!=", "value" => 1));
      if (isset($_GET["page"]) && $_GET["page"] == "pending") {
        $conditions["RegStatus"] = 0;
      }
      $args = array(
        "table"       => "users",
        "conditions"  => $conditions,
        "orderBy"     => "UserID"
      );
      $rows = getFrom($args);
      $count = count($rows);
?>

      <h1 class='text-center'>Manage Members</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <th>#ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Full Name</th>
              <th>Registered Date</th>
              <th>Control</th>
            </tr>
            <?php if ($count > 0): ?>
              <?php foreach ($rows as $row): ?>
                <tr>
                  <td><?php echo $row["UserID"]; ?></td>
                  <td><?php echo $row["Username"]; ?></td>
                  <td><?php echo $row["Email"]; ?></td>
                  <td><?php echo $row["FullName"]; ?></td>
                  <td><?php echo $row["Date"]; ?></td>
                  <td>
                    <a href="?do=edit&userid=<?php echo $row["UserID"]; ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    <a href="?do=delete&userid=<?php echo $row["UserID"]; ?>" class="btn btn-danger btn-xs confirm"><i class="fa fa-remove"></i> Remove</a>
                    <?php if ($row["RegStatus"] == 0): ?>
                      <a href="?do=activate&userid=<?php echo $row["UserID"]; ?>" class="btn btn-info btn-xs"><i class="fa fa-check"></i> Activate</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan='6'>No Data to Show.</td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
        <a href="members.php?do=add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Memeber</a>
      </div>

<?php
    } elseif($do == 'add') { // Start Add Page
?>

      <h1 class="text-center">Add New Member</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=insert" method="post">
          <!-- Start Username -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="username" autocomplete="off" required="required" placeholder="Username to login into shop">
            </div>
          </div>
          <!-- End Username -->

          <!-- Start Password -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-8">
              <input type="password" class="form-control" name="password" autocomplete="new-password" required="required" placeholder="Password must be hard & complex">
              <i class="show-pass fa fa-eye-slash fa-2x"></i>
            </div>
          </div>
          <!-- End Password -->

          <!-- Start Email -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
              <input type="email" class="form-control" name="email" required="required" placeholder="example@domain.com">
            </div>
          </div>
          <!-- End Email -->

          <!-- Start Full Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="fullname" required="required" placeholder="Full name appear in your profile page">
            </div>
          </div>
          <!-- End Full Name -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Member">
            </div>
          </div>
          <!-- End Submit -->
        </form>
      </div>

<?php
    } elseif($do == 'insert') { // Start Insert Page

      echo "<h1 class='text-center'>Insert New Member</h1>";
      echo "<div class='container'>";

      // Check if User Access to These Page by Post Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get Variables from the form
        $member_username        = $_POST["username"];
        $member_password        = $_POST["password"];
        $member_email           = $_POST["email"];
        $member_fullname        = $_POST["fullname"];
        $member_hashed_password = sha1($member_password);

        // Validate The form
        $form_errors = array();
        if (strlen($member_username) < 4) { $form_errors[] = "<div class='alert alert-danger'>Username Can't be Less Than <strong>4 Characters</strong>.</div>"; }
        if (strlen($member_username) > 20) { $form_errors[] = "<div class='alert alert-danger'>Username Can't be More Than <strong>20 Characters</strong>.</div>"; }
        if (empty($member_username)) { $form_errors[] = "<div class='alert alert-danger'>Username Can't be <strong>Empty</strong>.</div>"; }
        if (empty($member_password)) { $form_errors[] = "<div class='alert alert-danger'>Password Can't be <strong>Empty</strong>.</div>"; }
        if (empty($member_email)) { $form_errors[] = "<div class='alert alert-danger'>Email Can't be <strong>Empty</strong>.</div>"; }
        if (empty($member_fullname)) { $form_errors[] = "<div class='alert alert-danger'>Full Name Can't be <strong>Empty</strong>.</div>"; }
        // Check If Username Exist in Database
        if(checkItem("Username", "users", $member_username)) { $form_errors[] = "<div class='alert alert-danger'>This username is already <strong>taken</strong>.</div>"; }
        // Check If Email Exist in Database
        if(checkItem("Email", "users", $member_email)) { $form_errors[] = "<div class='alert alert-danger'>This email address is <strong>not available</strong>. choose a different address.</div>"; }

        // Check If There's No Error, Proceed The Insert Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          // Insert User Info in Database
          $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date)
          VALUES(:username, :pass, :mail, :name, 1, now())");
          $stmt->execute(array(
            'username' => $member_username,
            'pass'     => $member_hashed_password,
            'mail'     => $member_email,
            'name'     => $member_fullname
          ));

          // Echo Success Message
          $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record Inserted.</div>";
          redirectHome($msg, "back");
        endif;

      } else {
        $msg = "<div class='alert alert-danger'>Your can not browse to this page <strong>directly</strong>.</div>";
        redirectHome($msg);
      }
      echo "</div>";

    } elseif($do == 'edit') { // Start Edit Page

      // Check if Get Request userid is Numeric & Get The Interger Value of it
      $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET["userid"]) : 0;

      $args = array(
        "table"       => "users",
        "conditions"  => array('UserID' => $userid),
        "limit"       => 1
      );
      $row = getFrom($args, "fetch");

      // Start Check if Member Exist
      echo '<h1 class="text-center">Edit Member</h1>';
      echo '<div class="container">';
      if (!empty($row)) :
?>
        <form class="form-horizontal" action="?do=update" method="post">
          <input type="hidden" name="userid" value="<?php echo $userid; ?>">
          <!-- Start Username -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" value="<?php echo $row["Username"]; ?>" name="username" autocomplete="off" required="required">
            </div>
          </div>
          <!-- End Username -->

          <!-- Start Password -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-8">
              <input type="hidden" value="<?php echo $row["Password"]; ?>" name="oldpassword" >
              <input type="password" class="form-control" name="newpassword" placeholder="Leave blank if you don't want to change it" autocomplete="new-password">
            </div>
          </div>
          <!-- End Password -->

          <!-- Start Email -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
              <input type="email" class="form-control" value="<?php echo $row["Email"]; ?>" name="email" required="required">
            </div>
          </div>
          <!-- End Email -->

          <!-- Start Full Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" value="<?php echo $row["FullName"]; ?>" name="fullname" required="required">
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
<?php
      else:
        $msg = "<div class='alert alert-danger'>There's no user with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";
      // End Check if Member Exist

    } elseif($do == 'update') { // Start Update Page

      echo "<h1 class='text-center'>Update Member</h1>";
      echo "<div class='container'>";

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
        if (strlen($member_username) < 4) { $form_errors[] = "<div class='alert alert-danger'>Username Can't be Less Than <strong>4 Characters</strong>.</div>"; }
        if (strlen($member_username) > 20) { $form_errors[] = "<div class='alert alert-danger'>Username Can't be More Than <strong>20 Characters</strong>.</div>"; }
        if (empty($member_username)) { $form_errors[] = "<div class='alert alert-danger'>Username Can't be <strong>Empty</strong>.</div>"; }
        if (empty($member_email)) { $form_errors[] = "<div class='alert alert-danger'>Email Can't be <strong>Empty</strong>.</div>"; }
        if (empty($member_fullname)) { $form_errors[] = "<div class='alert alert-danger'>Full Name Can't be <strong>Empty</strong>.</div>"; }
        // Check If Username Exist in Database
        if(checkItem("Username", "users", $member_username, "UserID", $member_id)) { $form_errors[] = "<div class='alert alert-danger'>This username is already <strong>taken</strong>.</div>"; }
        // Check If Email Exist in Database
        if(checkItem("Email", "users", $member_email, "UserID", $member_id)) { $form_errors[] = "<div class='alert alert-danger'>This email address is <strong>not available</strong>. choose a different address.</div>"; }

        // Check If There's No Error, Proceed The Update Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          // Update The Database with This Info
          $stmt = $con->prepare("UPDATE users SET
            Username = ?, Password = ?, Email = ?, FullName = ?
            WHERE UserID = ?");
          $stmt->execute(array($member_username, $member_password, $member_email, $member_fullname, $member_id));

          // Echo Success Message
          $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record Updated.</div>";
          redirectHome($msg, "back");
        endif;

      } else {
        $msg = "<div class='alert alert-danger'>Your can not browse to this page <strong>directly</strong>.</div>";
        redirectHome($msg);
      }
      echo "</div>";

    } elseif($do == 'delete') { // Start Delete Page

      // Check if Get Request userid is Numeric & Get The Interger Value of it
      $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET["userid"]) : 0;

      // Start Check if Member Exist
      echo '<h1 class="text-center">Delete Member</h1>';
      echo '<div class="container">';
      if (checkItem("UserID", "users", $userid)) :
        $stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid");
        $stmt->bindParam(":userid", $userid);
        $stmt->execute();

        // Echo Success Message
        $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record Deleted.</div>";
        redirectHome($msg, "back");
      else:
        $msg = "<div class='alert alert-danger'>There's no user with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";
      // End Check if Member Exist

    } elseif ($do == 'activate') { // Start Activate Page

      // Check if Get Request userid is Numeric & Get The Interger Value of it
      $userid = (isset($_GET["userid"]) && is_numeric($_GET["userid"])) ? intval($_GET["userid"]) : 0;

      echo '<h1 class="text-center">Activate Member</h1>';
      echo '<div class="container">';
      if (checkItem("UserID", "users", $userid)) :
        $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
        $stmt->execute(array($userid));

        // Echo Success Message
        $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record Updated.</div>";
        redirectHome($msg, "back");
      else:
        $msg = "<div class='alert alert-danger'>There's no user with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
