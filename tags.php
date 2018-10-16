<?php
  session_start();
  $pageTitle = 'Tags';

  include "init.php";
?>

<div class="container tags">
  <?php if (isset($_GET['tagname']) && !empty($_GET['tagname'])): ?>
    <?php $tagname = str_replace(" ", "", strtolower($_GET['tagname'])); ?>
    <h1 class="text-center">Tags : <?php echo $tagname ?> </h1>
    <div class="row">
      <?php
        $args = array(
          "table"       => "items",
          "conditions"  => array(array('key' => 'Tags', "operator" => "LIKE", "value" => "%" . $tagname . "%"), 'Approve' => 1),
          "orderBy"     => "ItemID",
        );
      ?>
      <?php foreach (getFrom($args) as $item): ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail item-box">
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
    <h1 class="text-center">Tags :</h1>
    <div class="alert alert-info">There's no item to show  (Page not found)</div>
  <?php endif; ?>
</div>

<?php include $tpl . "footer.php"; ?>
