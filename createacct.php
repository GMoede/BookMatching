<?php


include("config.php");

session_start();
/*
function hash_func($data)
{
  $hash = password_hash($data, PASSWORD_BCRYPT);
  return $hash;
}
*/

function sanitize_input($data) 
{
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function createacct_form($message)
{
  echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Account Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="login.css?v=1">
  <script src="login.js?version=1" type="text/javascript"></script>
<sc
</head>
<body>

<div class="container-fluid" id="background">
  <br>
  <br>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6" id="login_bar">
      <form id="form" name="myform" action="createacct.php" method="POST" onsubmit="hashPassword();">
	<div class="form-group text-center">
	  <h1 style="color: #fffff0;"> -Book Matching Portal- <br> $message </h1>
	  <br>
	  <br>
	    <label style="color: #fffff0;" for="username">Username: </label>
	    <input type="text" class="form-control" id="username" name="username" placeholder="johnsmith1">
	  <br>
	    <label style="color: #fffff0;" for="password">Password: </label>
	    <input type="password" class="form-control" id="password" name="password">
	  <br>
	    <label style="color: #fffff0;" for="accounttype">Account Type: </label>
	    <select class="form-control" id="accounttype" name="accounttype">
		  <option>Teacher</option>
		  <option>Student</option>
	      </select>
	  <br>
	  <input type="submit" value="Create Account">
	  <br>
	  <br>
	  <a href="login.php"> Already have an account? Login. </a>
	</div>
      </form>
    </div>
    <div class="col-md-3"></div>
  </div>


</div>
    
</body>
</html>
EOD;
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  createacct_form('Welcome. Please enter a username, password, and account type.');
} else {  
  
  // Connect to oracle database
  $c = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
  
  // Use a "bootstrap" identifier for this administration page
  oci_set_client_identifier($c, 'admin');
  $username = $_POST['username'];
  $password = $_POST['password'];
  $accounttype = $_POST['accounttype'];

  //Sanitize inputs
  $username = sanitize_input($username);
  $password = sanitize_input($password);
  $accounttype = sanitize_input($accounttype);

  //Check if the username is already in the database. If it is, recreate login form with 'username taken' message
  $checkUsername = oci_parse($c, 'SELECT username FROM ProjectUser WHERE username = :un_bv');
  oci_bind_by_name($checkUsername, ":un_bv", $username);
  oci_execute($checkUsername, OCI_DEFAULT);
  echo (oci_result($checkUsername, 1));
  oci_fetch($checkUsername);
  if (oci_result($checkUsername, 1) == $username){
    createacct_form('That username is already taken. Please enter a different username.');
  } else {

    $s = oci_parse($c, 'INSERT INTO ProjectUser
		      (username, password, usertype)
		      VALUES
		      (:un_bv, :pw_bv, :at_bv)');
    oci_bind_by_name($s, ":un_bv", $username);
    oci_bind_by_name($s, ":pw_bv", $password);
    oci_bind_by_name($s, ":at_bv", $accounttype);

    oci_execute($s, OCI_DEFAULT);
    oci_commit($c);
    if (1) {
    // The password matches: the user can use the application

    // Set the user name to be used as the client identifier in
    // future HTTP requests:
    $_SESSION['username'] = $_POST['username'];
    header('Location: login.php');
    exit;

    echo <<<EOD
    <body style="font-family: Arial, sans-serif;">

    <h2>Account creation was successful.</h2>
    <p><a href="login.php">Try logging in with your new account</a><p>
    </body>
EOD;
    exit;
  }
  else {
    createacct_form('Account creation failed. Try again.');
  }
  }
}

?>

