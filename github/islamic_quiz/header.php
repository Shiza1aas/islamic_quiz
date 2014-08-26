<?php 
	@session_start();
    if (!isset($_SESSION['user_id'])) {

    ?>

    <html>
    <head>
    	<title></title>
    	<link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
    	<?php 
   	require_once('div.php');

    	 ?>
    	<div >
    		<!-- <button> You need to Log in to access this page.</button> -->
    		<?php require_once('login.php'); ?>

    	</div>
    	

    </body>
    </html>
    <?php
    exit();
  }
 
 ?>