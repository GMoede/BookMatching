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
		  var posting = $.post( url, { input_lexile: $('#input_lexile').val(), input_firstname: $('#input_firstname').val(), input_lastname: $('#input_lastname').val(), input_pages: $('#input_pages').val(), input_topic: $('#input_topic').val(), input_prot_feat: $('#input_prot_feat').val(), input_prot_gender: $('#input_prot_gender').val(), input_title: $('#input_title').val(), input_copyright: $('#input_copyright').val() } );

  //alerts the results
		  posting.done(function( data ) {
    //alert(data);
		  if(data) {
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
