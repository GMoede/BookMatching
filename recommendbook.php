<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
	$input_title = $_POST["input_title"];
	include("config.php");
	$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
	oci_set_client_identifier($conn, 'admin');

	//THIS SQL STATEMENT IS WHERE WE NEED TO SORT
	$sql = "UPDATE book
	SET recommended = 'Y'
	WHERE title = :input_title";

	// parse SQL statement
	$sql_statement = oci_parse($conn,$sql);
	oci_bind_by_name($sql_statement, ":input_title", $input_title);
	
	// execute SQL query
	OCI_Execute($sql_statement);
	
	// get number of columns for use later
	// free resources and close connection
	//OCIFreeStatement($sql_statement);
	//OCILogoff($conn);
?>
</html>