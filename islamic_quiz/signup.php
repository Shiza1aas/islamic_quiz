<!DOCTYPE html >
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Islamic - Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <style>
  label
  {
    display: inline-block;
    width: 100px;
    color:chocolate;
    margin: 0 0 10px 0;
  }
   input
 {
  color: blue;    font-family: Verdana; font-weight: bold; font-size: 15px ; background-color: #aaa;
  }
  input[type="submit"]
  {
    color: green;
    border-radius: 4px;
    margin: 5px;
  }
  </style>
</head>
<body>
  <h3></h3>

<?php
  // require_once('appvars.php');
  require_once('connectvars.php');
  require_once('div.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM user WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO user (username, password, join_date) VALUES ('$username', SHA('$password1'), NOW())";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p style="font-size:30px;border: 2px black; text-align:center;color:red;">Your new account has been successfully created. You\'re now ready to <a href="login.php" style="text-decoration:none;"> log in</a>.</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p style="font-size:30px;border: 2px black;"><span style="color:red;">Oops</span>, An account already exists for this username. Please use a different username.</p>';
        $username = "";
      }
    }
    else {
      echo '<p style="font-size:30px;border: 2px black;"><span style="color:red;">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <h3> Just Sign Up and dive in the world of Islamic Quiz </h3>
  <form method="post" id="register" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" autofocus required/><br />
      
      <label for="password1">Password:</label>
      <input type="password" id="pass1" name="password1" /> <span id="strength"></span>
<br />

      <label for="password2">Password (retype):</label>
      <input type="password" id="pass2" name="password2" /> <span id = "match"></span><br />
  
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />
  </form>
  <script src="custom.js"></script>
</body> 
</html>
