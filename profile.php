<?php
  session_start();
  $pageTitle = 'Profile';

  include "init.php";

?>
  <h1 class="text-center">My Profile</h1>
  <div class="information block">
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-heading">My Information</div>
        <div class="panel-body">Name: Mohamed</div>
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
<?php include $tpl . "footer.php"; ?>
