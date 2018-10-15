<?php
  session_start();
  $noNavbar = '';
  $pageTitle = 'Login';

  if (isset($_SESSION['Username'])) {
    header('Location: dashboard.php'); // Redirect To Dashboard Page
  }

  include "init.php";

  // Check if User Coming From HTTP Post Request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);

    // Check if The User Exist in Database
    $args = array(
      "fields"      => array("UserID", "Username", "Password"),
      "table"       => "users",
      "conditions"  => array('username' => $username, "password" => $hashedPass, "GroupID" => 1),
      "limit"       => 1
    );
    $row = getFrom($args, "fetch");

    // If Count > 0 This Mean The Database Contain Record About This Username
    if (!empty($row)) {
      $_SESSION['Username'] = $username; // Register Session Name
      $_SESSION['ID']       = $row['UserID']; // Register Session ID
      header('Location: dashboard.php'); // Redirect To Dashboard Page
      exit();
    }
  }
?>

  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h4 class="text-center"><?php lang('ADMIN_LOGIN') ?></h4>
    <input type="text" class="form-control" name="user" placeholder="<?php lang('ADMIN_PLACEHOLDER_USERNAME') ?>" autocomplete="off">
    <input type="password" class="form-control" name="pass" placeholder="<?php lang('ADMIN_PLACEHOLDER_PASSWORD') ?>" autocomplete="new-password">
    <input type="submit" class="btn btn-primary btn-block" value="<?php lang('ADMIN_BTN_LOGIN') ?>">
  </form>

<?php include $tpl . "footer.php"; ?>
