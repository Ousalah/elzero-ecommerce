<?php
  session_start();
  $pageTitle = 'Show Items';

  include "init.php";

  // Check if Get Request itemid is Numeric & Get The Interger Value of it
  $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET["itemid"]) : 0;

  $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
  $stmt->execute(array($itemid));
  $item = $stmt->fetch();
  $count = $stmt->rowCount();

  if ($count > 0) :
    echo '<h1 class="text-center">' . $item["Name"] . '</h1>';
  else:
    echo "<div class='alert alert-danger'>There's no item with this <strong>ID</strong></div>";
  endif;
?>

<?php include $tpl . "footer.php"; ?>
