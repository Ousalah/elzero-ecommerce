<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';

    // Start Latest Members Section
    $latestUsers = 5; // Number of latest users
    $users = getLatest("*", "users", "UserID", $latestUsers); // Latest users array
    $latestUsersCount = count($users);
    $latestUsers = ($latestUsers >= $latestUsersCount) ? ($latestUsersCount > 0 ? $latestUsersCount : "") : $latestUsers;
    // End Latest Members Section

    // Start Latest Items Section
    $latestItems = 5; // Number of latest items
    $items = getLatest("*", "items", "ItemID", $latestItems); // Latest items array
    $latestItemsCount = count($items);
    $latestItems = ($latestItems >= $latestItemsCount) ? ($latestItemsCount > 0 ? $latestItemsCount : "") : $latestItems;
    // End Latest Items Section
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
            <div class="stat st-items">
              Total Items
              <span><a href="items.php"><?php echo countItems("ItemID", "items"); ?></a></span>
            </div>
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
              <div class="panel-heading"><i class="fa fa-users"></i> Latest <?php echo $latestUsers ?> Registred Users</div>
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
                <div class="panel-heading"><i class="fa fa-tags"></i> Latest <?php echo $latestItems ?> Items</div>
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
                            echo "</li>";
                        endforeach;
                      endif;
                    ?>
                  </ul>
                </div>
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
