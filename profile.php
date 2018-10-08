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

    // Start get user comments
    $getUserComments = $con->prepare("SELECT comments.*, items.Name FROM comments
                          INNER JOIN items ON items.ItemID = comments.ItemID
                          WHERE comments.UserID = ?");
    $getUserComments->execute(array($userInfo["UserID"]));
    $userComments = $getUserComments->fetchAll();
    $countUserComments = $getUserComments->rowCount();
    // End get user comments


?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">My Information</div>
          <div class="panel-body">
            <ul class="list-unstyled">
              <li>
                <i class="fa fa-unlock-alt fa-fw"></i>
                <span>Login Name</span>: <?php echo $sessionUser ?>
              </li>
              <li>
                <i class="fa fa-envelope-o fa-fw"></i>
                <span>Email</span>: <?php echo $userInfo["Email"] ?>
              </li>
              <li>
                <i class="fa fa-user fa-fw"></i>
                <span>FullName</span>: <?php echo $userInfo["FullName"] ?>
              </li>
              <li>
                <i class="fa fa-calendar fa-fw"></i>
                <span>Register Date</span>: <?php echo $userInfo["Date"] ?>
              </li>
              <li>
                <i class="fa fa-star fa-fw"></i>
                <span>Fav Category</span>:
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="latest-ads block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Latest Ads</div>
          <div class="panel-body">
            <?php if (checkItem("MemberID", "items", $userInfo['UserID'])): ?>
              <div class="row">
                <?php foreach (getItems("MemberID", $userInfo['UserID']) as $item): ?>
                  <div class="col-sm-6 col-md-3">
                    <div class="thumbnail item-box">
                      <span class="item-price"><?php echo $item["Price"] ?></span>
                      <img class="img-responsive" src="https://via.placeholder.com/350x200" alt="">
                      <div class="caption">
                        <h3><?php echo $item["Name"] ?></h3>
                        <p><?php echo $item["Description"] ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div>You don't have any ads yet!</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="latest-comments block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Latest Comments</div>
          <div class="panel-body">
            <?php
            if ($countUserComments <= 0):
              echo "<div>You don't have any comment yet!.</div>";
            else:
              foreach ($userComments as $comment):
                echo '<div class="comment-box">';
                  echo '<strong>' . $comment["Name"] . ':</strong> ';
                  echo '<span>' . $comment["Comment"] . '</span>';
                echo '</div>';
              endforeach;
            endif;
            ?>
          </div>
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
