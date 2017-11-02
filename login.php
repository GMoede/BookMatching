<?php

// login.php

include("config.php");

session_start();

function login_form($message)
{
  echo <<<EOD
  <script src="js/md5.min.js"></script>
  <script src="login.js"></script>
  <body style="font-family: Arial, sans-serif;">

  <h2>Login Page</h2>
  <p>$message</p>
  <form id="form" action="login.php" method="POST">
    <p>Username: <input type="text" name="username" id="username"></p>

    <p>Password: <input type="text" name="password" id="password"</p>
    <input type="submit" value="Login">
  </form>
  </body>
EOD;
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  login_form('Welcome');
} else {
  // Check validity of the supplied username & password
  $c = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
  // Use a "bootstrap" identifier for this administration page
  oci_set_client_identifier($c, 'admin');

  $s = oci_parse($c, 'select username
                      from   ProjectUser 
                      where  username = :un_bv
                      and    password = :pw_bv');
  oci_bind_by_name($s, ":un_bv", $_POST['username']);
  oci_bind_by_name($s, ":pw_bv", $_POST['password']);
  oci_execute($s);
  $r = oci_fetch_array($s, OCI_ASSOC);

  if ($r) {
    // The password matches: the user can use the application

    // Set the user name to be used as the client identifier in
    // future HTTP requests:
    $_SESSION['username'] = $_POST['username'];

    echo <<<EOD
    <body style="font-family: Arial, sans-serif;">

    <h2>Login was successful</h2>
    <p><a href="application.php">Run the Application</a><p>
    </body>
EOD;
    exit;
  }
  else {
    // No rows matched so login failed
    login_form('Login failed. Valid usernames/passwords ' .
               'are "chris/tiger" and "alison/red"');
  }
}

?>
