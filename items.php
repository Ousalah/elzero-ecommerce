<?php
  session_start();
  $pageTitle = 'Show Items';

  include "init.php";

  // Check if Get Request itemid is Numeric & Get The Interger Value of it
  $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET["itemid"]) : 0;

  $stmt = $con->prepare("SELECT items.*, categories.Name AS CatName, users.Username FROM items
                        INNER JOIN categories ON categories.ID = items.CatID
                        INNER JOIN users ON users.UserID = items.MemberID
                        WHERE ItemID = ?");
  $stmt->execute(array($itemid));
  $count = $stmt->rowCount();

  if ($count > 0) :
    $item = $stmt->fetch();
?>
    <h1 class="text-center"><?php echo $item["Name"] ?></h1>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <img class="img-responsive img-thumbnail center-block" src="https://via.placeholder.com/350x200" alt="">
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
              <i class="fa fa-user fa-fw"></i>
              <span>Added by</span> : <a href="#"><?php echo $item["Username"] ?></a>
            </li>
          </ul>
        </div>
      </div>
      <hr class="custom-hr">
      <div class="row">
        <div class="col-md-3">
          <img class="img-responsive img-thumbnail center-block" src="https://via.placeholder.com/350x200" alt="">
        </div>
        <div class="col-md-9">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>
    </div>
<?php
  else:
    echo "<div class='alert alert-danger'>There's no item with this <strong>ID</strong></div>";
  endif;
?>

<?php include $tpl . "footer.php"; ?>
