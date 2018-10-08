<?php
  session_start();
  $pageTitle = 'Login';

  if (isset($_SESSION['user'])) {
    header('Location: index.php'); // Redirect To Home Page
  }

  include "init.php";

  // Check if User Coming From HTTP Post Request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST["login"])):

      $username = $_POST['username'];
      $password = $_POST['password'];
      $hashedPass = sha1($password);

      // Check if The User Exist in Database
      $stmt = $con->prepare("SELECT Username, Password FROM users WHERE username = ? AND password = ?");
      $stmt->execute(array($username, $hashedPass));
      $count = $stmt->rowCount();

      // If Count > 0 This Mean The Database Contain Record About This Username
      if ($count > 0):
        $_SESSION['user']     = $username; // Register Session Name
        header('Location: index.php'); // Redirect To Home Page
        exit();
      endif;

    else:

      $formErrors = array();

      if (isset($_POST["username"])) {
        $filterUsername = trim(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        if (strlen($filterUsername) < 4) { $formErrors[] = "Username can't be less than 4 characters."; }
      }

      if (isset($_POST["password"]) && isset($_POST["password-confirmation"])) {
        if (empty($_POST["password"])) { $formErrors[] = "Sorry password can't be empty."; }
        $pass1 = sha1($_POST["password"]);
        $pass2 = sha1($_POST["password-confirmation"]);
        if ($pass1 !== $pass2) { $formErrors[] = "Sorry password is not match."; }
      }

      if (isset($_POST["email"])) {
        $filterEmail = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) { $formErrors[] = "Email not valid."; }
      }

    endif;

  }
?>

<div class="container login-page">
  <h1 class="text-center">
    <span class="selected" data-class="login">Login</span> |
    <span data-class="singup">Singup</span>
  </h1>
  <!-- Start login form -->
  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="input-container">
      <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
    </div>
    <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
  </form>
  <!-- End login form -->

  <!-- Start singup form -->
  <form class="singup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="input-container">
      <input type="text" class="form-control" name="username" placeholder="Username" required pattern=".{4,8}" title="Username must be between 4 and 8 characters" autocomplete="off">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password" placeholder="Password" required minlength="4" autocomplete="new-password">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password-confirmation" placeholder="Password Confirmation" required minlength="4" autocomplete="new-password">
    </div>
    <div class="input-container">
      <input type="email" class="form-control" name="email" placeholder="example@domain.com" required>
    </div>
    <input type="submit" class="btn btn-success btn-block" name="singup" value="Singup">
  </form>
  <!-- End singup form -->

  <!-- Start -->
  <div class="the-errors text-center">
    <?php
      if (!empty($formErrors)) {
        foreach ($formErrors as $error) {
          echo $error . "<br>";
        }
      }
    ?>
  </div>
  <!-- End -->
</div>

<?php include $tpl . "footer.php"; ?>
