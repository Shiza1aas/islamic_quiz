
	<?php
	require_once('header.php');
  	if ( isset($_GET['level']))
  	{
  		$level = $_GET['level'];
  	}		
  
  	else
  	{
  		$level = 'E';
  	}
  	  	//connecting to Data Base
  	require_once('connectvars.php');
  	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  	if ( isset($_POST['submit']))
  	{

  
  		$level = $_POST['level'];
  		// $_SESSION['flag']
  		@$answer = $_POST['answer'];


	  		$qid = $_POST['qid'];
	  		$select = $_POST['select'];
	  		$user_id = $_SESSION['user_id'];

	  		$result = mysqli_query($dbc,"select * from question where qid = '$qid'")
	  		or die("Error in connection.");

	  		$row = mysqli_fetch_array($result);
	  		if ( empty($row['ANSWER']))
	  		{
	  			mysqli_query($dbc,"insert into user_question ( qid,user_id,answer_key) values ( '$select','$user_id',2)")
		    	or die ("Error in updating values in user_question");


	  		}

	  		else if ( $row['ANSWER'] == $answer)
	  		{
	  			// echo 'Your answer is correct.';
	  			mysqli_query($dbc,"insert into user_question ( qid,user_id,answer_key) values ( '$select','$user_id',1)")
		    	or die ("Error in updating values in user_question");

	  		}
	  		else
	  		{
				// echo 'Your answer is incorrect.';
	  			mysqli_query($dbc,"insert into user_question ( qid,user_id,answer_key) values ( '$select','$user_id',0)")
		    	or die ("Error in updating values in user_question");  			
	  		}
	  		$answer = "";
	  	}

		

		$user_id = $_SESSION['user_id'];
	    // $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	    //Taking a random value from the list of question
	    $id_list = array();
	    // echo $user_id;
	    // echo $level;
	    $result = mysqli_query($dbc,"select * from question where permission = 1 and qid not in ( select qid from user_question where user_id = '$user_id' )");
	    while ( ($row = mysqli_fetch_array($result)) )
	    {
	    	if ( $row['user_id'] != $user_id)
	    	array_push($id_list,$row['qid']);
	    }
	    // print_r($id_list);
	    //Whether user viewed all the questions
	    if ( empty($id_list))
	    {
	    	echo 'Great, You have visited all the question, wait for more update ';
	    	echo '<br>';
	    	 echo '&#10084; <a href="view_score.php">View Your Score</a><br />';
	    	exit();
	    }
	    // Taking a random value after shuffling it

	    shuffle($id_list);
	    $select = $id_list[array_rand($id_list)];

	    
	    // echo $select;
	    $result = mysqli_query($dbc,"select * from question where qid='$select'")
	    or die("Error in selection");

	    // Sho
	    $row = mysqli_fetch_array($result);
?>
	        <!DOCTYPE html>
	        <html>
	        <head>
	            <title></title>
	            <link rel="stylesheet" type="text/css" href="style.css">
	        </head>
	        <body>
	        	<?php require_once('div.php'); ?>
	        	<div style="width:50%;margin:0px auto;">
			    	<?php 
					// echo 'Here is the clock.';
					require_once('base.php');
					 ?>
			    </div>

	        	<div style="width: 50%; margin: 0 auto; ">
	        	
	        	 
				<!-- <p>It is going to expire in 1 minute.</p> -->
	            <h3 id = "center"> <?php echo $row['sawal']; ?></h3>

	                <form  method = "POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

	                    <input type="radio"  name=" answer" value="A" checked="checked" ><?php echo $row['a']; ?><br>
	                    <input type="radio"  name=" answer" value="B" ><?php echo $row['b']; ?><br>
	                    <input type="radio"  name=" answer" value="C" ><?php echo $row['c']; ?><br>
	                    <input type="radio"  name=" answer" value="D" ><?php echo $row['d']; ?><br>

	                    <input type="hidden" name = "qid" value="<?php echo $row['qid'] ?>">
	                 <!--    <input type="hidden" name = "range" value="<?php  $range ?>"> -->
	                    <input type="hidden" name = "level" value="<?php  echo $level ?>">
	                    <input type="hidden" name = "select" value="<?php  echo $select ?>">

	                    <input id= "color" type="submit" name="submit" value="ANSWER"/>

	                </form>
	             </div>


	        </body>
	        </html>
   





</body>
</html>