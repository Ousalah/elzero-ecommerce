<?php

  // Error reporting
  ini_set('display_errors', 'On');
  error_reporting('E_ALL');

  include 'admin/connect.php';

  // Check if Session user isset
  $sessionUser = (isset($_SESSION['user'])) ? ucwords($_SESSION['user']) : "";


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
