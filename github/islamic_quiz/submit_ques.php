<?php
    @session_start();
    require_once('header.php');

    if ( isset($_POST['submit']))
    {
        $question = $_POST['question'];
        $a = $_POST['A'];
        $b = $_POST['B'];
        $c = $_POST['C'];
        $d = $_POST['D'];
        $answer = $_POST['answer'];
        $level = $_POST['level'];
        $user_id = $_SESSION['user_id'];
        if ( !empty($question) && !empty($a) && !empty($b) && !empty($c) && !empty($d) && !empty($answer) )
        {
            if ( !ereg("[A-D]", $answer))
            {
                echo 'Enter the correct option.';
            }
            else
            {
                  
                   require_once('connectvars.php');
                   $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                   $query = "insert into question (sawal,user_id,a,b,c,d,lvl,answer,type) values ('$question','$user_id','$a','$b','$c','$d','$level','$answer','P') ";

                   $result = mysqli_query($dbc,$query)
                   or die("error in insertion");

                   echo 'Thanks for the question Mr.'.$_SESSION['username'];
                   echo ' Want to add more questions. Click <a href="submit_ques.php"> here </a>';
                   $question = "";
                    $a ="" ;
                    $b ="" ;
                    $c ="" ;
                    $d ="" ;
                    $answer ="";
                    $level = "";

                    exit();
                   mysqli_close($dbc);
                }   
            // }

        }


    }

?>



 <!DOCTYPE html>
        <html>
        <head>
            <title></title>
            <link rel="stylesheet" type="text/css" href="style.css">


            <style>
                label
                {
                    display: inline-block;
                    width: 140px;
                }
            
            textarea
            {
          color:    4B0082; font-family: Verdana; font-weight: bold;font-size:20px; background-color: #72A4D2;
            }
                input
                {
          color:    A0522D;    font-family: Verdana; font-weight: bold; font-size: 15px ; background-color: #aaa;
            }
            </style>
        </head>
        <body>
            <?php require_once('div.php'); ?>
            <h3> Submit a question </h3>

                <form  method = "POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="question">Question: </label>

                    <textarea rows= 5 cols=60 id = "question" name= "question" AUTOFOCUS> <?php  if ( !empty($_POST['question'])) echo $_POST['question']; ?></textarea><br>

                    <label for = "A">Option A: </label>
                    <input type = "text" id = "A" name="A" value="<?php if ( !empty($_POST['A']))  echo $_POST['A']; ?>"/><br>

                    <label for = "B">Option B: </label>
                    <input type = "text" id = "B" name="B" value="<?php if ( !empty($_POST['B'])) echo $_POST['B']; ?>"/><br>


                    <label for = "C">Option C: </label>
                    <input type = "text" id = "C" name="C" value="<?php if ( !empty($_POST['C'])) echo $_POST['C']; ?>"/><br>


                    <label for = "D">Option D: </label>
                    <input type = "text" id = "D" name="D" value="<?php if ( !empty($_POST['D'])) echo $_POST['D']; ?>"/><br>

                    <label for = "answer">Answer(option) : </label>
                    <input type = "text" id = "answer" name="answer" value="<?php if ( !empty($_POST['answer'])) echo $_POST['answer']; ?>"/><br>

                    
                    <label for = "level">Level: </label>
                    <input type="radio"  name="level" checked = "checked" value="E" > Easy
                    <input type="radio"  name="level" value="M" > Medium
                    <input type="radio"  name="level" value="H" > Hard
                   <br>
                   <input type="hidden" name="myform_key" value="<?php echo md5("CrazyFrogBros"); ?>" />
                    

                    <input id="color" type="submit" name="submit" value="Submit"/>

                </form>

        </body>
        </html>