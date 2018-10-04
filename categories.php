<?php include "init.php"; ?>

<div class="container">
  <h1 class="text-center"><?php echo ucwords(str_replace("-", " ", $_GET['pagename'])); ?></h1>
  <?php
    $pageid = (isset($_GET['pageid']) && !empty($_GET['pageid'])) ? $_GET['pageid'] : 0;
    if (checkItem("ID", "categories", $pageid)) {
      foreach (getItems($_GET['pageid']) as $item):
        echo $item["Name"];
      endforeach;
    } else {
      echo "no item to show";
    }
  ?>
</div>

<?php include $tpl . "footer.php"; ?>
