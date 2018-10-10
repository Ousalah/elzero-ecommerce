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
        <div class="col-md-9">
          <h2><?php echo $item["Name"] ?></h2>
          <p class="lead"><?php echo $item["Description"] ?></p>
          <span><?php echo $item["Add_Date"] ?></span>
          <div>Price $ <?php echo $item["Price"] ?></div>
          <div>Made in <?php echo $item["Country_Made"] ?></div>
          <div>Category: <?php echo $item["CatName"] ?></div>
          <div>Added by: <?php echo $item["Username"] ?></div>
        </div>
      </div>
    </div>
<?php
  else:
    echo "<div class='alert alert-danger'>There's no item with this <strong>ID</strong></div>";
  endif;
?>

<?php include $tpl . "footer.php"; ?>
