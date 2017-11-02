<?php

// createacct.php

include("config.php");

session_start();

function createacct_form($message)
{
  echo <<<EOD
  <script src="js/md5.min.js"></script>
  <script src="login.js"></script>
  <body style="font-family: Arial, sans-serif;">

  <h2>Create Account Page</h2>
  <p>$message</p>
  <form id="form" action="createacct.php" method="POST">
    <p>Username: <input type="text" name="username" id="username"></p>

    <p>Password: <input type="text" name="password" id="password"</p>

    <p>Account Type (Student/Teacher): <input type="text" name="accounttype" id="accounttype"</p>
    <input type="submit" value="Create Account">
  </body>
EOD;
}

if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['accounttype'])) {
  createacct_form('Welcome');
} else {
  echo <<<EOD
  <script> hashPassword(); </script>
EOD;
  
  // Check validity of the supplied username & password
  $c = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
  // Use a "bootstrap" identifier for this administration page
  oci_set_client_identifier($c, 'admin');

  $s = oci_parse($c, 'INSERT INTO ProjectUser
		      (username, password, usertype)
		      VALUES
		      (:un_bv, :pw_bv, :at_bv)');
  oci_bind_by_name($s, ":un_bv", $_POST['username']);
  oci_bind_by_name($s, ":pw_bv", $_POST['password']);
  oci_bind_by_name($s, ":at_bv", $_POST['accounttype']);
  oci_execute($s, OCI_DEFAULT);
  oci_commit($c);
/*  $r = oci_fetch_array($s, OCI_ASSOC);

 */ if (1) {
    // The password matches: the user can use the application

    // Set the user name to be used as the client identifier in
    // future HTTP requests:
    $_SESSION['username'] = $_POST['username'];

    echo <<<EOD
    <body style="font-family: Arial, sans-serif;">

    <h2>Login was successful</h2>
    <p><a href="login.php">Try logging in with your new account</a><p>
    </body>
EOD;
    exit;
  }
  else {
    // No rows matched so login failed
    createacct_form('Account creation failed. Try again."');
  }
}

?>

