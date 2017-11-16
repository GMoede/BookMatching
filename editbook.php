<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php



$input_title = $_POST["input_title"];

include("config.php");
$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
oci_set_client_identifier($conn, 'admin');
//THIS SQL STATEMENT IS WHERE WE NEED TO SORT
$sql = "SELECT title, firstname, lastname, copyright, lexile, pages, recommended, topic, prot_feat, prot_gender FROM book
	WHERE title = :input_title";
// parse SQL statement
$sql_statement = oci_parse($conn,$sql);

oci_bind_by_name($sql_statement, ":input_title", $input_title);


// execute SQL query
OCI_Execute($sql_statement);

OCI_Fetch($sql_statement);
$title = OCIResult($sql_statement, 1);
$firstname = OCIResult($sql_statement, 2);
$lastname = OCIResult($sql_statement, 3);
$copyright = OCIResult($sql_statement, 4);
$lexile = OCIResult($sql_statement, 5);
$pages = OCIResult($sql_statement, 6);
$recommended = OCIResult($sql_statement, 7);
$topic = OCIResult($sql_statement, 8);
$prot_feat = OCIResult($sql_statement, 9);
$prot_gender = OCIResult($sql_statement, 10);

// get number of columns for use later
$result = "{\"title\": \"$title\",
	    \"firstname\": \"$firstname\",
	    \"lastname\": \"$lastname\",
	    \"copyright\": \"$copyright\",
	    \"lexile\": \"$lexile\",
	    \"pages\": \"$pages\",
	    \"recommended\": \"$recommended\",
	    \"topic\": \"$topic\",
	    \"prot_feat\": \"$prot_feat\",
	    \"prot_gender\": \"$prot_gender\"
	  }";
// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
echo "$result";
?>
