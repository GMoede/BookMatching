<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php

echo <<<EOD
    <body style="font-family: Arial, sans-serif;">
    <p><a href="student.html">Home</a><p>
    </body>
EOD;


$input_lexile = $_POST["lexile"];
$input_lastname = 'Ellis';
$input_firstname = 'Deborah';
$input_pages = 150;
$input_topic = 'Fantasy';
$input_prot_feat = 'Hispanic';
$input_prot_gender = 'Female';

include("config.php");
$conn = oci_pconnect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB);
oci_set_client_identifier($conn, 'admin');
//THIS SQL STATEMENT IS WHERE WE NEED TO SORT
$sql = "SELECT title, firstname, lastname, copyright, lexile, pages, recommended, topic, prot_feat, prot_gender
	FROM Book
	ORDER BY
	   (CASE
	      WHEN lexile <= :input_lexile then 1
	      ELSE 0
	    END) desc,
	    (CASE
	      WHEN lastname = :input_lastname AND firstname = :input_firstname then 1
	      ELSE 0
	    END) desc,
	    (CASE
	      WHEN recommended = 'Y' then 1
	      WHEN recommended = 'N' then 0
	    END) desc,
	    (CASE
	      WHEN pages <= :input_pages then 1
	      ELSE 0
	    END) desc,
	    (CASE
	      WHEN topic = :input_topic then 1
	      ELSE 0
	    END) desc,
	    (CASE
	      WHEN prot_feat = :input_prot_feat AND prot_gender = :input_prot_gender then 1
	      ELSE 0
	    END) desc";
// parse SQL statement
$sql_statement = oci_parse($conn,$sql);
oci_bind_by_name($sql_statement, ":input_lexile", $input_lexile);
oci_bind_by_name($sql_statement, ":input_lastname", $input_lastname);
oci_bind_by_name($sql_statement, ":input_firstname", $input_firstname);
oci_bind_by_name($sql_statement, ":input_pages", $input_pages);
oci_bind_by_name($sql_statement, ":input_topic", $input_topic);
oci_bind_by_name($sql_statement, ":input_prot_feat", $input_prot_feat);
oci_bind_by_name($sql_statement, ":input_prot_gender", $input_prot_gender);


// execute SQL query
OCI_Execute($sql_statement);
// get number of columns for use later
$num_columns = OCINumCols($sql_statement);


echo "<BR/>";
echo "</TR><TH>-- Obtaining results<TH>";
// start results formatting
echo "<TABLE BORDER=1>";
echo
"<TR><TH>Title</TH><TH>First Name</TH><TH>Last Name</TH><TH>Copyright</TH><TH>Lexile</TH><TH>Pages</TH><TH>Recommended?</TH><TH>Topic</TH><TH>Protagonist feature</TH><TH>Protagonist gender</TH>";

// format results by row
while (OCI_Fetch($sql_statement)){
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
