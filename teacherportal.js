function verifyInputs(){
		var errors = [];
		if (document.getElementById("title").value === ""){
			errors.push("Title");
		}
		if(document.getElementById("first_name").value === ""){
			errors.push("Author First Name");
		}
		if(document.getElementById("last_name").value === ""){
			errors.push("Author Last Name");
		}
		if(document.getElementById("copyright").value === "" || document.getElementById("copyright").value.length < 4 || document.getElementById("copyright").value.length >= 5 || isNaN(document.getElementById("copyright").value)){
			errors.push("Copyright");
		}
		if(document.getElementById("lexile").value === ""){
			errors.push("Lexile");
		}
		if(document.getElementById("pages").value === "" || isNaN(document.getElementById("pages").value)){
			errors.push("Page Count");
		}
		//checking lexile validity
		var lexile = document.getElementById("lexile").value;
		lexile.replace(/L/g, ''); 
		if(isNaN(lexile) && errors.indexOf("Lexile") < 0){
			errors.push("Lexile");
		}
		if(errors.length > 0){
			alert("The following fields are incomplete/incorrect: " + errors);
		}
}