<?php
  /*
  ========================================================
  == Manage Comments Page
  == You Can Edit | Update | Approve Comments From Here
  ========================================================
  */
  session_start();
  $pageTitle = "Comments";

  if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = (isset($_GET['do']) && !empty($_GET['do'])) ? $_GET['do'] : 'manage';
    if ($do == 'manage') { // Start Manage Page

      $stmt = $con->prepare("SELECT comments.*, items.Name, users.Username FROM comments
                            INNER JOIN items ON items.ItemID = comments.ItemID
                            INNER JOIN users ON users.UserID = comments.UserID");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      $count = $stmt->rowCount();
?>

      <h1 class='text-center'>Manage Comments</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <th>#ID</th>
              <th>Comments</th>
              <th>Item</th>
              <th>Username</th>
              <th>Added Date</th>
              <th>Control</th>
            </tr>
            <?php if ($count > 0): ?>
              <?php foreach ($rows as $row): ?>
                <tr>
                  <td><?php echo $row["CommentID"]; ?></td>
                  <td><?php echo $row["Comment"]; ?></td>
                  <td><?php echo $row["Name"]; ?></td>
                  <td><?php echo $row["Username"]; ?></td>
                  <td><?php echo $row["Comment_Date"]; ?></td>
                  <td>
                    <a href="?do=edit&commentid=<?php echo $row["CommentID"]; ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    <a href="?do=delete&commentid=<?php echo $row["CommentID"]; ?>" class="btn btn-danger btn-xs confirm"><i class="fa fa-remove"></i> Remove</a>
                    <?php if ($row["Status"] == 0): ?>
                      <a href="?do=approve&commentid=<?php echo $row["CommentID"]; ?>" class="btn btn-info btn-xs"><i class="fa fa-check"></i> Approve</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan='6'>No Data to Show.</td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
      </div>

<?php
    } elseif($do == 'edit') { // Start Edit Page

    } elseif($do == 'update') { // Start Update Page

    } elseif($do == 'delete') { // Start Delete Page

    } elseif ($do == 'approve') { // Start Approve Page

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
