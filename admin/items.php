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

      $conditions = array();
      if (isset($_GET["page"]) && $_GET["page"] == "approve") {
        $conditions = array("Approve" => 0);
      }
      $args = array(
        "fields"      => array("items.*", "categories.Name AS Category", "users.Username"),
        "table"       => "items",
        "joins"       => array(
                          array("table" => "categories", "primary" => "ID", "foreign" => "CatID"),
                          array("table" => "users", "primary" => "UserID", "foreign" => "MemberID")
                        ),
        "conditions"  => $conditions,
        "orderBy"     => "items.ItemID"
      );
      $items = getFrom($args);
      $count = count($items);
?>

      <h1 class='text-center'>Manage Items</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <th>#ID</th>
              <th>Image</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Adding Date</th>
              <th>Category</th>
              <th>Tags</th>
              <th>Added By</th>
              <th>Control</th>
            </tr>
            <?php if ($count > 0): ?>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td><?php echo $item["ItemID"]; ?></td>
                  <td>
                    <img class="img-responsive center-block" src="<?php echo (!empty($item["Image"])) ? "uploads/items/" . $item["Image"] : "uploads/items/default-item.png"; ?>">
                  </td>
                  <td><?php echo $item["Name"]; ?></td>
                  <td><?php echo $item["Description"]; ?></td>
                  <td><?php echo $item["Price"]; ?></td>
                  <td><?php echo $item["Add_Date"]; ?></td>
                  <td><?php echo $item["Category"]; ?></td>
                  <td><?php echo $item["Tags"]; ?></td>
                  <td><?php echo $item["Username"]; ?></td>
                  <td>
                    <a href="?do=edit&itemid=<?php echo $item["ItemID"]; ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    <a href="?do=delete&itemid=<?php echo $item["ItemID"]; ?>" class="btn btn-danger btn-xs confirm"><i class="fa fa-remove"></i> Remove</a>
                    <?php if ($item["Approve"] == 0): ?>
                      <a href="?do=approve&itemid=<?php echo $item["ItemID"]; ?>" class="btn btn-info btn-xs"><i class="fa fa-check"></i> Approve</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan='8'>No Data to Show.</td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
        <a href="?do=add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Item</a>
      </div>

