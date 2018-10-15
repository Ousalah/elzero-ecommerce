<?php
  ########################################################
  ############    Function For In Frontend    ############
  ########################################################

  /*
  ** Get all fuction v2.2
  ** Function to get records from any table
  ** @param $params["fields"]     = array of fields to be selected - (optional) (default = "*")
  ** @param $params["table"]      = table name to select from it - (required)
  ** @param $params["joins"]      = array of joins, has 4 params, if you will use multi join put each one in array
                                    the table and primary and foreign params are (required)
                                    the type param is (optional) and (default = "INNER") {options = "INNER", "RIGHT", "LEFT", "FULL"}
                                    [ex single: array("table" => "tablename", "primary" => "ID", "foreign" => "ID")]
                                    [ex multi: array(array("table" => "tablename", "primary" => "ID", "foreign" => "ID"))]
                                    - (optional) (default = "")
  ** @param $params["conditions"] = array of conditions, you have tow format of condition to pass it:
                                    if you will only use equal sign (eq: =) pass the condition like that [ex 1: array("key" => "value")]
                                    else if you will use different operators (=, <, >, ...) pass the condition like that
                                    [ex 2: array(array('key' => "", "operator" => "=", "value" => "")]
                                    in this case the key and value params are (required)
                                    and the operator param is (optional) and (default = "=")
                                    you can also use a mixe of 'ex 1' and 'ex 2'
                                    [ex 3: array("key" => "value"), array('key' => "", "operator" => "=", "value" => "")] - (optional) (default = "")
  ** @param $params["orderBy"]    = field to use it in the ordering - (optional) (default = "")
  ** @param $params["orderType"]  = type of ordering - (optional) (default = "DESC") {options = "DESC", "ASC", "RAND()"}
  ** @param $params["limit"]      = number of records to get - (optional) (default = "")
  ** @param $fetch                = type of fetch (optional) (default = "fetchAll") {options = "fetchAll", "fetch"}
  ** @return records
  */
  function getFrom($params = array(
    "fields"      => array(),
    "table"       => '',
    "joins"       => array(array("type" => "INNER", "table" => "", "primary" => "", "foreign" => "")),
    "conditions"  => array(array('key' => "", "operator" => "=", "value" => "")),
    "orderBy"     => "",
    "orderType"   => 'DESC',
    "limit"       => null
  ), $fetch = "fetchAll") {

    // check if isset table name, else return empty array
    if (isset($params["table"]) && !empty($params["table"])) {
      $params['fields']      = (isset($params['fields'])) ? $params['fields']: array('*');
      $params['conditions']  = (isset($params['conditions'])) ? $params['conditions']: array();
      $params['joins']       = (isset($params['joins'])) ? $params['joins']: "";
      $params['orderBy']     = (isset($params['orderBy'])) ? $params['orderBy']: "";
      $params['orderType']   = (isset($params['orderType'])) ? strtoupper($params['orderType']): 'DESC';
      $params['limit']       = (isset($params['limit'])) ? 'LIMIT ' . $params['limit']: null;

      // Start fields part
      $params['fields'] = (!empty($params['fields']) && is_array($params['fields'])) ? implode(", ", $params['fields']) : '*';
      // End fields part

      // Start joins part
      $joins = "";
      if (!empty($params['joins']) && is_array($params['joins'])) :
        $joinsOptions = array("INNER", "RIGHT", "LEFT", "FULL");
        // check if has only one join
        if (isset($params["joins"]["table"]) && !empty($params["joins"]["table"]) && isset($params["joins"]["primary"]) && !empty($params["joins"]["primary"]) && isset($params["joins"]["foreign"]) && !empty($params["joins"]["foreign"])) {
          $params["joins"]["type"] = (isset($params["joins"]["type"]) && in_array(strtoupper($params["joins"]["type"]), $joinsOptions)) ? strtoupper($params["joins"]["type"]) : "INNER";

          $joins .= $params["joins"]["type"] . " JOIN " . $params["joins"]["table"]
                  . " ON " . $params["joins"]["table"] . "." . $params["joins"]["primary"] . " = "
                  . $params["table"] . "." . $params["joins"]["foreign"];
        } else {
          // check if has more than one join
          foreach ($params['joins'] as $key => $value) :
            if (isset($params["joins"][$key]["table"]) && !empty($params["joins"][$key]["table"]) && isset($params["joins"][$key]["primary"]) && !empty($params["joins"][$key]["primary"]) && isset($params["joins"][$key]["foreign"]) && !empty($params["joins"][$key]["foreign"])) {
              $params["joins"][$key]["type"] = (isset($params["joins"][$key]["type"]) && in_array(strtoupper($params["joins"][$key]["type"]), $joinsOptions)) ? strtoupper($params["joins"][$key]["type"]) : "INNER";

              $joins .= $params["joins"][$key]["type"] . " JOIN " . $params["joins"][$key]["table"]
                      . " ON " . $params["joins"][$key]["table"] . "." . $params["joins"][$key]["primary"] . " = "
                      . $params["table"] . "." . $params["joins"][$key]["foreign"] . " ";
            }
          endforeach;
        }
      endif;
      // End joins part

      // Start where part
      $where  = "";
      $keys   = array();
      $values = array();
      if (!empty($params['conditions']) && is_array($params['conditions'])) {
        $where = "WHERE";
        // if single condition [ex 2]
        if (isset($params['conditions']["key"]) && isset($params['conditions']["value"])) {
          $params['conditions']["operator"] = (isset($params['conditions']["operator"]) && !empty($params['conditions']["operator"])) ? $params['conditions']["operator"] : "=";
          $keys[] = "{$params['conditions']["key"]} {$params['conditions']["operator"]} ?";
          $values[] = $params['conditions']["value"];
        } else {
          // if single condition [ex 1] or multi condition [ex 3]
          foreach ($params['conditions'] as $key => $value) {
            if (!empty($value) && is_array($value)) :
              $value["operator"] = (isset($value["operator"]) && !empty($value["operator"])) ? $value["operator"] : "=";
              $keys[] = "{$value["key"]} {$value["operator"]} ?";
              $values[] = $value["value"];
            else :
              $keys[] = "$key = ?";
              $values[] = $value;
            endif;
          }
        }
        $where = $where . " " . implode(" AND ", $keys);
      }
      // End where part

      // Start order by part
      // if orderBy = null
      if ($params['orderBy'] === "") {
        // if orderType = RAND() => "...", else if = DESC or ASC or "" => ""
        $params['orderType'] = ($params['orderType'] === "RAND()") ? "ORDER BY RAND()" : "";
      } else {
        if ($params['orderType'] === "" || $params['orderType'] == "DESC") :
          $params['orderBy']   = "ORDER BY " . $params['orderBy'];
          $params['orderType'] = "DESC";
        elseif ($params['orderType'] == "ASC") :
          $params['orderBy']   = "ORDER BY " . $params['orderBy'];
          $params['orderType'] = "ASC";
        elseif ($params['orderType'] == "RAND()") :
          $params['orderBy']   = "ORDER BY ";
          $params['orderType'] = "RAND()";
        else :
          $params['orderBy']   = "";
          $params['orderType'] = "";
        endif;
      }
      // End order by part

      global $con;
      $stmt = $con->prepare("SELECT {$params['fields']} FROM {$params['table']} {$joins} {$where} {$params['orderBy']} {$params['orderType']} {$params['limit']}");
      $stmt->execute($values);
      if ($fetch === "fetch") { return $stmt->fetch(); }
      elseif ($fetch === "fetchColumn") { return $stmt->fetchColumn(); }
      else { return $stmt->fetchAll(); }

    } else {
      return array();
    }
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
