<?php
  /*
  ===================================================
  == Manage Items Page
  == You Can Add | Edit | Delete Items From Here
  ===================================================
  */
  session_start();
  $pageTitle = "Items";

  if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = (isset($_GET['do']) && !empty($_GET['do'])) ? $_GET['do'] : 'manage';
    if ($do == 'manage') { // Start Manage Page

?>

      <h1 class='text-center'>Manage Items</h1>
      <div class="container">
        <a href="?do=add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Item</a>
      </div>

<?php
    } elseif($do == 'add') { // Start Add Page
?>

      <h1 class="text-center">Add New Item</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=insert" method="post">
          <!-- Start Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="name" required="required" placeholder="Item Name">
            </div>
          </div>
          <!-- End Name -->

          <!-- Start Description -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="description" required="required" placeholder="Item Description">
            </div>
          </div>
          <!-- End Description -->

          <!-- Start Price -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="price" required="required" placeholder="Item Price">
            </div>
          </div>
          <!-- End Price -->

          <!-- Start Country -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="country" required="required" placeholder="Item manufacturing country">
            </div>
          </div>
          <!-- End Country -->

          <!-- Start Status -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-8">
              <select name="status">
                <option value="0">...</option>
                <option value="1">New</option>
                <option value="2">Like New</option>
                <option value="3">Used</option>
                <option value="4">Very Old</option>
              </select>
            </div>
          </div>
          <!-- End Status -->

          <!-- Start Member -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-8">
              <select name="member">
                <option value="0">...</option>
                <?php
                  $stmt = $con->prepare("SELECT * FROM users");
                  $stmt->execute();
                  $users = $stmt->fetchAll();

                  foreach ($users as $user) :
                    echo '<option value="' . $user['UserID'] . '">' . $user['Username'] . '</option>';
                  endforeach;
                ?>
              </select>
            </div>
          </div>
          <!-- End Member -->

          <!-- Start Category -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-8">
              <select name="category">
                <option value="0">...</option>
                <?php
                  $stmt = $con->prepare("SELECT * FROM categories");
                  $stmt->execute();
                  $categories = $stmt->fetchAll();

                  foreach ($categories as $category) :
                    echo '<option value="' . $category['ID'] . '">' . $category['Name'] . '</option>';
                  endforeach;
                ?>
              </select>
            </div>
          </div>
          <!-- End Category -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Items">
            </div>
          </div>
          <!-- End Submit -->
        </form>
      </div>

<?php
    } elseif($do == 'insert') { // Start Insert Page

      echo "<h1 class='text-center'>Insert New Item</h1>";
      echo "<div class='container'>";

      // Check if Item Access to These Page by Post Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get Variables from the form
        $item_name          = trim($_POST["name"]);
        $item_description   = trim($_POST["description"]);
        $item_price         = trim($_POST["price"]);
        $item_country       = trim($_POST["country"]);
        $item_status        = $_POST["status"];

        // Validate The form
        $form_errors = array();
        if (empty($item_name)) { $form_errors[] = "<div class='alert alert-danger'>Item Name Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_description)) { $form_errors[] = "<div class='alert alert-danger'>Description Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_price)) { $form_errors[] = "<div class='alert alert-danger'>Price Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_country)) { $form_errors[] = "<div class='alert alert-danger'>Country Can't be <strong>Empty</strong>.</div>"; }
        if ($item_status == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the status.</div>"; }

        // Check If There's No Error, Proceed The Insert Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          // Insert Item Info in Database
          $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Made, Status)
          VALUES(:name, :description, :price, now(), :country, :status)");
          $stmt->execute(array(
            'name'            => $item_name,
            'description'     => $item_description,
            'price'           => $item_price,
            'country'         => $item_country,
            'status'          => $item_status
          ));

          // Echo Success Message
          $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record inserted.</div>";
          redirectHome($msg, "back");
        endif;

      } else {
        $msg = "<div class='alert alert-danger'>Your can not browse to this page <strong>directly</strong>.</div>";
        redirectHome($msg);
      }
      echo "</div>";

    } elseif($do == 'edit') { // Start Edit Page

    } elseif($do == 'update') { // Start Update Page

    } elseif($do == 'delete') { // Start Delete Page

    } elseif($do == 'approve') { // Start Approve Page

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
