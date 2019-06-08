
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Register page</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" href="Login.css">
    </head>
<body >
  

<div class="container">
            <form class="form-horizontal" role="form">
                <h3 align="center">Registrati!</h3>
                <img src="LogoUnicam.png" alt="" class="mb-4" >
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email* </label>
                    <div class="col-sm-9">
                        <input type="email" id="email" placeholder="Email" class="form-control" name= "email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password*</label>
                    <div class="col-sm-9">
                        <input type="password" id="password" placeholder="Password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmpassword" class="col-sm-3 control-label">Conferma Password*</label>
                    <div class="col-sm-9">
                        <input type="password" id="confirmpassword" placeholder="Password" class="form-control">
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="control-label col-sm-3">*Sono:</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="livello" id="studente" value="0">Studente
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="livello" id="personale" value="1">Personale d'ufficio
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="livello" id="professore" value="2">Professore
                                </label>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.form-group -->
            
                <button type="submit" class="btn btn-primary btn-block" id="register">Registrati</button><br>
                <p>
  	    	Sei già registrato? <a href="Login.php">Effetua il log in</a>
  	    </p>
            </form> <!-- /form -->
            
        </div> <!-- ./container -->
    
	



<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">

$(document).ready(function(){

$("#register").on("click", function(e){
e.preventDefault();


var email           = document.getElementById('email').value;
var username = email.substr(0,email.indexOf('@'));
var password        = document.getElementById('password').value;
var confirmpassword = document.getElementById('confirmpassword').value;
var livello = $(':checked').val();

if(username =='' || email=='' || password=='' || confirmpassword==''){
    //$('#registerUser_div').append('<h4><em>Tutti i campi sono obbligatori!!!</em></h4>');
   alert("Tutti i campi sono obbligatori!");
    return;
}
if(password != confirmpassword){
    alert("Le due password non combaciano!");
    return;
}
$.ajax({
    url: "./registrationOperations.php",
    type: "post",
    data: {username: username, email: email, password: password, confirmpassword: confirmpassword,Livello:livello },

    success: function(data){
       var dataParsed = JSON.parse(data);
       alert(dataParsed);
    }
});


});
});





</script>
</body>
</html>