<?php
  session_start();
  $pageTitle = 'Profile';

  include "init.php";

  if (isset($_SESSION['user'])) {
    // Start get user information
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($sessionUser));
    $userInfo = $getUser->fetch();
    // End get user information

?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">My Information</div>
          <div class="panel-body">
            Name: <?php echo $sessionUser ?> <br>
            Email: <?php echo $userInfo["Email"] ?> <br>
            FullName: <?php echo $userInfo["FullName"] ?> <br>
            Register Date: <?php echo $userInfo["Date"] ?> <br>
            Favourite Category:
          </div>
        </div>
      </div>
    </div>
    <div class="latest-ads block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Latest Ads</div>
          <div class="panel-body">Ads</div>
        </div>
      </div>
    </div>
    <div class="latest-comments block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Latest Comments</div>
          <div class="panel-body">Comments</div>
        </div>
      </div>
    </div>
<?php
  } else {
    header("Location: login.php");
    exit();
  }
?>
<?php include $tpl . "footer.php"; ?>
