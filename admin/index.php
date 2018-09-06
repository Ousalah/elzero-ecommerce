<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    header('Location: dashboard.php'); // Redirect To Dashboard Page
  }

  include "init.php";
  include $tpl . "header.php";
  include $lang . "english.php";

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
    <h4 class="text-center">Admin Login</h4>
    <input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off">
    <input type="password" class="form-control" name="pass" placeholder="Password" autocomplete="new-password">
    <input type="submit" class="btn btn-primary btn-block" value="Login">
  </form>

<?php include $tpl . "footer.php"; ?>
