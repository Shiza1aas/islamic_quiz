<?php 
	require_once('header.php');

	require_once('connectvars.php');
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$user_id = $_SESSION['user_id'];
	$user_name = $_SESSION['username'];

	$result = mysqli_query($dbc,"SELECT user_question.user_id,user_question.qid,user_question.answer_key FROM `user_question`join question WHERE user_question.qid = question.qid and user_question.user_id = $user_id")
	or die("Error in fetching the value.");
	$a_easy = $q_easy = $a_med = $q_med = $a_high = $q_high = 0 ;

	while ( $row = mysqli_fetch_array($result))
	{
		// echo $row['qid'];
		$k = $row['qid'];
		$result2 = mysqli_query($dbc,"SELECT lvl from question where qid = '$k'")
		or die("Error in selection");
		$row2= mysqli_fetch_array($result2);
		if( $row2['lvl'] == 'E')
		{
			$q_easy ++ ;
			if ( $row['answer_key'] == '1')
			{
				$a_easy++;
			}
		}
		if( $row2['lvl'] == 'M')
		{
			$q_med ++ ;
			if ( $row['answer_key'] == '1')
			{
				$a_med++;
			}
		}
		if( $row2['lvl'] == 'H')
		{
			$q_high ++ ;
			if ( $row['answer_key'] == '1')
			{
				$a_high++;
			}
		}
			// echo '<br>';
	}
	
	$total_score = $a_easy + 2 * $a_med + 4 * $a_high;

	$total_ques = $q_med + $q_easy + $q_high;

	$total_ans = $a_easy + $a_high + $a_med ;

	$result = mysqli_query($dbc,"update user set score = '$total_score' where user_id = '$user_id'")
	or die ( "Error in updation of score");
	// 
?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="table.css">
</head>
<body>
    <table class="view_score_table">
                    <tr>
                        <td>
                            Level
                        </td>
                        <td >
                            Question Attempted
                            
                        </td>
                        <td>
                            Correct
                         </td>
                        <td>
                            Score
                        </td>
                    </tr>
 

                
                    <tr>
                        <td >
                            <?php
                            echo 'Easy';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $q_easy;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $a_easy;
                           ?>
                        </td>
                        <td>
                            <?php
                            echo $a_easy;
                           ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <?php
                            echo 'Med';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $q_med;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $a_med;
                           ?>
                        </td>
                        <td>
                            <?php
                            echo 2 * $a_med;
                           ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <?php
                            echo 'High';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $q_high;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $a_high;
                           ?>
                        </td>
                        <td>
                            <?php
                            echo 4 * $a_high;
                           ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <?php
                            echo 'Total';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $q_easy + $q_med + $q_high;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $a_easy + $a_med + $a_high;
                           ?>
                        </td>
                        <td>
                            <?php
                            echo $total_score;
                           ?>
                        </td>
                    </tr>
               
</table>
            
</body>
</html>