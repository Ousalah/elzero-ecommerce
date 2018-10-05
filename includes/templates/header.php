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
      <div class="container">Upper Bar</div>
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
          <a class="navbar-brand" href="dashboard.php"><?php lang('ADMIN_HOME'); ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="app-nav">
          <ul class="nav navbar-nav navbar-right">
            <?php foreach (getCat() as $category): ?>
              <li><a href="<?php echo 'categories.php?pageid=' . $category['ID'] . '&pagename=' . str_replace(" ", "-", strtolower($category['Name'])); ?>"><?php echo $category['Name'] ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <!-- End Navbar -->
