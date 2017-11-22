<?php

// createacct.php
echo <<<EOD
    <body style="font-family: Arial, sans-serif;">
    <p><a href="login.php">Already have an account? Login.</a><p>
    </body>
EOD;

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
  <script src="js/md5.min.js"></script>
  <script src="login.js"></script>
  <body style="font-family: Arial, sans-serif;">

  <h2>Create Account Page</h2>
  <p>$message</p>
  <form id="form" name="myform" action="createacct.php" method="POST" onsubmit="hashPassword();">
    <p>Username: <input type="text" name="username" id="username"></p>

    <p>Password: <input type="password" name="password" id="password"</p>

    <p>Account Type (Student/Teacher): <input type="text" name="accounttype" id="accounttype"</p>
    <input type="submit" value="Create Account">
  </body>
EOD;
}

if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['accounttype'])) {
  createacct_form('Welcome');
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

