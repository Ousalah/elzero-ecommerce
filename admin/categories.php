<?php
  /*
  ===================================================
  == Manage Categories Page
  == You Can Add | Edit | Delete Members From Here
  ===================================================
  */
  session_start();
  $pageTitle = "Categories";

  if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = (isset($_GET['do']) && !empty($_GET['do'])) ? $_GET['do'] : 'manage';
    if ($do == 'manage') { // Start Manage Page

    } elseif($do == 'add') { // Start Add Page
?>

      <h1 class="text-center">Add New Category</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=insert" method="post">
          <!-- Start Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="name" autocomplete="off" required="required" placeholder="Category Name">
            </div>
          </div>
          <!-- End Name -->

          <!-- Start Description -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="description" placeholder="Category Description">
            </div>
          </div>
          <!-- End Description -->

          <!-- Start Ordering -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="ordering" placeholder="Number to arrange the Category">
            </div>
          </div>
          <!-- End Ordering -->

          <!-- Start Visibility -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visibile</label>
            <div class="col-sm-10 col-md-8">
              <div class="radio">
                <label for="visibile-yes">
                  <input id="visibile-yes" type="radio" name="visibility" value="1" checked="checked"> Yes
                </label>
              </div>
              <div class="radio">
                <label for="visibile-no">
                  <input id="visibile-no" type="radio" name="visibility" value="0"> No
                </label>
              </div>
            </div>
          </div>
          <!-- End Visibility -->

          <!-- Start Allow Comment -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Comment</label>
            <div class="col-sm-10 col-md-8">
              <div class="radio">
                <label for="allow-comment-yes">
                  <input id="allow-comment-yes" type="radio" name="allow_comment" value="1" checked="checked"> Yes
                </label>
              </div>
              <div class="radio">
                <label for="allow-comment-no">
                  <input id="allow-comment-no" type="radio" name="allow_comment" value="0"> No
                </label>
              </div>
            </div>
          </div>
          <!-- End Allow Comment -->

          <!-- Start Allow Ads -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-8">
              <div class="radio">
                <label for="allow-ads-yes">
                  <input id="allow-ads-yes" type="radio" name="allow_ads" value="1" checked="checked"> Yes
                </label>
              </div>
              <div class="radio">
                <label for="allow-ads-no">
                  <input id="allow-ads-no" type="radio" name="allow_ads" value="0"> No
                </label>
              </div>
            </div>
          </div>
          <!-- End Allow Ads -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Category">
            </div>
          </div>
          <!-- End Submit -->
        </form>
      </div>

<?php
    } elseif($do == 'insert') { // Start Insert Page

    } elseif($do == 'edit') { // Start Edit Page

    } elseif($do == 'update') { // Start Update Page

    } elseif($do == 'delete') { // Start Delete Page

    } elseif ($do == 'activate') { // Start Activate Page

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }
