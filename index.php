<?php
  session_start();
  $pageTitle = 'Home';

  include "init.php";

?>

<div class="container homepage">
  <div class="row">
    <?php $args = array("table" => "items", "conditions"  => array('Approve' => 1), "orderType" => "RAND()"); ?>
    <?php foreach (getFrom($args) as $item): ?>
      <div class="col-sm-6 col-md-3">
        <div class="thumbnail item-box">
          <span class="item-price"><?php echo $item["Price"] ?></span>
          <img class="img-responsive" src="<?php echo (!empty($item["Image"])) ? "admin/uploads/items/" . $item["Image"] : "admin/uploads/items/default-item.png"; ?>">
          <div class="caption">
            <h3><a href="items.php?itemid=<?php echo $item["ItemID"] ?>"><?php echo $item["Name"] ?></a></h3>
            <p><?php echo $item["Description"] ?></p>
            <div class="item-date"><?php echo $item["Add_Date"] ?></div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include $tpl . "footer.php"; ?>
