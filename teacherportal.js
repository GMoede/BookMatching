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
			//add book to database (AJAX call to php file)
		}
}
