<!DOCTYPE html>
<?php
session_start();
if ($_SESSION['username'] == NULL){
	header("Location: login.php");
	exit();
}
?>
<html lang="en">
<head>
  <title>Teacher Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="teacherportal.js?v=1" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="teacherportal.css?v=1">

</head>
<body>
	<br>
	<br>
 	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Teacher Portal</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">
	      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
	    </ul>
	  </div>
	</nav>
 	<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#edit"> View/Edit Books </a></li>
    	<li><a href="#add" data-toggle="tab">Add Books</a></li>
    	
  	</ul>
	<div class="tab-content">
		<div class="tab-pane fade" id="add"> 
			<div class="container" id="input_books">
				<div class="form-group text-center">

					<br>

					<p id=book_label> Book details: </p>

					<label style="color: #fffff0;" for="input_title">Book Title:</label>
					<input type="text" class="form-control" id="input_title" placeholder="The Cat and The Hat">

					<br>

					<label style="color: #fffff0;" for="author"> Preferred Author </label>
			        <div class="form-group row" id="author">
			        	<div class="col-xs-6">
					        <label style="color: #fffff0;" for="input_firstname"> First Name</label>
							<input class="form-control" id="input_firstname" name="input_firstname" type="text" placeholder="John">
						</div>
						<div class="col-xs-6">
							<label style="color: #fffff0;" for="input_lastname">Last Name</label>
							<input class="form-control" id="input_lastname" name="input_lastname" type="text" placeholder="Smith">
						</div>
					</div>


					<div class="form-group row">
					  	<div class="col-xs-4">
					    	<label style="color: #fffff0;" for="input_copyright">Copyright Year</label>
					    	<input class="form-control text-white" id="input_copyright" type="text" placeholder="Ex: 2001">
					  	</div>
					  	<div class="col-xs-4">
					  	  <label style="color: #fffff0;" for="input_pages">Page Count</label>
					  	  <input class="form-control" id="input_pages" name="input_pages" type="text" placeholder="Ex: 1738">
					  	</div>
					 	<div class="col-xs-4">
					    	<label style="color: #fffff0;" for="input_lexile">Lexile</label>
					    	<input class="form-control" id="input_lexile" name="input_lexile" type="text" placeholder="Ex: 200L">
					  	</div>
					</div>


					<label style="color: #fffff0;" for="input_topic">Book Topic</label>
		      		<select class="form-control" id="input_topic">
		        		<option>Adventure</option>
		        		<option>Children's literature</option>
		        		<option>Fantasy</option>
		        		<option>Fiction</option>
		        		<option>Historical Fiction</option>
						<option>Horror</option>
						<option>Middle Grade</option>
		        		<option>Novel</option>
		        		<option>Realistic Fiction</option>
		        		<option>Science Fiction</option>
		        		<option>Young Adult</option>
		     		</select>

		     		<br>

		     		<p id=prot_label> Protagonist Characteristics: </p>


		     		<label style="color: #fffff0;" for="input_prot_feat">Primary Protagonist Nature</label>
		      		<select class="form-control" id="input_prot_feat">
		        		<option>African American</option>
		        		<option>Afghanistani</option>
		        		<option>Biracial</option>
		        		<option>Chilean</option>
		        		<option>Hispanic</option>
		        		<option>Pakistani</option>
		        		<option>Scandinavian American</option>
		        		<option>Young</option>
		     		 </select>

		     		 <label style="color: #fffff0;" for="input_prot_gender">Protagonist Gender</label>
		     		 <select class="form-control" id="input_prot_gender">
		     		 	<option>Male</option>
		     		 	<option>Female</option>
		     		 	<option>Other</option>
		     		 </select>

		     		 <br>

		      		<button type="submit" class="btn btn-default" onclick="verifyInputs()">Add Book To Student Portal</button>
		  		</div>
		  	</div>
	  	</div>

		<div class="tab-pane fade in active text" id="edit">  
			<div class="container text-center" id="order_container">
				<form class="form-inline">
					<label for="sel1">Order By:</label>
	  				<select class="form-control" id="input_order">
					    <option value="title">Title</option>
					    <option value="firstname">Author First Name</option>
					    <option value="lastname">Author Last Name</option>
					    <option value="copyright">Copyright Year</option>
					    <option value="lexile">Lexile</option>
					 </select>
					 <button type="button" class="btn btn-primary" onclick="updateOrder()">Update</button>
				</form>
			</div>

			<br> 

			<div class="container" id="edit_container">
				<div class="container">
					<!--
				     <div class="row search_result">
				        <div class="title col-md-5">
				        	<p class="book_title_field"> Book Title (Copyright Year) </p>
				        	<p class="book_author_field"> by Author Name </p>
				        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Page Count: </span> <span class="book_detail_field right"> 420</span>
				        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Lexile: </span> <span class="book_detail_field left"> 100L </span>
				        </div>
				        <div class="details col-md-4"> 
				        	<p class="book_detail_header"> Topic:
				        		<span class="book_detail_field"> topic </span>
				        	</p>
				        	<p class="book_detail_field">  </p>
				        	<p class="book_detail_header"> Protagonist: 
				        		<span class="book_detail_field"> Prot_feat </span>
				        		<span class="book_detail_field"> Prot_gender </span>
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
				    </div>
				    <div class="row search_result">
				        <div class="title col-md-5">
				        	<p class="book_title_field"> Book Title (Copyright Year) </p>
				        	<p class="book_author_field"> by Author Name </p>
				        	<span style="font: bold 12px/14px Georgia, serif; color: white;"> Page Count: </span> <span class="book_detail_field right"> 420</span>
				        	<span style="font: bold 12px/14px Georgia, serif; color: white;"> Lexile: </span> <span class="book_detail_field left"> 100L </span>
				        </div>
				        <div class="details col-md-4"> 
				        	<p class="book_detail_header"> Topic:
				        		<span class="book_detail_field"> topic </span>
				        	</p>
				        	<p class="book_detail_field">  </p>
				        	<p class="book_detail_header"> Protagonist: 
				        		<span class="book_detail_field"> Prot_feat </span>
				        		<span class="book_detail_field"> Prot_gender </span>
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
				    </div>
					-->
				</div>
			</div>

			<div class="modal fade" id="editModal" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Edit Book</h4>
		        </div>
		        <div class="modal-body">
		          	<p id=book_label> Book details: </p>

					<label for="edit_title">Book Title:</label>
					<input type="text" class="form-control" id="edit_title" name="edit_title" placeholder="The Cat and The Hat">

					<br>

					<label for="author"> Preferred Author </label>
			        <div class="form-group row" id="author">
			        	<div class="col-xs-6">
					        <label for="edit_firstname"> First Name</label>
							<input class="form-control" id="edit_firstname" name="edit_firstname" type="text" placeholder="John">
						</div>
						<div class="col-xs-6">
							<label for="edit_lastname">Last Name</label>
							<input class="form-control" id="edit_lastname" name="edit_lastname" type="text" placeholder="Smith">
						</div>
					</div>


					<div class="form-group row">
					  	<div class="col-xs-4">
					    	<label for="edit_copyright">Copyright Year</label>
					    	<input class="form-control" id="edit_copyright" type="text" placeholder="Ex: 2001">
					  	</div>
					  	<div class="col-xs-4">
					  	  <label for="edit_pages">Page Count</label>
					  	  <input class="form-control" id="edit_pages" name="edit_pages" type="text" placeholder="Ex: 1738">
					  	</div>
					 	<div class="col-xs-4">
					    	<label for="edit_lexile">Lexile</label>
					    	<input class="form-control" id="edit_lexile" name="edit_lexile" type="text" placeholder="Ex: 200L">
					  	</div>
					</div>


					<label for="edit_topic">Book Topic</label>
		      		<select class="form-control" id="edit_topic">
		        		<option>Adventure</option>
		        		<option>Children's literature</option>
		        		<option>Fantasy</option>
		        		<option>Fiction</option>
		        		<option>Historical Fiction</option>
						<option>Horror</option>
						<option>Middle Grade</option>
		        		<option>Novel</option>
		        		<option>Realistic Fiction</option>
		        		<option>Science Fiction</option>
		        		<option>Young adult</option>
		     		</select>

		     		<br>

		     		<p id=prot_label> Protagonist Characteristics: </p>


		     		<label for="edit_prot_feat">Primary Protagonist Nature</label>
		      		<select class="form-control" id="edit_prot_feat">
		        		<option>African American</option>
		        		<option>Afghanistani</option>
		        		<option>Biracial</option>
		        		<option>Chilean</option>
		        		<option>Hispanic</option>
		        		<option>Pakistani</option>
		        		<option>Scandinavian American</option>
		        		<option>Young</option>
					<option>Haitian</option>
		     		 </select>

		     		 <label for="edit_prot_gender">Protagonist Gender</label>
		     		 <select class="form-control" id="edit_prot_gender">
		     		 	<option>Male</option>
		     		 	<option>Female</option>
		     		 	<option>Other</option>
		     		 </select>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal" onclick='updateBook()'>Save</button>
		        </div>
		      </div>
		      
		    </div>
		  </div>

		</div>		

	</div>
</body>
</html>

