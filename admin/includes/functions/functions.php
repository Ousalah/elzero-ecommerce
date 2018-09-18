<?php
  /*
  ** Title Function v1.0
  ** Title Function That Echo The Page Title In Case The Page
  ** Has The Variable $pageTitle And Echo Default Title For Other Pages
  */
  function getTitle() {
    global $pageTitle;
    if (isset($pageTitle)) { echo $pageTitle; }
    else { echo "Default"; }

  }

  /*
  ** Home Redirect Function v1.0
  ** This Function Accept Parameters
  ** @param $errorMsg = Echo The Error Message
  ** @param $errorType = Type of Errors (alert, danger, success, info)
  ** @param $seconds = Seconds Before Redirecting
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

  /*
  ** Check Items Exist Function v1.0
  ** Function to check Item in Database [ This Function Accept Parameters ]
  ** @param $select = The item to select [ Example: user, item, category ]
  ** @param $from = The table to select from [ Example: users, items, categories ]
  ** @param $value = The value of select [ Example: mohamed, box, electonics ]
  ** @return True if Item exist else return False
  */
  function checkItem($select, $from, $value) {
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));

    return ($statement->rowCount() >= 1) ? true : false;
  }
