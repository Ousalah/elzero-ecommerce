<?php
  session_start();
  $pageTitle = 'Show Items';

  include "init.php";

  // Check if Get Request itemid is Numeric & Get The Interger Value of it
  $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET["itemid"]) : 0;

  $args = array(
    "fields"      => array("items.*", "categories.Name AS CatName", "users.Username"),
    "table"       => "items",
    "joins"       => array(
                      array("table" => "categories", "primary" => "ID", "foreign" => "CatID"),
                      array("table" => "users", "primary" => "UserID", "foreign" => "MemberID")
                    ),
    "conditions"  => array('ItemID' => $itemid, 'Approve' => 1),
  );
  $item = getFrom($args,"fetch");

  if (!empty($item)) :
?>
    <h1 class="text-center"><?php echo $item["Name"] ?></h1>
    <div class="container">
      <!-- Start item details -->
      <div class="row">
        <div class="col-md-3 item-image">
          <img class="img-responsive img-thumbnail center-block" src="<?php echo (!empty($item["Image"])) ? "admin/uploads/items/" . $item["Image"] : "admin/uploads/items/default-item.png"; ?>">
        </div>
        <div class="col-md-9 item-info">
          <h2><?php echo $item["Name"] ?></h2>
          <p class="lead"><?php echo $item["Description"] ?></p>
          <ul class="list-unstyled">
            <li>
              <i class="fa fa-calendar fa-fw"></i>
              <span>Added Date</span> : <?php echo $item["Add_Date"] ?>
            </li>
            <li>
              <i class="fa fa-money fa-fw"></i>
              <span>Price</span> : $ <?php echo $item["Price"] ?>
            </li>
            <li>
              <i class="fa fa-flag fa-fw"></i>
              <span>Made in</span> : <?php echo $item["Country_Made"] ?>
            </li>
            <li>
              <i class="fa fa-tag fa-fw"></i>
              <span>Category</span> : <a href="<?php echo 'categories.php?pageid=' . $category['ID']; ?>"><?php echo $item["CatName"] ?></a>
            </li>
            <li>
              <i class="fa fa-tags fa-fw"></i>
              <span>Tags</span> :
              <?php
                $tags = explode(",", $item["Tags"]);
                foreach ($tags as $tag) {
                  $tag = str_replace(" ", "", strtolower($tag));
                  echo '<a href="tags.php?tagname=' . $tag . '" class="label label-success">' . $tag . '</a>';
                }
              ?>
            </li>
            <li>
              <i class="fa fa-user fa-fw"></i>
              <span>Added by</span> : <a href="#"><?php echo $item["Username"] ?></a>
            </li>
          </ul>
        </div>
      </div>
      <!-- End item details -->
      <hr class="custom-hr">
      <!-- Start add comment form -->
      <?php if (isset($_SESSION['user'])): ?>
        <div class="row">
          <div class="col-md-offset-3">
            <div class="add-comment">
              <h3>Add Your Comment</h3>
              <form action="<?php echo $_SERVER["PHP_SELF"] . "?itemid=" . $itemid ?>" method="post">
                <textarea class="form-control" name="comment" required cols="30" rows="10"></textarea>
                <input type="submit" class="btn btn-primary" value="Add Comment">
              </form>
              <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $formErrors = array();
                  $comment   = filter_var(trim($_POST["comment"]), FILTER_SANITIZE_STRING);
                  if (empty($comment)) { $formErrors[] = "Comment can't be empty."; }

                  if (empty($formErrors)) :
                    // Insert comments in database
                    $stmt = $con->prepare("INSERT INTO comments(Comment, Status, Comment_Date, ItemID, UserID)
                                            VALUES(:comment, 0, now(), :itemid, :userid)");
                    $stmt->execute(array(
                      'comment'  => $comment,
                      'itemid'   => $itemid,
                      'userid'   => $_SESSION["userid"]
                    ));

                    // success message
                    if ($stmt) { $successMsg = "Comment added successfully."; }
                  endif;
                }

                // Start looping through errors
                if (!empty($formErrors)) {
                  foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                  }
                }

                if (isset($successMsg)) { echo '<div class="alert alert-success">' . $successMsg . '</div>'; }
                // End looping through errors
              ?>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="lead"><a href="login.php">Login or Register</a> to add comment.</div>
      <?php endif; ?>
      <!-- End add comment form -->
      <hr class="custom-hr">
      <!-- Start comments list -->
      <?php
        $args = array(
          "fields"      => array("comments.*", "users.Username"),
          "table"       => "comments",
          "joins"       => array("table" => "users", "primary" => "UserID", "foreign" => "UserID"),
          "conditions"  => array('ItemID' => $itemid, 'Status' => 1),
          "orderBy"     => "comments.CommentID",
        );
        $rows = getFrom($args);

        if (!empty($rows)):
          foreach ($rows as $row):
      ?>
            <div class="comment-box">
              <div class="row">
                <div class="col-sm-2 text-center">
                  <img class="img-responsive img-thumbnail img-circle center-block" src="<?php echo (!empty($row["avatar"])) ? "admin/uploads/avatars/" . $row["avatar"] : "admin/uploads/avatars/default-avatar.png"; ?>" alt="<?php echo $row["Username"]; ?>">
                  <strong><?php echo $row["Username"] ?></strong>
                </div>
                <div class="col-sm-10">
                  <p class="lead"><?php echo $row["Comment"] ?></p>
                </div>
              </div>
            </div>
      <?php
          endforeach;
        else:
      ?>
          <div>No Comments to Show.</div>
      <?php endif; ?>
      <!-- End comments list -->
    </div>
<?php
  else:
    echo "<div class='container'>
            <div class='alert alert-danger'>There's no item with this <strong>ID</strong> or this item waiting for <strong>approval</strong>.</div>
          </div>";
  endif;
?>

<?php include $tpl . "footer.php"; ?>
