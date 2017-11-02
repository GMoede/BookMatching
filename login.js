document.onload = function(){
  //document.getElementById("form").onsubmit = function()
    var password = document.getElementById("password");
    password.value = md5(password);
};
  /*if (username == "Formget" && password == "formget123"){
    alert ("Login successfully");
    window.location = "success.html"; //Redirecting to other page
    return false;
  }
  else{
    alert ("Wrong username/password");
    return false;
  }
  */