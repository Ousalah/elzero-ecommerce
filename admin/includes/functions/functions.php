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
  ** Home Redirect Function v2.0
  ** This Function Accept Parameters
  ** @param $msgs = Echo The Message (alert, danger, success, info)
  ** @param $url = The Link You Want To Redirect To [ Accept: null, "back", custom url]
  ** @param $seconds = Seconds Before Redirecting
  */
  function redirectHome($msgs = array(), $url = null, $seconds = 3) {
    if ($url === null) {
      $url = "index.php";
      $link = "Homepage";
    } else if ($url === "back") {

      if(isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])) :
        $url = $_SERVER["HTTP_REFERER"];
        $link = "previous page";
      else :
        $url = "index.php";
        $link = "Homepage";
      endif;

    } else {
      $url = $url;
      $link = $url;
    }

    if (!empty($msgs)) {
      // Redirect To HomePage After Showing $errorMsg
      if (is_array($msgs)) :
        foreach ($msgs as $msg) {
          echo $msg;
        }
      else :
        echo $msgs;
      endif;
      echo "<div class='alert alert-info'>You will be redirected to <strong>" . $link . "</strong> after <strong>" . $seconds . "</strong> seconds</div>";

      header("refresh:{$seconds};url={$url}");
      exit();
    } else {
      // Redirect To HomePage Without Showing Anything
      header("Location: {$url}");
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
  function checkItem($select, $from, $value, $exceptKey = "", $exceptValue = "") {
    global $con;
    $sql = "SELECT $select FROM $from WHERE $select = ?";
    $values[] = $value;
    if (!empty($exceptKey) && !empty($exceptValue)) {
      $sql .= " AND $exceptKey != ?";
      $values[] = $exceptValue;
    }
    $statement = $con->prepare($sql);
    $statement->execute($values);

    return ($statement->rowCount() >= 1) ? true : false;
  }

  /*
  ** Count number of items function v1.0
  ** Function to count number of items rows
  ** @param $item =  The item to count
  ** @param $table =  The table to choose from
  ** @return item count
  */
  function countItems($item, $table) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt->execute();
    return $stmt->fetchColumn();
  }
