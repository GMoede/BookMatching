function logout(){
  url = "logout.php";
  var posting = $.post(url);
    posting.done(function( data ) {
		  if(data){
		    alert('success');
		  }
		  else{
		    alert('failure');
		  }
	});
    setTimeout(function(){}, 250);
}

function verifyInputs(){
		var errors = [];
		if (document.getElementById("input_title").value === ""){
			errors.push("Title");
		}
		if(document.getElementById("input_firstname").value === ""){
			errors.push("Author First Name");
		}
		if(document.getElementById("input_lastname").value === ""){
			errors.push("Author Last Name");
		}
		if(document.getElementById("input_copyright").value === "" || document.getElementById("input_copyright").value.length < 4 || document.getElementById("input_copyright").value.length >= 5 || isNaN(document.getElementById("input_copyright").value)){
			errors.push("Copyright");
		}
		if(document.getElementById("input_lexile").value === ""){
			errors.push("Lexile");
		}
		if(document.getElementById("input_pages").value === "" || isNaN(document.getElementById("input_pages").value)){
			errors.push("Page Count");
		}
		//checking lexile validity
		var lexile = document.getElementById("input_lexile").value;
		lexile = lexile.replace(/L/g, ''); 
		if(isNaN(lexile) && errors.indexOf("Lexile") < 0){
			errors.push("Lexile");
		}
		if(errors.length > 0){
			alert("The following fields are incomplete/incorrect: " + errors);
		} else{
		  url = "addbook.php"


  //send data using post with element id lexile
		  var posting = $.post( url, { input_lexile: lexile, input_firstname: $('#input_firstname').val(), input_lastname: $('#input_lastname').val(), input_pages: $('#input_pages').val(), input_topic: $('#input_topic').val(), input_prot_feat: $('#input_prot_feat').val(), input_prot_gender: $('#input_prot_gender').val(), input_title: $('#input_title').val(), input_copyright: $('#input_copyright').val() } );

  //alerts the results
		  posting.done(function( data ) {
    //alert(data);
		  if(data) {
		    location.reload();
		    alert('success');
		  }
		  else{
		    alert('failure');
		  }
		  });
			//add book to database (AJAX call to php file)
		}
}

function editButtons(){
	for(var i = 0; i < 100; i++){
		document.getElementById("buttonbar").innerHTML += "<button type=\"button\" class=\"btn btn-default\" id=\"edit\" aria-label=\"Left Align\" data-toggle=\"modal\" data-target=\"#editModal\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"> Edit</span></button>";
	}		
}
$(document).ready(function(){
    url = "view.php"


  //send data using post with element id lexile
		  var posting = $.post(url);
		  posting.done(function(data){
		  if(data) {
		    $('#edit_container').html(data);
		  }
		  else{
		    alert('failure');
		  }
		  });
  
});
function deleteBook(title){
  console.log(title);
	var delete_var = confirm("Are you sure you want to delete this book?");
	if(delete_var == true){

  url = "deletebook.php"

		  
  //send data using post with element id lexile
		  var posting = $.post( url, { input_title: title } );

  //alerts the results
		  posting.done(function( data ) {
    //alert(data);
		  if(data){
		    alert('success');
		    console.log(data);
		    location.reload();
		  }
		  else{
		    alert('failure');
		  }
		  });
	}else{
		alert('book not deleted');
	}
  
  
}

function editBook(title){
    url = "editbook.php"
    var posting = $.post( url, {input_title: title } );
    existing_title = title;
    posting.done(function(data){
	if(data){
	  var index = data.indexOf("</script>") + 9;
	  data = data.replace(data.substring(0,index), "");
	  console.log(data);
	  var bookdata = JSON.parse(data);
	  global_bookdata = bookdata;
	  console.log(bookdata.title);
	  document.getElementById("edit_title").value = bookdata.title;
	  document.getElementById("edit_firstname").value = bookdata.firstname;
	  document.getElementById("edit_lastname").value = bookdata.lastname;
	  document.getElementById("edit_copyright").value = bookdata.copyright;
	  document.getElementById("edit_pages").value = bookdata.pages;
	  document.getElementById("edit_lexile").value = bookdata.lexile;
	  document.getElementById("edit_topic").value = bookdata.topic;
	  document.getElementById("edit_prot_feat").value = bookdata.prot_feat;
	  document.getElementById("edit_prot_gender").value = bookdata.prot_gender;  
	}
	else{
	  alert('failure');
	}
    });
}
var global_bookdata;
var existing_title;

function updateBook(){
    url = "updatebook.php"
	  global_bookdata.title = document.getElementById("edit_title").value;
	  global_bookdata.firstname = document.getElementById("edit_firstname").value;
	  global_bookdata.lastname = document.getElementById("edit_lastname").value;
	  global_bookdata.copyright = document.getElementById("edit_copyright").value;
	  global_bookdata.pages = document.getElementById("edit_pages").value;
	  global_bookdata.lexile = document.getElementById("edit_lexile").value;
	  global_bookdata.topic = document.getElementById("edit_topic").value;
	  global_bookdata.prot_feat = document.getElementById("edit_prot_feat").value;
	  global_bookdata.prot_gender = document.getElementById("edit_prot_gender").value; 
    var posting = $.post( url, {edit_title: global_bookdata.title, edit_firstname: global_bookdata.firstname, edit_lastname: global_bookdata.lastname, edit_copyright: global_bookdata.copyright, edit_pages: global_bookdata.pages, edit_lexile: global_bookdata.lexile, edit_topic: global_bookdata.topic, edit_prot_feat: global_bookdata.prot_feat, edit_prot_gender: global_bookdata.prot_gender, existing_title: existing_title } );
    console.log(existing_title);
    console.log(global_bookdata.title);
    posting.done(function(data){
	if(data){
	  location.reload();
	  alert('success');
	}
	else{
	  alert('failure');
	}
    });
  
}

function updateOrder(){
	url = "updateorder.php"

	var input_order = document.getElementById("input_order").value;
  //send data using post with element id lexile
	var posting = $.post(url , {orderby: $('#input_order').val()});
	console.log(document.getElementById("input_order").value);

	posting.done(function(data){
		if(data) {
			 $('#edit_container').html(data);
		}
		else{
			alert('failure');
		}
	});


}
