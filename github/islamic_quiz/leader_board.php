<?php session_start(); ?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="table.css">
    
</head>
<body>
    <table class="CSSTableGenerator">
                    <tr>
                        <td>
                            Rank
                        </td>
                        <td >
                            Name
                        </td>
                        <td>
                            Score
                        </td>
                    </tr>
    <?php 
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $result = mysqli_query($dbc,"select * from user order by score desc,join_date desc limit 5");
     require_once('div.php');

    // echo "Top 5 ranker are: <br>";
    $i = 1 ;
    // echo '<table border=1px id="top_table"> <thead> <th> Name </th> <th> Score </th><tbody>';
    while ( ($row=mysqli_fetch_array($result)))
    {
      ?>
  

                
                    <tr>
                        <td >
                            <?php
                            echo $i;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row['username'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row['score'];
                           ?>
                        </td>
                    </tr>
                <?php    
                $i++;
                
      }

 ?>
</table>
            
</body>
</html>