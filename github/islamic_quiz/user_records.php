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
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        echo $user_id;

        mysqli_query($dbc,"set foreign_key_checks = 0")
        or die("Unable to unset");
        mysqli_query($dbc,"delete from user where user_id= '$user_id'")
        or die("Unable to delete");
        mysqli_query($dbc,"set foreign_key_checks = 1 ")
        or die("Unable to set");

        // or die("Unable to delete");

        echo 'The user'.$username. 'has been deleted successfully.';
    }
    // if ( isset($_POST['change']))
    // {
    //     $question = $_POST['username'];
    //     $a = $_POST['user_id'];
       
        

    //     if ( !empty($username) && !empty($user_id))
    //     {
            
    //                mysqli_query($dbc,"UPDATE `question` SET `sawal`='$question',`a`='$a',`b`='$b',`c`='$c',`d`='$d',`ANSWER`='$answer',`lvl`='$level',`type`='P',`permission`='$permission' WHERE qid='$qid'")

    //                or die("error in updaton");

             
    //      }
    // }


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
    $rs_result = mysqli_query ($dbc,"SELECT * FROM user LIMIT $start_from, 1");
      
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
            <h3> Change/Delete a users </h3>

                <form  method = "POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="username">User Name:</label>
                    <input type = "text" id = "username" name="username" value="<?php if ( !empty($row['username']))  echo $row['username']; ?>"/><br> 
                   
                   <label for = "user_id">User Id  </label>
                    <input type = "text" id = "user_id" name="user_id" value="<?php if ( !empty($row['user_id']))  echo $row['user_id']; ?>"/><br>

                  
                    <!-- <input type="submit" name="change" value="change"/> -->
                    <input type="submit" name="delete" value="delete"/>
                    <br>

                </form>

        </body>
        </html>
       <?php
            // echo $row['qid'];
    }
    $result = mysqli_query($dbc,"SELECT COUNT(username) FROM user");
    $row = mysqli_fetch_row($result);
    $total_records = $row[0];
    
     echo 'Go : ';
    for ($i=1; $i<=$total_records; $i++) {
                //echo '<button';
                echo "<a href='user_records.php?page=".$i."'>" . $i. "</a> ";
                //echo '</footer>';
    }
?>