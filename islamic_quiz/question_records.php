<?php 
	session_start();
    if (!isset($_SESSION['a_id'])) {
    echo '<p class="login">Please <a href="admin.php">log in</a> to access this page.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['a_name'] . '. <a href="logout_admin.php">Log out</a>.</p>');
  }

	require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


    if ( isset($_POST['delete']))
    {
    	$qid = $_POST['qid'];
    	echo $qid;

    	mysqli_query($dbc,"set foreign_key_checks = 0")
    	or die("Unable to unset");
    	mysqli_query($dbc,"delete from question where qid = '$qid'")
    	or die("Unable to delete");
    	mysqli_query($dbc,"set foreign_key_checks = 1 ")
    	or die("Unable to set");

    	// or die("Unable to delete");

    	echo 'The question has been deleted successfully.';
    }
    if ( isset($_POST['change']))
    {
    	$question = $_POST['question'];
        $a = $_POST['A'];
        $b = $_POST['B'];
        $c = $_POST['C'];
        $d = $_POST['D'];
        $answer = $_POST['answer'];
        $level = $_POST['level'];
        $qid = $_POST['qid'];
        $permission = $_POST['permission'];

        if ( !empty($question) && !empty($a) && !empty($b) && !empty($c) && !empty($d) && !empty($answer) )
        {
            if ( !ereg("[A-D]", $answer))
            {
                echo 'Enter the correct option.';
            }
            else
            {
                   mysqli_query($dbc,"UPDATE `question` SET `sawal`='$question',`a`='$a',`b`='$b',`c`='$c',`d`='$d',`ANSWER`='$answer',`lvl`='$level',`type`='P',`permission`='$permission' WHERE qid='$qid'")

                   or die("error in updaton");

              

                  // exit();
                   //($dbc);
                }   
         }
    }


    if (isset($_GET["page"])) 

    { 
    	$page  = $_GET["page"]; 
    } 

    else 
    { 
    	$page=1; 
    }
	$start_from = ($page-1) * 1;
	//$sql = "SELECT * FROM assign ORDER BY id ASC LIMIT $start_from, 5";
	$rs_result = mysqli_query ($dbc,"SELECT * FROM question LIMIT $start_from, 1");
	  
	echo "<table>";
	  
	while ($row = mysqli_fetch_array($rs_result)) {
		?>
	 
	        <!DOCTYPE html>
        <html>
        <head>
            <title></title>
            <style>
                label
                {
                    display: inline-block;
                    width: 140px;
                }
            </style>
        </head>
        <body>
            <h3> Change/Delete a question </h3>

                <form  method = "POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="question">Question:</label>

                    <textarea rows= 5 cols=60 id = "question" name= "question"> <?php  if ( !empty($row['sawal'])) echo $row['sawal']; ?></textarea><br>

                    <label for = "A">Option A: </label>
                    <input type = "text" id = "A" name="A" value="<?php if ( !empty($row['a']))  echo $row['a']; ?>"/><br>

                    <label for = "B">Option B: </label>
                    <input type = "text" id = "B" name="B" value="<?php if ( !empty($row['b'])) echo $row['b']; ?>"/><br>


                    <label for = "C">Option C: </label>
                    <input type = "text" id = "C" name="C" value="<?php if ( !empty($row['c'])) echo $row['c']; ?>"/><br>


                    <label for = "D">Option D: </label>
                    <input type = "text" id = "D" name="D" value="<?php if ( !empty($row['d'])) echo $row['d']; ?>"/><br>

                    <label for = "answer">Answer(option) : </label>
                    <input type = "text" id = "answer" name="answer" value="<?php if ( !empty($row['ANSWER'])) echo $row['ANSWER']; ?>"/><br>

                    
                    <label for = "level">Level: </label>
                    <input type="radio"  name="level" checked = "<?php if (($row['lvl']) == 'E') echo 'checked'; ?>" value="E" > Easy
                    <input type="radio"  name="level" checked = "<?php if (($row['lvl']) == 'M') echo 'checked'; ?>"  value="M" > Medium
                    <input type="radio"  name="level" checked = "<?php if (($row['lvl']) == 'H') echo 'checked'; ?>"  value="H" > Hard


                   <br>
                   	<label for = "level">Permission: </label>
                    <input type="radio"  name="permission" checked = "<?php if (($row['permission']) == '0') echo 'checked'; ?>" value="0" > Not Allow
                    <input type="radio"  name="permission" checked = "<?php if (($row['permission']) == '1') echo 'checked'; ?>" value="1" > Allow
                   <br>

                   <!-- <input type="hidden" name="myform_key" value="<?php echo md5("CrazyFrogBros"); ?>" /> -->
                    

                    <input type="hidden" name="qid" value="<?php echo $row['qid'] ;?>"/>
                    <input type="submit" name="change" value="change"/>
                    <input type="submit" name="delete" value="delete"/>
                    <br>

                </form>

        </body>
        </html>
       <?php
	        echo $row['qid'];
	}
	$result = mysqli_query($dbc,"SELECT COUNT(sawal) FROM question");
	$row = mysqli_fetch_row($result);
	$total_records = $row[0];
	
	 echo 'Go : ';
	for ($i=1; $i<=$total_records; $i++) {
				//echo '<button';
	            echo "<a href='user_records.php?page=".$i."'>" . $i. "</a> ";
	 			//echo '</footer>';
	}
?>