<?php
require_once(realpath(dirname(__FILE__)) . '/GestoreAccessi.php');
require_once(realpath(dirname(__FILE__)) . '/Utente.php');

$_SESSION['message'] = '';


//Ogni volta che si accede a questa pagina si crea un'istanza di GestoreAccessi.
//Successivamente, una volta inviati i dati della form, si controllano le credenziali
//tramite la chiamata al metodo login() appartenente al suddetto.
if(!isset($_SESSION['gestoreAccessi'])){
    $_SESSION['gestoreAccessi'] = new GestoreAccessi();
}else{
    $_SESSION['gestoreAccessi']->login();
}




 ?>
 <html>
 <head>
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Login page</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" media="screen" href="Login.css" />
 </head>
 
         
         <body >
      <!--   <div class="container">
            <form class="form-horizontal" method="post">
                <h3 align="center">Effettua il login!</h3>

                <img src="LogoUnicam.png" alt="" class="mb-4" >
              
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="username" id="inputUserName" placeholder="Es. nome.cognome" class="form-control" name= "usernameLogin" autocomplete="true" required  autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" id="inputPassword" placeholder="Password" name="passwordLogin" class="form-control" required autofocus>
                    </div>
                </div><br>
           
              
            
                <button type="submit" class="btn btn-outline-dark btn-block">Accedi</button><br>
                <p class="mt-5 mb-3 text-muted">Copyright 2015-2018 @ Università degli Studi di Camerino</p>
                   <a href="Registration.php"><u> Non sei registrato? </u></a>
            </form> 
            
        </div> -->
   


<div class="container">
	<div class="row">
		
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
  <h1 align="center">Benvenuto in UniHub!</h1>
</div>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
    <div class="alert-error" align="center" style="color:red"><?php echo $_SESSION['message'] ?></div>
    <form class="form-horizontal" style="margin-top: 20px;" method="post">
      <div class="input-container">
      <input type="username" id="inputUserName"  class="form-control" name= "usernameLogin" autocomplete="true" required  autofocus>
        <label for="Username">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
      <input type="password" id="inputPassword"  name="passwordLogin" class="form-control" required autofocus>
        <label for="Password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button><span class="fas fa-dungeon">&ensp;Accedi</span>&ensp;<span class="fas fa-dungeon"></span></button>
      </div>

    </form>
  </div>
  <div class="card alt">
    <div class="toggle"><span class="fas fa-user-plus"></span></div>
    <h1 class="title">Registrati!
      <div class="close"></div>
    </h1>
    <form>
      <div class="input-container">
      <input type="email" id="email" class="form-control" name= "email">
        <label for="email">Email</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
      <input type="password" id="password"  class="form-control">
        <label for="password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container" style="margin-bottom: 50px;">
      <input type="password" id="confirmpassword"  class="form-control">
        <label for="confirmpassword">Ripeti password</label>
        <div class="bar"></div>
      </div>
      <label class="control-label col-sm-3" style="color: white; font-size: large; top: -8px;left: 64px;" >*Sono:</label>
      <div class="col-sm-4" style="display: flex;left: 137px;">
     
        <label class="radio-inline">
            <input type="radio" name="livello" id="studente" value="0">Studente
        </label>&emsp;
     
      
        <label class="radio-inline">
            <input type="radio" name="livello" id="personale" value="1">Personale d'ufficio
        </label>&emsp;
     
      
        <label class="radio-inline">
            <input type="radio" name="livello" id="professore" value="2">Professore
        </label>
    </div>
      <div class="button-container">
        <button type="submit" id="register"><span class="fab fa-keycdn">&ensp;Registrati</span>&ensp;<span class="fab fa-keycdn"></span></button>
      </div>
    </form>
  </div>
</div>

	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.toggle').on('click', function() {
  $('.container').stop().addClass('active');
});

$('.close').on('click', function() {
  $('.container').stop().removeClass('active');
});


$("#register").on("click", function(e){
e.preventDefault();


var email           = document.getElementById('email').value;
var username = email.substr(0,email.indexOf('@'));

if(email.includes('unicam') == false){
    alert("L'email selezionata non può essere registrata nel sistema!")
    return;
}

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
