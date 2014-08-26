<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>  
  <?php
  require_once('div.php');
  ?>
  <div id="top_div">
      <img src="image/readingquran.jpg" alt="ilm"/>
  </div>
  <div id = "left_div">
    <?php require_once('quotations.php'); ?>
  </div>
    
  <div id="right_div">
   
  
  </div>


  

</body>
</html>