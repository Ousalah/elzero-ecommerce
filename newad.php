<?php
  session_start();
  $pageTitle = 'Create New Item';

  include "init.php";

  if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') :

      $formErrors = array();

      $name          = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
      $description   = filter_var(trim($_POST["description"]), FILTER_SANITIZE_STRING);
      $price         = filter_var(trim($_POST["price"]), FILTER_SANITIZE_NUMBER_FLOAT);
      $country       = filter_var(trim($_POST["country"]), FILTER_SANITIZE_STRING);
      $status        = filter_var($_POST["status"], FILTER_SANITIZE_NUMBER_INT);
      $category      = filter_var($_POST["category"], FILTER_SANITIZE_NUMBER_INT);

      if (strlen($name) < 4) { $formErrors[] = "Item name can't be less than 4 characters."; }
      if (strlen($description) < 10) { $formErrors[] = "Item description can't be less than 10 characters."; }
      if (strlen($country) < 2) { $formErrors[] = "Country can't be less than 2 characters."; }
      if (empty($price)) { $formErrors[] = "Price can't be empty."; }
      if (empty($status)) { $formErrors[] = "Status can't be empty."; }
      if (empty($category)) { $formErrors[] = "Category can't be empty."; }

      // Check if there's no error, proceed the item add
      if (empty($formErrors)) :
        // Insert Item Info in Database
        $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Made, Status, CatID, MemberID)
                                VALUES(:name, :description, :price, now(), :country, :status, :category, :member)");
        $stmt->execute(array(
          'name'            => $name,
          'description'     => $description,
          'price'           => $price,
          'country'         => $country,
          'status'          => $status,
          'category'        => $category,
          'member'          => $_SESSION['userid']
        ));

        // Echo success message
        if ($stmt) { $successMsg = "Item added successfully."; }
      endif;

    endif;
?>
    <h1 class="text-center"><?php echo $pageTitle ?></h1>
    <div class="create-item block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading"><?php echo $pageTitle ?></div>
          <div class="panel-body">
            <div class="row">
              <!-- Start creation form item -->
              <div class="col-md-8">
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                  <!-- Start Name -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control live" data-class=".live-title" name="name" required pattern=".{4,}" title="Item name can't be less than 4 characters." placeholder="Item Name">
                    </div>
                  </div>
                  <!-- End Name -->

                  <!-- Start Description -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control live" data-class=".live-description" name="description" required pattern=".{10,}" title="Item description can't be less than 10 characters." placeholder="Item Description">
                    </div>
                  </div>
                  <!-- End Description -->

                  <!-- Start Price -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Price</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control live" data-class=".live-price" name="price" required placeholder="Item Price">
                    </div>
                  </div>
                  <!-- End Price -->

                  <!-- Start Country -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Country</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="country" required placeholder="Item manufacturing country">
                    </div>
                  </div>
                  <!-- End Country -->

                  <!-- Start Status -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-8">
                      <select name="status" required>
                        <option value="">...</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Very Old</option>
                      </select>
                    </div>
                  </div>
                  <!-- End Status -->

                  <!-- Start Category -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-8">
                      <select name="category" required>
                        <option value="">...</option>
                        <?php
                          foreach (getAllFrom("categories", "Name", "ASC") as $category) :
                            echo '<option value="' . $category['ID'] . '">' . $category['Name'] . '</option>';
                          endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- End Category -->

                  <!-- Start Submit -->
                  <div class="form-group form-group-lg">
                    <div class="col-sm-offset-3 col-sm-8">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Items">
                    </div>
                  </div>
                  <!-- End Submit -->
                </form>
              </div>
              <!-- End creation form item -->
              <!-- Start preview creation item -->
              <div class="col-md-4">
                <div class="thumbnail item-box live-preview">
                  <span class="item-price">
                    <span class="live-price">0</span>$
                  </span>
                  <img class="img-responsive" src="https://via.placeholder.com/350x200" alt="">
                  <div class="caption">
                    <h3 class="live-title">Item Title</h3>
                    <p class="live-description">Description</p>
                  </div>
                </div>
              </div>
              <!-- End preview creation item -->
            </div>
            <!-- Start looping through errors -->
            <?php
            if (!empty($formErrors)) {
              foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
              }
            }

            if (isset($successMsg)) { echo '<div class="alert alert-success">' . $successMsg . '</div>'; }
            ?>
            <!-- End looping through errors -->
          </div>
        </div>
      </div>
    </div>
<?php
  } else {
    header("Location: login.php");
    exit();
  }
?>
<?php include $tpl . "footer.php"; ?>
