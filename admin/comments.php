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
                            INNER JOIN users ON users.UserID = comments.UserID
                            ORDER BY comments.CommentID DESC");
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

      // Check if Get Request commentid is Numeric & Get The Interger Value of it
      $commentid = (isset($_GET["commentid"]) && is_numeric($_GET["commentid"])) ? intval($_GET["commentid"]) : 0;

      $stmt = $con->prepare("SELECT * FROM comments WHERE CommentID = ?");
      $stmt->execute(array($commentid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();

      // Start Check if Comment Exist
      echo '<h1 class="text-center">Edit Comment</h1>';
      echo '<div class="container">';
      if ($count > 0) :
?>
        <form class="form-horizontal" action="?do=update" method="post">
          <input type="hidden" name="commentid" value="<?php echo $commentid; ?>">
          <!-- Start Comment -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Comment</label>
            <div class="col-sm-10 col-md-8">
              <textarea class="form-control" name="comment" rows="8" cols="80" required="required"><?php echo $row["Comment"]; ?></textarea>
            </div>
          </div>
          <!-- End Comment -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save">
            </div>
          </div>
          <!-- End Submit -->
        </form>
<?php
      else:
        $msg = "<div class='alert alert-danger'>There's no comment with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";
      // End Check if Comment Exist

    } elseif($do == 'update') { // Start Update Page

      echo "<h1 class='text-center'>Update Comment</h1>";
      echo "<div class='container'>";

      // Check if Comment Access to These Page by Post Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get Variables from the form
        $comment_id       = $_POST["commentid"];
        $comment_comment  = trim($_POST["comment"]);

        // Validate The form
        $form_errors = array();
        if (empty($comment_comment)) { $form_errors[] = "<div class='alert alert-danger'>Comment Can't be <strong>Empty</strong>.</div>"; }

        // Check If There's No Error, Proceed The Update Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          // Update The Database with This Info
          $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE CommentID = ?");
          $stmt->execute(array($comment_comment, $comment_id));

          // Echo Success Message
          $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record updated.</div>";
          redirectHome($msg, "back");
        endif;

      } else {
        $msg = "<div class='alert alert-danger'>Your can not browse to this page <strong>directly</strong>.</div>";
        redirectHome($msg);
      }
      echo "</div>";

    } elseif($do == 'delete') { // Start Delete Page

      // Check if Get Request commentid is Numeric & Get The Interger Value of it
      $commentid = (isset($_GET["commentid"]) && is_numeric($_GET["commentid"])) ? intval($_GET["commentid"]) : 0;

      // Start Check if Comment Exist
      echo '<h1 class="text-center">Delete Comment</h1>';
      echo '<div class="container">';
      if (checkItem("CommentID", "comments", $commentid)) :
        $stmt = $con->prepare("DELETE FROM comments WHERE CommentID = :commentid");
        $stmt->bindParam(":commentid", $commentid);
        $stmt->execute();

        // Echo Success Message
        $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record deleted.</div>";
        redirectHome($msg, "back");
      else:
        $msg = "<div class='alert alert-danger'>There's no comment with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";
      // End Check if Comment Exist

    } elseif ($do == 'approve') { // Start Approve Page

      // Check if Get Request commentid is Numeric & Get The Interger Value of it
      $commentid = (isset($_GET["commentid"]) && is_numeric($_GET["commentid"])) ? intval($_GET["commentid"]) : 0;

      echo '<h1 class="text-center">Approve Comment</h1>';
      echo '<div class="container">';
      if (checkItem("CommentID", "comments", $commentid)) :
        $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE CommentID = ?");
        $stmt->execute(array($commentid));

        // Echo Success Message
        $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record approved.</div>";
        redirectHome($msg, "back");
      else:
        $msg = "<div class='alert alert-danger'>There's no comment with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
