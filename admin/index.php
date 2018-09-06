<?php
  include "init.php";
  include $tpl . "header.php";
  include $lang . "english.php";
?>

  <form action="" class="login">
    <h4 class="text-center">Admin Login</h4>
    <input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off">
    <input type="password" class="form-control" name="pass" placeholder="Password" autocomplete="new-password">
    <input type="submit" class="btn btn-primary btn-block" value="Login">
  </form>

<?php include $tpl . "footer.php"; ?>
