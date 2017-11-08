var prev_search = [];

function updateSearch(){
	//first I will check to make sure the input is correct 

	var errors = [];
/*
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
*/
	if(errors.length > 0){
		alert("The following fields are incomplete/incorrect: " + errors);
	} else {
		//at this point we know it is valid data so we will save it so it can be used on the next search
		setTimeout(function(){ 
			prev_search.push(document.getElementById("topic").value);
			prev_search.push(document.getElementById("protag1").value);
			prev_search.push(document.getElementById("protag2").value);
			prev_search.push(document.getElementById("protag3").value);
			prev_search.push(document.getElementById("copyright").value);
			prev_search.push(document.getElementById("lexile").value);
			prev_search.push(document.getElementById("pages").value); }, 3000);

		console.log("Previous Search Criteria: " + prev_search);

	}
}

function classSearch(){
	document.getElementById("test").innerHTML = "TEST TEST";
	document.getElementById("search_results").innerHTML += "<div class=\"col-md-7\" id=\"book_entry\" style=\"border-color: black;\"><div class=\"col-md-3\"><p class=\"search_text\"> Insert photo here </p></div><div class=\"col-md-3\"><p class=\"search_text\"> Book Title </p><p class=\"search_text\"> Author </p><p class=\"search_text\"> Copyright </p></div><div class=\"col-md-3 text-right\"><p class=\"search_text\"> protag1 </p><p class=\"search_text\"> protag2 </p><p class=\"search_text\"> protag3 </p></div></div>";
}