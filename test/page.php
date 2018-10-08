<?php
  // Categories => [ Manage | Edit | Update | Add | Insert | Delete | Stats ]

  $do = (isset($_GET['do'])) ? $_GET['do'] : 'Manage' ;
  echo $do;

  // If The Page is Main Pages
  if ($do == 'Manage') {
    echo "Welcome You Are In Manage Category Page";
    echo '<a href="page.php?do=Add">Add New Category</a>';
  } elseif ($do == 'Add') {
    echo "Welcome You Are In Add Category Page";
  } elseif ($do == 'Insert') {
    echo "Welcome You Are In Insert Category Page";
  } else {
    echo "Error There's no Page with This Name";
  }
