<?php
  session_start();
  $pageTitle = 'Profile';

  include "init.php";

  echo "Welcome " . $_SESSION["user"];

?>

<?php include $tpl . "footer.php"; ?>
