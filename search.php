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


while (OCI_Fetch($sql_statement)){
	//for each row we will save the appropriate values
	$title=OCIResult($sql_statement, 1);
	$title = str_replace("'", "&#39;", $title);
	$firstname=OCIResult($sql_statement, 2);
	$lastname=OCIResult($sql_statement, 3);
	$copyright=OCIResult($sql_statement, 4);
	$lexile=OCIResult($sql_statement, 5);
	$pages=OCIResult($sql_statement, 6);
	$recommended=OCIResult($sql_statement, 7);
	$topic=OCIResult($sql_statement, 8);
	$prot_feat=OCIResult($sql_statement, 9);
	$prot_gender=OCIResult($sql_statement, 10);

	//then we will insert them into the template for each row 

	echo "<div class="row search_result">
		        <div class="title col-md-6">
		        	<p class="book_title_field"> $title ($copyright) </p>
		        	<p class="book_author_field"> by $firstname $lastname </p>
		        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Page Count: </span> <span class="book_detail_field right"> $pages </span>
		        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Lexile: </span> <span class="book_detail_field left"> $lexile L </span>
		        </div>
		        <div class="details col-md-5"> 
		        	<p class="book_detail_header"> Topic:
		        		<span class="book_detail_field"> $topic </span>
		        	</p>
		        	<p class="book_detail_field">  </p>
		        	<p class="book_detail_header"> Protagonist: 
		        		<span class="book_detail_field"> $prot_feat </span>
		        		<span class="book_detail_field"> $prot_gender </span>
		        	</p>
		        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Recommended: </span> <span class="book_detail_field left"> N
		        		<button type='button' style="right=0px;" class='btn btn-default recommend_button' id='$title' data-toggle='modal' data-target='#editModal' onclick='recommendBook(this.id)'>
								<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
						</button>
		        	</span> 
		        </div>
		    </div>"

}


// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
?>
</html>
