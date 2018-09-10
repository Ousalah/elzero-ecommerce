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
    $stmt = $con->prepare("SELECT Username, Password FROM users WHERE username = ? AND password = ? AND GroupID = 1");
    $stmt->execute(array($username, $hashedPass));
    $count = $stmt->rowCount();

    // If Count > 0 This Mean The Database Contain Record About This Username
    if ($count > 0) {
      $_SESSION['Username'] = $username; // Register Session Name
      header('Location: dashboard.php'); // Redirect To Dashboard Page
      exit();
    }
  }
?>

  <form action="" class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h4 class="text-center"><?php lang('ADMIN_LOGIN') ?></h4>
    <input type="text" class="form-control" name="user" placeholder="<?php lang('ADMIN_PLACEHOLDER_USERNAME') ?>" autocomplete="off">
    <input type="password" class="form-control" name="pass" placeholder="<?php lang('ADMIN_PLACEHOLDER_PASSWORD') ?>" autocomplete="new-password">
    <input type="submit" class="btn btn-primary btn-block" value="<?php lang('ADMIN_BTN_LOGIN') ?>">
  </form>

<?php include $tpl . "footer.php"; ?>
