<?php

  include 'connect.php';

  // Routes
  $tpl  = "includes/templates/"; // Template Directory
  $css  = "layout/css/"; // css Directory
  $js   = "layout/js/"; // js Directory
  $lang = "includes/languages/"; // Languages Directory

  // Incluse The Important Files
  include $lang . "english.php";
  include $tpl . "header.php";

  // Include Navbar On All Pages Except The One With $noNavbar Variable
  if (!isset($noNavbar)) { include $tpl . "navbar.php"; }
