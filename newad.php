<?php
  session_start();
  $pageTitle = 'Create New Item';

  include "init.php";

  if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') :
      echo "<pre>";
      print_r($_POST);
      echo "</pre>";
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
                      <input type="text" class="form-control live" data-class=".live-title" name="name" required="required" placeholder="Item Name">
                    </div>
                  </div>
                  <!-- End Name -->

                  <!-- Start Description -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control live" data-class=".live-description" name="description" required="required" placeholder="Item Description">
                    </div>
                  </div>
                  <!-- End Description -->

                  <!-- Start Price -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Price</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control live" data-class=".live-price" name="price" required="required" placeholder="Item Price">
                    </div>
                  </div>
                  <!-- End Price -->

                  <!-- Start Country -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Country</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="country" required="required" placeholder="Item manufacturing country">
                    </div>
                  </div>
                  <!-- End Country -->

                  <!-- Start Status -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-8">
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

                  <!-- Start Category -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-8">
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
