<?php
  session_start();
  $pageTitle = 'Create New Ad';

  include "init.php";

  if (isset($_SESSION['user'])) {

?>
    <h1 class="text-center">Create New Ad</h1>
    <div class="create-ad block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Create New Ad</div>
          <div class="panel-body">
            <div class="row">
              <!-- Start creation form ad -->
              <div class="col-md-8">
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                  <!-- Start Name -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-9">
                      <input type="text" class="form-control live-name" name="name" required="required" placeholder="Item Name">
                    </div>
                  </div>
                  <!-- End Name -->

                  <!-- Start Description -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-9">
                      <input type="text" class="form-control live-description" name="description" required="required" placeholder="Item Description">
                    </div>
                  </div>
                  <!-- End Description -->

                  <!-- Start Price -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-9">
                      <input type="text" class="form-control live-price" name="price" required="required" placeholder="Item Price">
                    </div>
                  </div>
                  <!-- End Price -->

                  <!-- Start Country -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10 col-md-9">
                      <input type="text" class="form-control" name="country" required="required" placeholder="Item manufacturing country">
                    </div>
                  </div>
                  <!-- End Country -->

                  <!-- Start Status -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-9">
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
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-9">
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
              <!-- End creation form ad -->
              <!-- Start preview creation ad -->
              <div class="col-md-4">
                <div class="thumbnail item-box live-preview">
                  <span class="item-price">0$</span>
                  <img class="img-responsive" src="https://via.placeholder.com/350x200" alt="">
                  <div class="caption">
                    <h3>Item Title</h3>
                    <p>Description</p>
                  </div>
                </div>
              </div>
              <!-- End preview creation ad -->
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
