function hashPassword(){
    document.myform.password.value = md5(password.value);
    return true;
}
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
