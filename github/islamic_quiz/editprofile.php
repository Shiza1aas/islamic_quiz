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
  <title>Islamic - Edit Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <style >
label
{
  display: inline-block;
  width: 150px;
  /*font-color: red;*/
}
 input[type="submit"],input
 {
color: blue; margin: 6px;   font-family: Verdana; font-weight: bold; font-size: 15px;border-radius: 10px;
  }
  </style>
</head>
<body>
  

<?php
  // require_once('appvars.php');
  require_once('connectvars.php');

  require_once('header.php');
   require_once('div.php');
?>
   <h3 style="font-size:30px;border: 2px black;color:green;" > Islamic Quiz- Edit Your Profile </h3>
   <?php
  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
    $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
    $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
    $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
    
    
    
      if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($state)) {
        
          $query = "UPDATE user SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
            " birthdate = '$birthdate', city = '$city', state = '$state' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p style="font-size:30px;border: 2px black; text-align:center;color:red;">Your profile has been successfully updated. Would you like to <a href="viewprofile.php" style="text-decoration:none;">view your profile</a>?</p>';

        mysqli_close($dbc);
        exit();
      }
      
      else {
        echo '<p style="font-size:30px;border: 2px black;color:red;">You must enter all of the profile data.</p>';
      }
    }
   // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT first_name, last_name, gender, birthdate, city, state FROM user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $gender = $row['gender'];
      $birthdate = $row['birthdate'];
      $city = $row['city'];
      $state = $row['state'];
      // $old_picture = $row['picture'];
    }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   
    <fieldset>
      <legend style="font-size:20px;border: 2px black; text-align:center;color:red;">Personal Information</legend>
      <label for="firstname">First Name:</label>
      <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name;  ?>" autofocus required /><br />
      <label for="lastname">Last Name:</label>
      <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
        <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
      </select><br />
      <label for="birthdate">Birthdate:</label>
      <input type="date" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" required /><br />
      <label for="city">City:</label>
      <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
      <label for="state">State:</label>
      <input type="text" id="state" name="state" value="<?php if (!empty($state)) echo $state; ?>" /><br />
    </fieldset>
    <input type="submit" value="Save Profile" name="submit"/>
  </form>
</body> 
</html>
