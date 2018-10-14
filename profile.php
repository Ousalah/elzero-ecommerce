<?php
  session_start();
  $pageTitle = 'Profile';

  include "init.php";

  if (isset($_SESSION['user'])) {
    // Start get user information
    $args = array("table" => "users", "conditions"  => array('Username' => $sessionUser));
    $userInfo = getFrom($args, "fetch");
    // End get user information

    // Start get user comments
    $args = array(
      "fields"      => array("comments.*", "items.Name"),
      "table"       => "comments",
      "joins"       => array("table" => "items", "primary" => "ItemID", "foreign" => "ItemID"),
      "conditions"  => array('comments.UserID' => $userInfo["UserID"]),
      "orderBy"     => "comments.CommentID"
    );
    $userComments = getFrom($args);
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
            <a href="#" class="btn btn-primary">Edit profile</a>
          </div>
        </div>
      </div>
    </div>
    <div class="latest-items block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Latest Items</div>
          <div class="panel-body">
            <?php if (checkItem("MemberID", "items", $userInfo['UserID'])): ?>
              <div class="row">
                <?php $args = array("table" => "items", "conditions" => array('MemberID' => $userInfo['UserID']), "orderBy" => "ItemID"); ?>
                <?php foreach (getFrom($args) as $item): ?>
                  <div class="col-sm-6 col-md-3">
                    <div class="thumbnail item-box">
                      <?php if ($item["Approve"] == 0): ?>
                        <span class="item-approved-status">Pending</span>
                      <?php endif; ?>
                      <span class="item-price"><?php echo $item["Price"] ?></span>
                      <img class="img-responsive" src="https://via.placeholder.com/350x200" alt="">
                      <div class="caption">
                        <h3><a href="items.php?itemid=<?php echo $item["ItemID"] ?>"><?php echo $item["Name"] ?></a></h3>
                        <p><?php echo $item["Description"] ?></p>
                        <div class="item-date"><?php echo $item["Add_Date"] ?></div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div>You don't have any item yet!, Create <a href="newad.php">new item</a>.</div>
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
            if (empty($userComments)):
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
