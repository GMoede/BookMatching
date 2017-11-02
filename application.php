<html>
<?php
include("config.php");
$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
oci_set_client_identifier($conn, 'admin');

$sql = "SELECT title, firstname, lastname, copyright, lexile, pages, recommended, topic, prot_feat, prot_gender FROM Book";

// parse SQL statement
$sql_statement = OCIParse($conn,$sql);


// execute SQL query
OCIExecute($sql_statement);
// get number of columns for use later
$num_columns = OCINumCols($sql_statement);
echo "<BR/>";
echo "</TR><TH>-- Obtaining results<TH>";
// start results formatting
echo "<TABLE BORDER=1>";
echo
"<TR><TH>Title</TH><TH>First Name</TH><TH>Last Name</TH><TH>Copyright</TH><TH>Lexile</TH><TH>Pages</TH><TH>Recommended?</TH><TH>Topic</TH><TH>Protagonist feature</TH><TH>Protagonist gender</TH>";

// format results by row
while (OCIFetch($sql_statement)){
echo "<TR>";
for ($i = 1; $i <= $num_columns; $i++) {
$column_value = OCIResult($sql_statement,$i);
echo "<TD>$column_value</TD>";
}
echo "</TR>";
}
echo "</TABLE>";
// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
?>
</html>
