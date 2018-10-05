<?php include "init.php"; ?>

<div class="container categories">
  <h1 class="text-center"><?php echo ucwords(str_replace("-", " ", $_GET['pagename'])); ?></h1>
  <?php $pageid = (isset($_GET['pageid']) && !empty($_GET['pageid'])) ? $_GET['pageid'] : 0; ?>
  <?php if (checkItem("ID", "categories", $pageid)): ?>
    <div class="row">
      <?php foreach (getItems($_GET['pageid']) as $item): ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail item-box">
            <span class="item-price"><?php echo $item["Price"] ?></span>
            <img class="img-responsive" src="https://via.placeholder.com/350x200" alt="">
            <div class="caption">
              <h3><?php echo $item["Name"] ?></h3>
              <p><?php echo $item["Description"] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info">There's no item to show  (Page not found)</div>
  <?php endif; ?>
</div>

<?php include $tpl . "footer.php"; ?>
