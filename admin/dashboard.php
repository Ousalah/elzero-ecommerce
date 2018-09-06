<?php
  session_start();
  if (isset($_SESSION['Username'])) {
    echo "Welcome " . $_SESSION['Username'];
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit()
  }
