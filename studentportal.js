var prev_search = [];

function update(){
	//first I will check to make sure the input is correct 

	var errors = [];

	if(document.getElementById("input_firstname").value === ""){
		errors.push("Author First Name");
	}
	if(document.getElementById("input_lastname").value === ""){
		errors.push("Author Last Name");
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
	} else {
		//at this point we know it is valid data so we will save it so it can be used on the next search
		  url = "application.php"


  //send data using post with element id lexile
		  var posting = $.post( url, { input_lexile: $('#input_lexile').val(), input_firstname: $('#input_firstname').val(), input_lastname: $('#input_lastname').val(), input_pages: $('#input_pages').val(), input_topic: $('#input_topic').val(), input_prot_feat: $('#input_prot_feat').val(), input_prot_gender: $('#input_prot_gender').val() } );

  //alerts the results
		  posting.done(function( data ) {
    //alert(data);
		  if(data) {
		    $('#search_results').html(data);
		  }
		  else{
		    alert('failure');
		  }
		  });

	}
}

function classSearch(){
	//document.getElementById("test").innerHTML = "TEST TEST";
	document.getElementById("search_results").innerHTML += "<div class=\"col-md-7\" id=\"book_entry\" style=\"border-color: black;\"><div class=\"col-md-3\"><p class=\"search_text\"> Insert photo here </p></div><div class=\"col-md-3\"><p class=\"search_text\"> Book Title </p><p class=\"search_text\"> Author </p><p class=\"search_text\"> Copyright </p></div><div class=\"col-md-3 text-right\"><p class=\"search_text\"> protag1 </p><p class=\"search_text\"> protag2 </p><p class=\"search_text\"> protag3 </p></div></div> <br>";
}


