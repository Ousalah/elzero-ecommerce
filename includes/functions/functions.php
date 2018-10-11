<?php
  ########################################################
  ############    Function For In Frontend    ############
  ########################################################

  /*
  ** Get categories fuction v1.0
  ** Function to get categories from datebase
  ** @return categories
  */
  function getCat() {
    global $con;
    $stmt = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /*
  ** Get items fuction v1.1
  ** Function to get items from datebase
  ** @return items
  */
  function getItems($where, $value, $approve = null) {
    global $con;
    $sql = ($approve == null) ? "AND Approve = 1" : null;
    $stmt = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY ItemID DESC");
    $stmt->execute(array($value));
    return $stmt->fetchAll();
  }

  /*
  ** check user status fuction v1.0
  ** Function to check if user activated or not (RegStatus)
  ** @return True if RegStatus of user = 1 (user activated) else return False (user not activated)
  */
  function checkUserStatus($user) {
    global $con;
    $stmt = $con->prepare("SELECT Username, RegStatus FROM users WHERE username = ? AND RegStatus = 1");
    $stmt->execute(array($user));
    return ($stmt->rowCount() >= 1) ? true : false;
  }



  ########################################################
  ############    Function Used In Backend    ############
  ########################################################

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
  ** Count number of items function v2.0
  ** Function to count number of items rows
  ** @param $item = The item to count
  ** @param $table = The table to choose from
  ** @param $conditions = array of conditions as array [ Example: array(key => value,)]
  ** @return item count
  **
  ** used in: [ dashboard.php => "Total Members", "Pending Memebers"]
  */
  function countItems($item, $table, $conditions = array()) {
    global $con;
    $where  = "";
    $keys   = array();
    $values = array();
    if (!empty($conditions) && is_array($conditions)) {
      $where = " WHERE ";
      foreach ($conditions as $key => $value) {
        $keys[] = "$key = ?";
        $values[] = $value;
      }
    }

    $keysDB = implode(" AND ", $keys);
    $stmt = $con->prepare("SELECT COUNT($item) FROM $table $where $keysDB");
    $stmt->execute($values);
    return $stmt->fetchColumn();
  }

  /*
  ** Get latest records fuction v1.0
  ** Function to get latest items from datebase [ Users, Items, Commnents ]
  ** $select = Field to select
  ** $table = The table to choose from
  ** $order = The field to order by it
  ** $limit = Number of records to get
  */
  function getLatest($select, $table, $order, $limit = 5) {
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    return $stmt->fetchAll();
  }
