<?php 
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

 define('HOST','localhost');
  define('USER','root');
  // define('PASS','5gX#*_[*qewCqGG9');
  define('PASS','');
  define('DB','your');
  $conn = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');
    mysqli_set_charset($conn, 'utf8');
 ?>