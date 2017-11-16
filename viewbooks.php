<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php






include("config.php");
$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
oci_set_client_identifier($conn, 'admin');
//THIS SQL STATEMENT IS WHERE WE NEED TO SORT
$sql = "SELECT title, firstname, lastname, copyright, lexile, pages, recommended, topic, prot_feat, prot_gender
	FROM Book
	ORDER BY title desc";
// parse SQL statement
$sql_statement = oci_parse($conn,$sql);



// execute SQL query
OCI_Execute($sql_statement);
// get number of columns for use later
$num_columns = OCINumCols($sql_statement);


echo "<BR/>";
echo "</TR><TH>-- Obtaining results<TH>";
// start results formatting
echo "<TABLE BORDER=1 id='resultTable'>";
echo
"<TR><TH>Title</TH><TH>First Name</TH><TH>Last Name</TH><TH>Copyright</TH><TH>Lexile</TH><TH>Pages</TH><TH>Recommended?</TH><TH>Topic</TH><TH>Protagonist feature</TH><TH>Protagonist gender</TH><TH>Delete</TH><TH>Edit</TH>";

// format results by row
$z = 0;
while (OCI_Fetch($sql_statement)){
  $z=OCIResult($sql_statement, 1);
  $z = str_replace("'", "&#39;", $z);
  echo "<TR id='$z'>";
  for ($i = 1; $i <= $num_columns; $i++) {
    $column_value = OCIResult($sql_statement,$i);
    echo "<TD>$column_value</TD>";
  }
  
  echo "<TD><button type='button' class='btn btn-default' id='$z' onclick='deleteBook(this.id)'>
	  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
	</button></TD>";
  echo "<TD><button type='button' class='btn btn-default' id='$z' data-toggle='modal' data-target='#editModal' onclick='editBook(this.id)'>
	  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
	</button></TD>";
  echo "</TR>";
}
echo "</TABLE>";

// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
?>
</html>
