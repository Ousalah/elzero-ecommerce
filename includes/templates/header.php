<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $css . 'bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?php echo $css . 'font-awesome.min.css' ?>">
    <link rel="stylesheet" href="<?php echo $css . 'jquery-ui.css' ?>">
    <link rel="stylesheet" href="<?php echo $css . 'jquery.selectBoxIt.css' ?>">
    <link rel="stylesheet" href="<?php echo $css . 'frontend.css' ?>">
  </head>
  <body>
    <!-- Start Navbar -->
    <div class="upper-bar">
      <div class="container">
        <?php if (isset($_SESSION['user'])): ?>
          <div class="pull-right btn-group upper-menu-logged-in">
            <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <img class="img-thumbnail img-circle" src="https://via.placeholder.com/200x200" alt="">
              <?php echo $sessionUser ?>
              <?php echo (checkUserStatus($sessionUser)) ? "" : ' <i class="fa fa-exclamation-triangle fa-fw" title="You are not approved yet." aria-hidden="true"></i>'; ?>
              <span class="caret"></span>
            </span>
            <ul class="dropdown-menu">
              <li><a href="profile.php">My Profile</a></li>
              <li><a href="newad.php">New Item</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="login.php"><span class="pull-right">Login/Singup</span></a>
        <?php endif; ?>
      </div>
    </div>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php lang('ADMIN_HOME'); ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="app-nav">
          <ul class="nav navbar-nav navbar-right">
            <?php $args = array("table" => "categories", "conditions" => array("parent" => 0), "orderBy" => "ID", "orderType" => "ASC"); ?>
            <?php foreach (getFrom($args) as $category): ?>
              <li><a href="<?php echo 'categories.php?pageid=' . $category['ID']; ?>"><?php echo $category['Name'] ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <!-- End Navbar -->
