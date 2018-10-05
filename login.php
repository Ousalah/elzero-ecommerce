<?php include "init.php"; ?>

<div class="container login-page">
  <h1 class="text-center">
    <span class="selected" data-class="login">Login</span> |
    <span data-class="singup">Singup</span>
  </h1>
  <form action="" class="login">
    <div class="input-container">
      <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
    </div>
    <input type="submit" class="btn btn-primary btn-block" value="Login">
  </form>
  <form action="" class="singup">
    <div class="input-container">
      <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password-confirmation" placeholder="Password Confirmation" required autocomplete="new-password">
    </div>
    <div class="input-container">
      <input type="email" class="form-control" name="email" required placeholder="example@domain.com">
    </div>
    <input type="submit" class="btn btn-success btn-block" value="Singup">
  </form>
</div>

<?php include $tpl . "footer.php"; ?>
