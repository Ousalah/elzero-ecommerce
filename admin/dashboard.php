<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';

    // Start Latest Members Section
    $latestUsers = 5; // Number of latest users
    $args = array(
      "fields"      => array("UserID", "Username", "RegStatus"),
      "table"       => "users",
      "orderBy"     => "UserID",
      "limit"       => $latestUsers
    );
    $users = getFrom($args); // Latest users array
    $latestUsersCount = count($users);
    $latestUsers = ($latestUsers >= $latestUsersCount) ? ($latestUsersCount > 0 ? $latestUsersCount : "") : $latestUsers;
    // End Latest Members Section

    // Start Latest Items Section
    $latestItems = 5; // Number of latest items
    $args = array(
      "fields"      => array("ItemID", "Name", "Approve"),
      "table"       => "items",
      "orderBy"     => "ItemID",
      "limit"       => $latestItems
    );
    $items = getFrom($args); // Latest items array
    $latestItemsCount = count($items);
    $latestItems = ($latestItems >= $latestItemsCount) ? ($latestItemsCount > 0 ? $latestItemsCount : "") : $latestItems;
    // End Latest Items Section

    // Start Latest Comments Section
    $latestComments = 5; // Number of latest comments
    $args = array(
      "fields"      => array("comments.*", "users.Username"),
      "table"       => "comments",
      "joins"       => array("table" => "users", "primary" => "UserID", "foreign" => "UserID"),
      "orderBy"     => "comments.CommentID",
      "limit"       => $latestComments
    );
    $comments = getFrom($args); // Latest comments array
    $latestCommentsCount = count($comments);
    $latestComments = ($latestComments >= $latestCommentsCount) ? ($latestCommentsCount > 0 ? $latestCommentsCount : "") : $latestComments;
    // End Latest Comments Section
?>
    <!-- Start Dashboard Page -->
    <div class="home-stats text-center">
      <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
          <div class="col-md-3">
            <div class="stat st-members">
              <i class="fa fa-users"></i>
              <div class="info">
                Total Members
                <?php $args = array("fields" => array("COUNT(UserID)"), "table" => "users"); ?>
                <span><a href="members.php"><?php echo getFrom($args, "fetchColumn"); ?></a></span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat st-pending">
              <i class="fa fa-user-plus"></i>
              <div class="info">
                Pending Members
                <?php $args = array("fields" => array("COUNT(UserID)"), "table" => "users", "conditions" => array('RegStatus' => 0)); ?>
                <span><a href="members.php?do=manage&page=pending"><?php echo getFrom($args, "fetchColumn"); ?></a></span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat st-items">
              <i class="fa fa-tags"></i>
              <div class="info">
                Total Items
                <?php $args = array("fields" => array("COUNT(ItemID)"), "table" => "items"); ?>
                <span><a href="items.php"><?php echo getFrom($args, "fetchColumn"); ?></a></span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat st-comments">
              <i class="fa fa-comments"></i>
              <div class="info">
                Total Comments
                <?php $args = array("fields" => array("COUNT(CommentID)"), "table" => "comments"); ?>
                <span><a href="comments.php"><?php echo getFrom($args, "fetchColumn"); ?></a></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="latest">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-users"></i> Latest <?php echo $latestUsers ?> Registred Users
                <span class="toggle-latest-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-users">
                  <?php
                    if ($latestUsersCount <= 0):
                      echo "<li class='text-center'>No Data to Show.</li>";
                    else:
                      foreach ($users as $user):
                        echo '<li>' . $user["Username"];
                          echo '<a href="members.php?do=edit&userid=' . $user['UserID'] . '" class="btn btn-success btn-xs pull-right"><i class="fa fa-edit"></i> Edit</a>';
                          if ($user["RegStatus"] == 0) echo '<a href="members.php?do=activate&userid=' . $user['UserID'] . '" class="btn btn-info btn-xs pull-right"><i class="fa fa-check"></i> Activate</a>';
                          echo "</li>";
                      endforeach;
                    endif;
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-tags"></i> Latest <?php echo $latestItems ?> Items
                <span class="toggle-latest-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-items">
                  <?php
                  if ($latestItemsCount <= 0):
                    echo "<li class='text-center'>No Data to Show.</li>";
                  else:
                    foreach ($items as $item):
                      echo '<li>' . $item["Name"];
                      echo '<a href="items.php?do=edit&itemid=' . $item['ItemID'] . '" class="btn btn-success btn-xs pull-right"><i class="fa fa-edit"></i> Edit</a>';
                      if ($item["Approve"] == 0) echo '<a href="items.php?do=approve&itemid=' . $item['ItemID'] . '" class="btn btn-info btn-xs pull-right"><i class="fa fa-check"></i> Approve</a>';
                      echo '</li>';
                    endforeach;
                  endif;
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- Start Latest Comments -->
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-comments"></i> Latest <?php echo $latestComments ?> Comments
                <span class="toggle-latest-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
              </div>
              <div class="panel-body">
                <div class="latest-comments">
                  <?php
                    if ($latestCommentsCount <= 0):
                      echo "<p class='text-center comment-box-empty'>No Data to Show.</p>";
                    else:
                      foreach ($comments as $comment):
                        echo '<div class="comment-box">';
                          echo '<span class="member-name"><a href="members.php?do=edit&userid=' . $comment['UserID'] . '">' . $comment["Username"] . '</a></span>';
                          echo '<p class="member-comment">' . $comment["Comment"];
                            echo '<a href="comments.php?do=delete&commentid=' . $comment['CommentID'] . '" class="btn btn-danger btn-xs pull-right confirm" title="Delete"><i class="fa fa-remove"></i></a>';
                            echo '<a href="comments.php?do=edit&commentid=' . $comment['CommentID'] . '" class="btn btn-success btn-xs pull-right" title="Edit"><i class="fa fa-edit"></i></a>';
                            if ($comment["Status"] == 0) echo '<a href="comments.php?do=approve&commentid=' . $comment['CommentID'] . '" class="btn btn-info btn-xs pull-right" title="Approve"><i class="fa fa-check"></i></a>';
                          echo '</p>';
                        echo '</div>';
                      endforeach;
                    endif;
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Latest Comments -->
      </div>
    </div>
    <!-- End Dashboard Page -->
<?php
    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
