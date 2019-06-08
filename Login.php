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
    
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" media="screen" href="Login.css" />
 </head>
 
         
         <body >
         <div class="container">
            <form class="form-horizontal" method="post">
                <h3 align="center">Effettua il login!</h3>

                <img src="LogoUnicam.png" alt="" class="mb-4" >
                <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
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
            </form> <!-- /form -->
            
        </div> <!-- ./container -->
          
   

             
             </body>
     
 
</html>
