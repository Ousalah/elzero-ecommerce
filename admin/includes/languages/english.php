<?php
  function lang( $phrase ) {
    static $lang = array(
      'MESSAGE' => 'Welcom',
      'ADMIN'   => 'Administrator'
    );

    return $lang[$phrase];
  }
