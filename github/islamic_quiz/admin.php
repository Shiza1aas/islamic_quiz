<?php 
	session_start();

  require_once('connectvars.php');

  // Start the session

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['a_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT a_id, a_name FROM admin WHERE a_name = '$user_username' AND a_password = '$user_password'";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['a_id'] = $row['a_id'];
          $_SESSION['a_name'] = $row['a_name'];
          setcookie('a_id', $row['a_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('a_name', $row['a_name'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          // $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          // header('Location: ' . $home_url);
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
    echo "You need to log in.";

  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Islamic - Log In Admin</title>

   <style>
                label
                {
                    display: inline-block;
                    width: 140px;
                }
            </style>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>Islamic - Log In Admin</h3>

<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['a_id'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Log In</legend>
      <label for="username">Admin Name:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Log In" name="submit" />
  </form>

  <p> It is log in page for admin. If you are user and want to log in , click <a href="login.php"> here </a> </p>

<?php
  }
  else {
    // Confirm the successful log-in
    echo'You are logged in as ' . $_SESSION['a_name'] ;
    ?>

</body>
</html>
<html>
<head>
	<title>
		Admin Page
	</title>
</head>
<body>
	<h5> What do you want </h5>

	<a href="question_records.php"> Manage Questions</a><br>
	<a href="user_records.php"> Manage Users </a><br>
	<a href="logout_admin.php"> Log Out </a>

</body>
</html>
<?php
}
?>