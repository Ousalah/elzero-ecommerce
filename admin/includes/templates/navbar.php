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
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php lang('ADMIN_CATEGORIES') ?></a></li>
        <li><a href="items.php"><?php lang('ADMIN_ITEMS') ?></a></li>
        <li><a href="members.php"><?php lang('ADMIN_MEMBERS') ?></a></li>
        <li><a href="comments.php"><?php lang('ADMIN_COMMENTS') ?></a></li>
        <li><a href="#"><?php lang('ADMIN_STATISTICS') ?></a></li>
        <li><a href="#"><?php lang('ADMIN_LOGS') ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <?php if (isset($_SESSION['Username'])) { echo $_SESSION['Username']; } ?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['ID']; ?>"><?php lang('ADMIN_EDIT_PROFILE') ?></a></li>
            <li><a href="#"><?php lang('ADMIN_SETTINGS') ?></a></li>
            <li><a href="logout.php"><?php lang('ADMIN_LOGOUT') ?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
