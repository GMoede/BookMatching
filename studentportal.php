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
  <title>Student Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity=""></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity=""></script>
  <script src="studentportal.js?version=1" type="text/javascript"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
 
 <link rel="stylesheet" type="text/css" href="studentportal.css?version=3">
</head>
<body>
	<br>
	<br>
    <nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" id="websitelabel" >Student Portal</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">
	      <li><a href="login.php" onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
	    </ul>
	  </div>
	</nav>

	<div class="container" id="search_container">
		<div class="modal-body row poopyfart">
	  		<div class="col-md-5 text-center" id="sidebar">
	   		<!-- Your first column here -->
		   		<form class="form-horizontal" role="form" id="studentForm" name="studentForm" method="POST">
			        <br>
			        <label for="author" style="color: #fffff0;"> Preferred Author </label>
			        <div class="form-group row" id="author">
			        	<div class="col-xs-6">
					        <label for="input_firstname" style="color: #fffff0;"> First Name</label>
							<input class="form-control" id="input_firstname" name="input_firstname" type="text" placeholder="John">
						</div>
						<div class="col-xs-6">
							<label for="input_lastname" style="color: #fffff0;">Last Name</label>
							<input class="form-control" id="input_lastname" name="input_lastname" type="text" placeholder="Smith">
						</div>
					</div>

		            <div class="form-group">
		                <label for="input_topic" style="color: #fffff0;">Book Topic</label>
		                <select class="form-control" id="input_topic" name="input_topic">
		                    <option value="Adventure">Adventure</option>
							<option value="Children's literature">Children's literature</option>
							<option value="Fantasy">Fantasy</option>
							<option value="Fiction">Fiction</option>
							<option value="Historical Fiction">Historical Fiction</option>
							<option value="Horror">Horror</option>
							<option value="Middle Grade">Middle Grade</option>
							<option value="Novel">Novel</option>
							<option value="Realistic Fiction">Realistic Fiction</option>
							<option value="Science Fiction">Science Fiction</option>
							<option value="Young Adult">Young Adult</option>
		                </select>
		              </div>

		              <div class="form-group">
		                <label for="input_prot_feat" style="color: #fffff0;">Primary Protagonist Nature</label>
		                <select class="form-control" id="input_prot_feat" name="input_prot_feat">
		                    <option value="African American">African American</option>
							<option value="Afghanistani">Afghanistani</option>
							<option value="Biracial">Biracial</option>
							<option value="Chilean">Chilean</option>
							<option value="Hispanic">Hispanic</option>
							<option value="Pakistani">Pakistani</option>
							<option value="Scandinavian">Scandinavian American</option>
							<option value="Young">Young</option>
		                </select>
		              </div>

		              <div class="form-group">
		                <label for="input_prot_gender" style="color: #fffff0;">Protagonist Gender</label>
		                <select class="form-control" id="input_prot_gender" name="input_prot_gender">
		                	<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
		                </select>
		              </div>
		     			
		     			<div class="form-group row">
						  	<div class="col-xs-6">
						  	  <label for="input_pages" style="color: #fffff0;">Page Count</label>
						  	  <input class="form-control" id="input_pages" name="input_pages" type="text" placeholder="Ex: 1738">
						  	</div>
						 	<div class="col-xs-6">
						    	<label for="input_lexile" style="color: #fffff0;">Lexile</label>
						    	<input class="form-control" id="input_lexile" name="input_lexile" type="text" placeholder="Ex: 200L">
						  	</div>
						</div>
						<input type="button" class="btn btn-primary btnSeccion" onclick="update()" id="updateSearch" value="Update Search"/>
						<!-- <button type="submit" class="btn btn-default" onclick="updateSearch()">Update Search</button>-->
		            </form>

		  	</div>
		  	<div class="container" id="search">
		  		<div class="col-md-7">
		    		<!-- Search bar -->
		    		<!--<form class="navbar-form" role="search" id="searchbar">
		    			<div class="input-group add-on col-md-12">
		      				<input class="form-control" placeholder="Search by Class Number" name="srch-term" id="srch-term" type="text">
		      				<div class="input-group-btn">
		      					<input type="button" class="btn btn-primary btnSeccion" onclick="classSearch()" id="updateSearch" value="Search"/>
		      							      				</div>
		    			</div>
		  			</form>-->

		  			<!-- Template container to render textbook information--> 
		  				<div id="search_results" name="search_results">
		  					<!--
							<div class="row search_result">
						        <div class="title col-md-6">
						        	<p class="book_title_field"> Book Title (Copyright Year) </p>
						        	<p class="book_author_field"> by Author Name </p>
						        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Page Count: </span> <span class="book_detail_field right"> 420</span>
						        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Lexile: </span> <span class="book_detail_field left"> 100L </span>
						        </div>
						        <div class="details col-md-5"> 
						        	<p class="book_detail_header"> Topic:
						        		<span class="book_detail_field"> topic </span>
						        	</p>
						        	<p class="book_detail_field">  </p>
						        	<p class="book_detail_header"> Protagonist: 
						        		<span class="book_detail_field"> Prot_feat </span>
						        		<span class="book_detail_field"> Prot_gender </span>
						        	</p>
						        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Recommended: </span> <span class="book_detail_field left"> N
						        		<button type='button' style="right=0px;" class='btn btn-default recommend_button' id='$z' data-toggle='modal' data-target='#editModal' onclick='recommendBook(this.id)'>
	  										<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
										</button>
						        	</span> 
						        </div>
						    </div>
						    <div class="row search_result">
						        <div class="title col-md-6">
						        	<p class="book_title_field"> Book Title (Copyright Year) </p>
						        	<p class="book_author_field"> by Author Name </p>
						        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Page Count: </span> <span class="book_detail_field right"> 420</span>
						        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Lexile: </span> <span class="book_detail_field left"> 100L </span>
						        </div>
						        <div class="details col-md-5"> 
						        	<p class="book_detail_header"> Topic:
						        		<span class="book_detail_field"> topic </span>
						        	</p>
						        	<p class="book_detail_field">  </p>
						        	<p class="book_detail_header"> Protagonist: 
						        		<span class="book_detail_field"> Prot_feat </span>
						        		<span class="book_detail_field"> Prot_gender </span>
						        	</p>
						        	<span style="font: bold 12px/14px Georgia, serif; color: #fffff0;"> Recommended: </span> <span class="book_detail_field left"> N
						        		<button type='button' style="right=0px;" class='btn btn-default recommend_button' id='$z' data-toggle='modal' data-target='#editModal' onclick='recommendBook(this.id)'>
	  										<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
										</button>
						        	</span> 
						        </div>
						    </div>
						-->
						</div>
				    </div>
		    	</div>
	  		</div>
	  	</div>
  	</div>
</body>
</html>
