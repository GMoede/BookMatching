<?php

// login.php

include("config.php");

session_start();

function hash_func($data)
{
  $hash = password_hash($data, PASSWORD_BCRYPT);
  return $hash;
}

function sanitize_input($data) 
{
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function login_form($message)
{
  echo <<<EOD
  <!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="login.css?v=1">
  <script src="login.js" type="text/javascript"></script>
</head>
<body>

<div class="container-fluid" id="background">
  <br>
  <br>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6" id="login_bar">
  
      <div class="form-group text-center">
	<form id="form" name="myform" action="login.php" method="POST" onsubmit="hashPassword();">
	  <h1 style="color: #fffff0;"> Book Matching Portal </h1>
	  <br>
	  <br>
	    <label style="color: #fffff0;" for="username">Username: </label>
	    <input type="text" class="form-control" id="username" name="username" placeholder="johnsmith1">
	  <br>
	    <label style="color: #fffff0;" for="password">Password: </label>
	    <input type="password" class="form-control" name="password" id="password">
	  <br>
	  <input type="submit" value="Login">
	  <br>
	  <br>
	  <a href="createacct.php"> Not a user? Create Account. </a>
	</form>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>


</div>
    
</body>
</html>

<!--style="color: #fffff0;"-->

EOD;
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  login_form('Welcome');
} else {
  // Check validity of the supplied username & password
  $c = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
  // Use a "bootstrap" identifier for this administration page
  oci_set_client_identifier($c, 'admin');
  $username = $_POST['username'];
  $password = $_POST['password'];

  $username = sanitize_input($username);
  $password = sanitize_input($password);
  //$password = hash_func($password);
  

  $s = oci_parse($c, 'select username
                      from   ProjectUser 
                      where  username = :un_bv
                      and    password = :pw_bv');
  oci_bind_by_name($s, ":un_bv", $username);
  oci_bind_by_name($s, ":pw_bv", $password);
  oci_execute($s);
  $r = oci_fetch_array($s, OCI_ASSOC);


  if ($r) {
    // The password matches: the user can use the application

    // Set the user name to be used as the client identifier in
    // future HTTP requests:
    $_SESSION['username'] = $_POST['username'];

    $sql = "SELECT usertype
            FROM ProjectUser
            WHERE username = :un_bv";
    $sql_statement = oci_parse($c, $sql);
    oci_bind_by_name($sql_statement, ":un_bv", $username);
    oci_execute($sql_statement);

    while(oci_fetch($sql_statement)){
      if((oci_result($sql_statement, 1)) == "Student"){
            echo <<<EOD
            <body style="font-family: Arial, sans-serif;">
            <h2>Login was successful. Welcome Student!</h2>
            <p><a href="studentportal.php">Run the Application</a><p>
            </body>
          
EOD;
      }
      else{
            echo <<<EOD
            <body style="font-family: Arial, sans-serif;">

            <h2>Login was successful. Welcome Teacher!</h2>
            <p><a href="teacherportal.php">Run the Application</a><p>
            </body>
EOD;
      }
    }
    exit;
  }
  else {
    // No rows matched so login failed
    login_form('Login failed. Valid usernames/passwords ' .
               'are "poop/pee" and "kebab/coconut"');
  }
}

?>
