<?php
  /*
  ** Title Function That Echo The Page Title In Case The Page
  ** Has The Variable $pageTitle And Echo Default Title For Other Pages
  */
  function getTitle() {
    global $pageTitle;
    if (isset($pageTitle)) { echo $pageTitle; }
    else { echo "Default"; }

  }

  /*
  ** Home Redirect Function [ This Function Accept Parameters ]
  ** $errorMsg = Echo The Error Message
  ** $errorType = Type of Errors (alert, danger, success, info)
  ** $seconds = Seconds Before Redirecting
  */
  function redirectHome($errorMsg = "", $errorType = "danger", $seconds = 3) {
    if ($errorMsg != "") {
      // Redirect To HomePage AFter Showing $errorMsg
      echo "<div class='alert alert-$errorType'>" . $errorMsg . "</div>";
      echo "<div class='alert alert-info'>You will be redirected to homepage after " . $seconds . " </div>";

      header("refresh:$seconds;url=index.php");
      exit();
    } else {
      // Redirect To HomePage Without Showing Anything
      header("Location: index.php");
      exit();
    }

  }
