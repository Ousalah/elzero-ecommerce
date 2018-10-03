<?php

  include 'admin/connect.php';

  // Routes
  $lang = "includes/languages/"; // Languages Directory
  $tpl  = "includes/templates/"; // Template Directory
  $func = "includes/functions/"; // Functions Directory
  $css  = "layout/css/"; // css Directory
  $js   = "layout/js/"; // js Directory

  // Incluse The Important Files
  include $func . "functions.php";
  include $lang . "english.php";
  include $tpl . "header.php";
