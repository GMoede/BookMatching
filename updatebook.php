<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php


$input_copyright = $_POST["edit_copyright"];
$input_title = $_POST["edit_title"];
$input_lexile = $_POST["edit_lexile"];
$input_lastname = $_POST["edit_lastname"];
$input_firstname = $_POST["edit_firstname"];
$input_pages = $_POST["edit_pages"];
$input_topic = $_POST["edit_topic"];
$input_prot_feat = $_POST["edit_prot_feat"];
$input_prot_gender = $_POST["edit_prot_gender"];
$existing_title = $_POST["existing_title"];

include("config.php");
$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
oci_set_client_identifier($conn, 'admin');
//THIS SQL STATEMENT IS WHERE WE NEED TO SORT
$sql = "UPDATE book
	SET title = :edit_title, firstname = :edit_firstname, lastname = :edit_lastname, copyright = :edit_copyright, lexile = :edit_lexile, pages = :edit_pages, topic = :edit_topic, prot_feat = :edit_prot_feat, prot_gender = :edit_prot_gender
	WHERE title = :existing_title";
// parse SQL statement
$sql_statement = oci_parse($conn,$sql);
oci_bind_by_name($sql_statement, ":edit_lexile", $input_lexile);
oci_bind_by_name($sql_statement, ":edit_lastname", $input_lastname);
oci_bind_by_name($sql_statement, ":edit_firstname", $input_firstname);
oci_bind_by_name($sql_statement, ":edit_pages", $input_pages);
oci_bind_by_name($sql_statement, ":edit_topic", $input_topic);
oci_bind_by_name($sql_statement, ":edit_prot_feat", $input_prot_feat);
oci_bind_by_name($sql_statement, ":edit_prot_gender", $input_prot_gender);
oci_bind_by_name($sql_statement, ":edit_title", $input_title);
oci_bind_by_name($sql_statement, ":edit_copyright", $input_copyright);
oci_bind_by_name($sql_statement, ":existing_title", $existing_title);


// execute SQL query
OCI_Execute($sql_statement);
// get number of columns for use later

// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
?>
</html>
