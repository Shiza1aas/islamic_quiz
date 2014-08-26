<?php
  require_once('connectvars.php');
  require_once('div.php');

  // Start the session
  @session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, username FROM user WHERE username = '$user_username' AND password = SHA('$user_password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }
?>

<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Islamic - Log In</title>

  <link rel="stylesheet" type="text/css" href="style.css" />
  <style>
  form
        {
           position: absolute;
            /*top: 50%;*/
           
          
        }
        input[type=submit]
        {
          margin: 10px;
          border-radius: 5px;
          background-color: dcdcdc;
        }
         input
         {
        color: blue;    font-family: Verdana; font-weight: bold; font-size: 15px ; background-color: #aaa;
          }
          label
          {
            display: inline-block;
            width: 200px;
            margin: 0 0 10px 0;
            color: olive;
          }
        </style>
</head>
<body>
  <div>
  <h3 > Just log in and div in the World of Islamic Quiz</h3>

<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
    echo '<p class="error">' . $error_msg . '</p>';
   
?>

  
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Log In</legend>
      <label for="User Name">User Name:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" autofocus required/><br />
      <label for="password">Password: </label>
      <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Log In" name="submit" />
  </form>

  </div>
  <!-- <div style="float:left;margin: 0 0 0 200px;">
      <?php 
      // require_once('signup.php');
       ?>
  </div> -->
  '<p style="font-size:30px;border: 2px black; text-align:center;color:red;">Do not have any account, Sign Up <a href="signup.php" style="text-decoration:none;">here.</a></p>

<?php
  }
  else {
    // Confirm the successful log-in
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
  }
?>

</body>
</html>
