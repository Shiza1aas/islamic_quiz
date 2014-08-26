<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Islamic - View Profile</title>
  <link rel="stylesheet" type="text/css" href="table.css" />
 
</head>
<body>
  <h3>Islamic - View Profile</h3>

<?php
  // require_once('appvars.php');
  require_once('connectvars.php');
  require_once('div.php');
  require_once('header.php');

  // Make sure the user is logged in before going any further.
  
  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Grab the profile data from the database
  if (!isset($_GET['user_id'])) {
    $query = "SELECT username, first_name, last_name, gender, birthdate, city, state FROM user WHERE user_id = '" . $_SESSION['user_id'] . "'";
  }
  else {
    $query = "SELECT username, first_name, last_name, gender, birthdate, city, state FROM user WHERE user_id = '" . $_GET['user_id'] . "'";
  }
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    echo '<table class="view_profile_table">';
    if (!empty($row['username'])) {
      echo '<tr><td>Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['first_name'])) {
      echo '<tr><td>First name:</td><td>' . $row['first_name'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
      echo '<tr><td>Last name:</td><td>' . $row['last_name'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
      echo '<tr><td>Gender:</td><td>';
      if ($row['gender'] == 'M') {
        echo 'Male';
      }
      else if ($row['gender'] == 'F') {
        echo 'Female';
      }
      else {
        echo '?';
      }
      echo '</td></tr>';
    }
    if (!empty($row['birthdate'])) {
      if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
        // Show the user their own birthdate
        echo '<tr><td>Birthdate:</td><td>' . $row['birthdate'] . '</td></tr>';
      }
      else {
        // Show only the birth year for everyone else
        list($year, $month, $day) = explode('-', $row['birthdate']);
        echo '<tr><td>Year born:</td><td>' . $year . '</td></tr>';
      }
    }
    if (!empty($row['city']) || !empty($row['state'])) {
      echo '<tr><td>Location:</td><td>' . $row['city'] . ', ' . $row['state'] . '</td></tr>';
    }
    
    echo '</table>';
    if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
      echo '<p style="font-size:30px;border: 2px black; text-align:center;color:red;">Would you like to <a href="editprofile.php" style="text-decoration:none;">edit your profile</a>?</p>';
    }
  } // End of check for a single row of user results
  else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
  }

  mysqli_close($dbc);
?>
</body> 
</html>
