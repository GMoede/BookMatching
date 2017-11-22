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

while (OCI_Fetch($sql_statement)){
  $title=OCIResult($sql_statement, 1);
  $title = str_replace("'", "&#39;", $title);
  $firstname=OCIResult($sql_statement, 2);
  $lastname=OCIResult($sql_statement, 3);
  $copyright=OCIResult($sql_statement, 4);
  $lexile=OCIResult($sql_statement, 5);
  $pages=OCIResult($sql_statement, 6);
  $topic=OCIResult($sql_statement, 8);
  $prot_feat=OCIResult($sql_statement, 9);
  $prot_gender=OCIResult($sql_statement, 10);

  echo "<div class="row search_result">
                <div class="title col-md-5">
                  <p class="book_title_field"> $title ($copyright) </p>
                  <p class="book_author_field"> by $firstname $lastname </p>
                  <span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Page Count: </span> <span class="book_detail_field right"> $pages </span>
                  <span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Lexile: </span> <span class="book_detail_field left"> $lexile L </span>
                </div>
                <div class="details col-md-4"> 
                  <p class="book_detail_header"> Topic:
                    <span class="book_detail_field"> $topic </span>
                  </p>
                  <p class="book_detail_field">  </p>
                  <p class="book_detail_header"> Protagonist: 
                    <span class="book_detail_field"> $prot_feat </span>
                    <span class="book_detail_field"> $prot_gender </span>
                  </p>
                </div>
                <div class="edit col-md-1">
                  <button type='button' class='btn btn-default edit edit_button' id='$z' data-toggle='modal' data-target='#editModal' onclick='editBook(this.id)'>
                  <span class='glyphicon glyphicon-pencil' aria-hidden='true'> Edit </span>
              </button>
                </div>
                <div class="delete col-md-1">
                  <button type='button' class='btn btn-default delete delete_button' id='$z' onclick='deleteBook(this.id)'>
                  <span class='glyphicon glyphicon-trash' aria-hidden='true'> Delete </span>
              </button>
                </div>
            </div>"
}

// free resources and close connection
//OCIFreeStatement($sql_statement);
//OCILogoff($conn);
?>
</html>