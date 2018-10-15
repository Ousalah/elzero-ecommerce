<?php
  function lang( $phrase ) {
    static $lang = array(
      // Admin Head title
      'ADMIN_DEFAULT_PAGE_TITLE'     => 'Default',
      'ADMIN_LOGIN_PAGE_TITLE'       => 'Login',
      'ADMIN_DASHBOARD_PAGE_TITLE'   => 'Dashboard',

      // Start Admin Navbar Section
      'ADMIN_HOME'         => 'Home',
      //------------------------------
      'ADMIN_CATEGORIES'   => 'Categories',
      'ADMIN_ITEMS'        => 'Items',
      'ADMIN_MEMBERS'      => 'Members',
      'ADMIN_COMMENTS'     => 'Comments',
      'ADMIN_STATISTICS'   => 'Statistics',
      'ADMIN_LOGS'         => 'Logs',
      //------------------------------------
      'ADMIN_VISIT_SHOP'   => 'Visit Shop',
      'ADMIN_EDIT_PROFILE' => 'Edit Profile',
      'ADMIN_SETTINGS'     => 'Settings',
      'ADMIN_LOGOUT'       => 'Logout',

      // Admin Login Page (index.php)
      'ADMIN_LOGIN'                 => 'Admin Login',
      'ADMIN_PLACEHOLDER_USERNAME'  => 'Username',
      'ADMIN_PLACEHOLDER_PASSWORD'  => 'Password',
      'ADMIN_BTN_LOGIN'             => 'Login',
    );

    echo $lang[$phrase];
  }
