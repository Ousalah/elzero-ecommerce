<?php

  include 'connect.php';

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

  // Include Navbar On All Pages Except The One With $noNavbar Variable
  if (!isset($noNavbar)) { include $tpl . "navbar.php"; }
