<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    $pageTitle = 'Blank';
    include 'init.php';

    // Page Content Here

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
