<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php




$input_lexile = $_POST["input_lexile"];
$input_lastname = $_POST["input_lastname"];
$input_firstname = $_POST["input_firstname"];
$input_pages = $_POST["input_pages"];
$input_topic = $_POST["input_topic"];
$input_prot_feat = $_POST["input_prot_feat"];
$input_prot_gender = $_POST["input_prot_gender"];
$input_title = $_POST["input_title"];
$input_copyright = $_POST["input_copyright"];

include("config.php");
$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
oci_set_client_identifier($conn, 'admin');
//THIS SQL STATEMENT IS WHERE WE NEED TO SORT
$sql = "INSERT into BOOK values (:input_title, :input_firstname, :input_lastname, :input_copyright, :input_lexile, :input_pages, 'N', :input_topic, :input_prot_feat, :input_prot_gender)";
// parse SQL statement
$sql_statement = oci_parse($conn,$sql);
oci_bind_by_name($sql_statement, ":input_lexile", $input_lexile);
oci_bind_by_name($sql_statement, ":input_lastname", $input_lastname);
oci_bind_by_name($sql_statement, ":input_firstname", $input_firstname);
oci_bind_by_name($sql_statement, ":input_pages", $input_pages);
oci_bind_by_name($sql_statement, ":input_topic", $input_topic);
oci_bind_by_name($sql_statement, ":input_prot_feat", $input_prot_feat);
oci_bind_by_name($sql_statement, ":input_prot_gender", $input_prot_gender);
oci_bind_by_name($sql_statement, ":input_title", $input_title);
oci_bind_by_name($sql_statement, ":input_copyright", $input_copyright);


// execute SQL query
OCI_Execute($sql_statement);
// get number of columns for use later

// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
?>
</html>
