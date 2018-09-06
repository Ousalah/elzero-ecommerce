<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    include 'init.php';
    
    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
