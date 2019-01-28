<?php
session_start(); 


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Register page</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
<body class="text-center">
    <!--<div class="header">
  	    <h2></h2>
    </div>-->
    
	
	<form  method="post" enctype="multipart/form-data" autocomplete="on" class="form-signin">
        <img src="LogoUnicam.png" alt="" class="mb-4">
        <h1 class="h3 mb-3 font-weight-normal">Registrati</h1>  
        <div  id="registerUser_div"> </div>
        <div class="input-group">
            <label for="username" class="sr-only">Username</label>
            <input class="form-control" type="text" placeholder="Username" name="username" id="username" required />
            <label for="email" class="sr-only">Email</label>
            <input class="form-control" type="email" placeholder="Email" name="email" id="email" required />
        </div>
        <div class="input-group">
            <label for="password" class="sr-only">Password</label>
            <input class="form-control" type="password" placeholder="Password" required name="password" id="password" autocomplete="new-password" required />
            <label for="password" class="sr-only">Riconferma Password</label>
            <input class="form-control" type="password" placeholder="Confirm Password" required name="confirmpassword" id="confirmpassword" autocomplete="new-password" required />
		    <input  type="submit" value="Registrati" name="register" id="register" class="btn btn-lg btn-block btn-primary" />
        </div>
  	    <p>
  	    	Sei già registrato? <a href="LoginPage.php">Effetua il log in</a>
  	    </p>
    </form>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">

$(document).ready(function(){

$("#register").on("click", function(e){
e.preventDefault();


var username        = document.getElementById('username').value;
var email           = document.getElementById('email').value;
var password        = document.getElementById('password').value;
var confirmpassword = document.getElementById('confirmpassword').value;

if(username =='' || email=='' || password=='' || confirmpassword==''){
    //$('#registerUser_div').append('<h4><em>Tutti i campi sono obbligatori!!!</em></h4>');
    $('#registerUser_div').html('').html('<div class="alert alert-danger" role="alert"><em>Tutti i campi sono obbligatori!!!</em></div>');
    return;
}
if(password != confirmpassword){
    $('#registerUser_div').html('').html('<div class="alert alert-danger" role="alert"><em>Le due password non combaciano!!!</em></div>');
    return;
}
$.ajax({
    url: "./registrationOperations.php",
    type: "post",
    data: {username: username, email: email, password: password, confirmpassword: confirmpassword },

    success: function(data){
       var dataParsed = JSON.parse(data);
        if(dataParsed == "Utente registrato correttamente!"){
            $('#registerUser_div').html('').html('<div class="alert alert-success" role="alert"><em>Registrazione avvenuta con successo, controlla la tua email per verificarti.</em></div>');
        }else if(dataParsed == "L'email è già presente nel database!"){
            $('#registerUser_div').html('').html('<div class="alert alert-danger" role="alert"><em>Sei già registrato!</em></div>');
        }else if(dataParsed == "Username già presente!"){
            $('#registerUser_div').html('').html('<div class="alert alert-danger" role="alert"><em>Username già presente!</em></div>');
        }
        else{
            $('#registerUser_div').html('').html('<div class="alert alert-danger" role="alert"><em>C\'è stato un problema con la tua registrazione, verifica che le informazioni inserite siano corrette.</em></div>');
        }
    }
});


});
});





</script>
</body>
</html>