<?php
    } elseif($do == 'add') { // Start Add Page
?>

      <h1 class="text-center">Add New Item</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=insert" method="post" enctype="multipart/form-data">
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
                  $args = array("table" => "users", "orderBy" => "Username", "orderType" => "ASC");
                  $users = getFrom($args);

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
                  $args = array("table" => "categories", "conditions" => array("parent" => 0), "orderBy" => "Name", "orderType" => "ASC");
                  $categories = getFrom($args);

                  foreach ($categories as $category) :
                    echo '<option value="' . $category['ID'] . '">' . $category['Name'] . '</option>';
                    $childCatArgs = array("table" => "categories", "conditions" => array("parent" => $category['ID']), "orderBy" => "Name", "orderType" => "ASC");
                    foreach (getFrom($childCatArgs) as $childCat) {
                      echo '<option value="' . $childCat['ID'] . '">&nbsp&nbsp;&nbsp;' . $childCat['Name'] . '</option>';
                    }
                  endforeach;
                ?>
              </select>
            </div>
          </div>
          <!-- End Category -->

          <!-- Start Tags -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="tags" placeholder="Separate tags with comma (,)">
            </div>
          </div>
          <!-- End Tags -->

          <!-- Start Image -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Image</label>
            <div class="col-sm-10 col-md-8">
              <input type="file" class="form-control" name="image" required="required">
            </div>
          </div>
          <!-- End Image -->

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

        // Upload varialbles
        $imageName = $_FILES["image"]["name"];
        $imageType = $_FILES["image"]["type"];
        $imageTmp  = $_FILES["image"]["tmp_name"];
        $imageSize = $_FILES["image"]["size"];
        // Allower extensions
        $allowedExtensions = array("jpeg", "jpg", "png", "gif");
        // Get image extension
        $imageExtension = explode('.', $imageName);
        $imageExtension = strtolower(end($imageExtension));

        // Get Variables from the form
        $item_name          = trim($_POST["name"]);
        $item_description   = trim($_POST["description"]);
        $item_price         = trim($_POST["price"]);
        $item_country       = trim($_POST["country"]);
        $item_status        = $_POST["status"];
        $item_category      = $_POST["category"];
        $item_member        = $_POST["member"];
        $item_tags          = trim($_POST["tags"]);

        // Validate The form
        $form_errors = array();
        if (empty($item_name)) { $form_errors[] = "<div class='alert alert-danger'>Item Name Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_description)) { $form_errors[] = "<div class='alert alert-danger'>Description Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_price)) { $form_errors[] = "<div class='alert alert-danger'>Price Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_country)) { $form_errors[] = "<div class='alert alert-danger'>Country Can't be <strong>Empty</strong>.</div>"; }
        if ($item_status == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the status.</div>"; }
        if ($item_category == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the category.</div>"; }
        if ($item_member == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the member.</div>"; }
        if (empty($imageName)) { $form_errors[] = "<div class='alert alert-danger'>Image is <strong>required</strong>.</div>"; }
        else if (!empty($imageName) && !in_array($imageExtension, $allowedExtensions)) { $form_errors[] = "<div class='alert alert-danger'>This extension is not <strong>Allowed</strong>.</div>"; }
        else if ($imageSize > 4194304) { $form_errors[] = "<div class='alert alert-danger'>Image can't be more than <strong>4MB</strong>.</div>"; }


        // Check If There's No Error, Proceed The Insert Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          $item_image = md5(date('ymdHsiu') . $imageName . rand(0, 1000000));
          // check if another user has the same items name, if yes regenerate different name
          while (checkItem("image", "items", $item_image)) {
            $item_image = md5(date('ymdHsiu') . $imageName . rand(0, 1000000));
          }
          move_uploaded_file($imageTmp, __DIR__ . "\\uploads\\items\\" . $item_image . "." . $imageExtension);
          // add extension to items
          $item_image = $item_image . "." . $imageExtension;

          // Insert Item Info in Database
          $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Made, Image, Status, CatID, MemberID, Tags)
          VALUES(:name, :description, :price, now(), :country, :image, :status, :category, :member, :tags)");
          $stmt->execute(array(
            'name'            => $item_name,
            'description'     => $item_description,
            'price'           => $item_price,
            'country'         => $item_country,
            'image'           => $item_image,
            'status'          => $item_status,
            'category'        => $item_category,
            'member'          => $item_member,
            'tags'            => $item_tags
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

      // Check if Get Request itemid is Numeric & Get The Interger Value of it
      $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET["itemid"]) : 0;

      $args = array("table" => "items", "conditions" => array("ItemID" => $itemid));
      $item = getFrom($args, "fetch");

      // Start Check if Item Exist
      echo '<h1 class="text-center">Edit Item</h1>';
      echo '<div class="container">';
      if (!empty($item)) :
?>
        <form class="form-horizontal" action="?do=update" method="post" enctype="multipart/form-data">
          <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
          <!-- Start Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="name" value="<?php echo $item["Name"] ?>" required="required" placeholder="Item Name">
            </div>
          </div>
          <!-- End Name -->

          <!-- Start Description -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="description" value="<?php echo $item["Description"] ?>" required="required" placeholder="Item Description">
            </div>
          </div>
          <!-- End Description -->

          <!-- Start Price -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="price" value="<?php echo $item["Price"] ?>" required="required" placeholder="Item Price">
            </div>
          </div>
          <!-- End Price -->

          <!-- Start Country -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="country" value="<?php echo $item["Country_Made"] ?>" required="required" placeholder="Item manufacturing country">
            </div>
          </div>
          <!-- End Country -->

          <!-- Start Status -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-8">
              <select name="status">
                <option value="1" <?php if ($item["Status"] == 1) echo "selected='selected'"; ?>>New</option>
                <option value="2" <?php if ($item["Status"] == 2) echo "selected='selected'"; ?>>Like New</option>
                <option value="3" <?php if ($item["Status"] == 3) echo "selected='selected'"; ?>>Used</option>
                <option value="4" <?php if ($item["Status"] == 4) echo "selected='selected'"; ?>>Very Old</option>
              </select>
            </div>
          </div>
          <!-- End Status -->

          <!-- Start Member -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-8">
              <select name="member">
                <?php
                  $args = array("table" => "users", "orderBy" => "Username", "orderType" => "ASC");
                  $users = getFrom($args);

                  foreach ($users as $user) :
                    $selectedUser = ($item["MemberID"] == $user["UserID"]) ? "selected='selected'" : "";
                    echo '<option value="' . $user['UserID'] . '"' . $selectedUser . '>' . $user['Username'] . '</option>';
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
                <?php
                  $args = array("table" => "categories", "orderBy" => "Name", "orderType" => "ASC");
                  $categories = getFrom($args);

                  foreach ($categories as $category) :
                    $selectedCategory = ($item["CatID"] == $category["ID"]) ? "selected='selected'" : "";
                    echo '<option value="' . $category['ID'] . '"' . $selectedCategory . '>' . $category['Name'] . '</option>';
                  endforeach;
                ?>
              </select>
            </div>
          </div>
          <!-- End Category -->

          <!-- Start Tags -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="tags" value="<?php echo $item["Tags"] ?>" placeholder="Separate tags with comma (,)">
            </div>
          </div>
          <!-- End Tags -->

          <!-- Start Image -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Image</label>
            <div class="col-sm-10 col-md-8">
              <input type="hidden" class="form-control" name="oldimage" value="<?php echo $item["Image"] ?>">
              <input type="file" class="form-control" name="image">
            </div>
          </div>
          <!-- End Image -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save Item">
            </div>
          </div>
          <!-- End Submit -->
        </form>

        <!-- Start Item Comments -->
<?php
        $args = array(
          "fields"      => array("comments.*", "users.Username"),
          "table"       => "comments",
          "joins"       => array("table" => "users", "primary" => "UserID", "foreign" => "UserID"),
          "conditions"  => array('comments.ItemID' => $itemid),
          "orderBy"     => "CommentID"
        );
        $rows = getFrom($args);
        $count = count($rows);
?>
        <h1 class='text-center'>Manage [ <?php echo $item["Name"] ?> ] Comments</h1>
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <th>Comments</th>
              <th>Username</th>
              <th>Added Date</th>
              <th>Control</th>
            </tr>
            <?php if ($count > 0): ?>
              <?php foreach ($rows as $row): ?>
                <tr>
                  <td><?php echo $row["Comment"]; ?></td>
                  <td><?php echo $row["Username"]; ?></td>
                  <td><?php echo $row["Comment_Date"]; ?></td>
                  <td>
                    <a href="comments.php?do=edit&commentid=<?php echo $row["CommentID"]; ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    <a href="comments.php?do=delete&commentid=<?php echo $row["CommentID"]; ?>" class="btn btn-danger btn-xs confirm"><i class="fa fa-remove"></i> Remove</a>
                    <?php if ($row["Status"] == 0): ?>
                      <a href="comments.php?do=approve&commentid=<?php echo $row["CommentID"]; ?>" class="btn btn-info btn-xs"><i class="fa fa-check"></i> Approve</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan='6'>No Data to Show.</td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
        <!-- End Item Comments -->
<?php
      else:
        $msg = "<div class='alert alert-danger'>There's no item with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";
      // End Check if Item Exist

    } elseif($do == 'update') { // Start Update Page

      echo "<h1 class='text-center'>Update Item</h1>";
      echo "<div class='container'>";

      // Check if Item Access to These Page by Post Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Upload varialbles
        $oldImage   = $_POST["oldimage"];
        $imageName = $_FILES["image"]["name"];
        $imageType = $_FILES["image"]["type"];
        $imageTmp  = $_FILES["image"]["tmp_name"];
        $imageSize = $_FILES["image"]["size"];
        // Allower extensions
        $allowedExtensions = array("jpeg", "jpg", "png", "gif");
        // Get image extension
        $imageExtension = explode('.', $imageName);
        $imageExtension = strtolower(end($imageExtension));

        // Get Variables from the form
        $item_id            = trim($_POST["itemid"]);
        $item_name          = trim($_POST["name"]);
        $item_description   = trim($_POST["description"]);
        $item_price         = trim($_POST["price"]);
        $item_country       = trim($_POST["country"]);
        $item_status        = $_POST["status"];
        $item_category      = $_POST["category"];
        $item_member        = $_POST["member"];
        $item_tags          = trim($_POST["tags"]);

        // Validate The form
        $form_errors = array();
        if (empty($item_name)) { $form_errors[] = "<div class='alert alert-danger'>Item Name Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_description)) { $form_errors[] = "<div class='alert alert-danger'>Description Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_price)) { $form_errors[] = "<div class='alert alert-danger'>Price Can't be <strong>Empty</strong>.</div>"; }
        if (empty($item_country)) { $form_errors[] = "<div class='alert alert-danger'>Country Can't be <strong>Empty</strong>.</div>"; }
        if ($item_status == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the status.</div>"; }
        if ($item_category == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the category.</div>"; }
        if ($item_member == 0) { $form_errors[] = "<div class='alert alert-danger'>You must <strong>choose</strong> the member.</div>"; }
        // Check If Item Exist in Database
        if(!checkItem("itemid", "items", $item_id)) { $form_errors[] = "<div class='alert alert-danger'>There's no item with this <strong>ID</strong>.</div>"; }
        // if the new and the old image are empty
        if (empty($imageName) && empty($oldImage)) { $form_errors[] = "<div class='alert alert-danger'>Image is <strong>required</strong>.</div>"; }
        // if user try to change manually the old image
        else if (empty($imageName) && !empty($oldImage) && !checkItem("Image", "items", $oldImage)) { $form_errors[] = "<div class='alert alert-danger'>Image is <strong>required</strong>.</div>"; }
        else if (!empty($imageName) && !in_array($imageExtension, $allowedExtensions)) { $form_errors[] = "<div class='alert alert-danger'>This extension is not <strong>Allowed</strong>.</div>"; }
        else if (!empty($imageName) && $imageSize > 4194304) { $form_errors[] = "<div class='alert alert-danger'>Image can't be more than <strong>4MB</strong>.</div>"; }


        // Check If There's No Error, Proceed The Insert Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          // if update item
          if (!empty($imageName)) {
            $item_image = md5(date('ymdHsiu') . $imageName . rand(0, 1000000));
            // check if another user has the same item name, if yes regenerate different name
            while (checkItem("Image", "items", $item_image)) {
              $item_image = md5(date('ymdHsiu') . $imageName . rand(0, 1000000));
            }
            move_uploaded_file($imageTmp, __DIR__ . "\\uploads\\items\\" . $item_image . "." . $imageExtension);
            // add extension to item
            $item_image = $item_image . "." . $imageExtension;
          } else {
            // else keep the old item
            $item_image = $oldImage;
          }

          // Insert Item Info in Database
          $stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Image = ?, Status = ?, CatID = ?, MemberID = ?, Tags = ? WHERE ItemID = ?");
          $stmt->execute(array($item_name, $item_description, $item_price, $item_country, $item_image, $item_status, $item_category, $item_member, $item_tags, $item_id));

          // Echo Success Message
          $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record updated.</div>";
          redirectHome($msg, "back");
        endif;

      } else {
        $msg = "<div class='alert alert-danger'>Your can not browse to this page <strong>directly</strong>.</div>";
        redirectHome($msg);
      }
      echo "</div>";

    } elseif($do == 'delete') { // Start Delete Page

      // Check if Get Request itemid is Numeric & Get The Interger Value of it
      $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET["itemid"]) : 0;

      // Start Check if Item Exist
      echo '<h1 class="text-center">Delete Item</h1>';
      echo '<div class="container">';
      if (checkItem("ItemID", "items", $itemid)) :
        $stmt = $con->prepare("DELETE FROM items WHERE ItemID = :itemid");
        $stmt->bindParam(":itemid", $itemid);
        $stmt->execute();

        // Echo Success Message
        $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record deleted.</div>";
        redirectHome($msg, "back");
      else:
        $msg = "<div class='alert alert-danger'>There's no item with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";
      // End Check if Item Exist

    } elseif($do == 'approve') { // Start Approve Page

      // Check if Get Request itemid is Numeric & Get The Interger Value of it
      $itemid = (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) ? intval($_GET["itemid"]) : 0;

      echo '<h1 class="text-center">Approve Item</h1>';
      echo '<div class="container">';
      if (checkItem("ItemID", "items", $itemid)) :
        $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE ItemID = ?");
        $stmt->execute(array($itemid));

        // Echo Success Message
        $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record approved.</div>";
        redirectHome($msg, "back");
      else:
        $msg = "<div class='alert alert-danger'>There's no item with this <strong>ID</strong></div>";
        redirectHome($msg);
      endif;
      echo "</div>";

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
