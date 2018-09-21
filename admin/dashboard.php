<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
?>
    <!-- Start Dashboard Page -->
    <div class="home-stats text-center">
      <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
          <div class="col-md-3">
            <div class="stat st-members">
              Total Members
              <span><a href="members.php"><?php echo countItems("UserID", "users"); ?></a></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat st-pending">
              Pending Members
              <span><a href="members.php?do=manage&page=pending"><?php echo countItems("UserID", "users", array('RegStatus' => 0)); ?></a></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat st-items">Total Items<span>1500</span></div>
          </div>
          <div class="col-md-3">
            <div class="stat st-comments">Total Comments<span>2504</span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="latest">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-users"></i> Latest Registred Users</div>
              <div class="panel-body">Test</div>
            </div>
          </div>
            <div class="col-sm-6">
              <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-tags"></i> Latest Items</div>
                <div class="panel-body">Test</div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <!-- End Dashboard Page -->
<?php
    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
