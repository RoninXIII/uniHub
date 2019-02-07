<?php
require_once(realpath(dirname(__FILE__)) . '/GestoreAccessi.php');
require_once(realpath(dirname(__FILE__)) . '/Utente.php');

$_SESSION['message'] = '';
 // Start the session


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
     <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 </head>
 
         
         <body class="text-center">
             
                 <form class="form-signin" method="post" >
                 <div class="js-tilt" data-tilt>
                         <img class="mb-4" src="LogoUnicam.png" alt="">
                  </div>
                   <h1 class="h3 mb-3 font-weight-normal">Effettua il login</h1>
                   <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                
                
                  <input id="inputUserName" name="usernameLogin" class="form-control" placeholder="Username" required="" autocomplete="true" autofocus="" type="username">
                 

                  <input id="inputPassword" name="passwordLogin" class="form-control" placeholder="Password" required="" type="password">
                   <div class="checkbox mb-3">
                   
                   </div>
                   <button class="btn btn-lg btn-primary btn-block" type="submit">Accedi</button>
                   <p class="mt-5 mb-3 text-muted">Copyright 2015-2018 @ Università degli Studi di Camerino</p>
                   <a href="Registration.php"><u> Non sei registrato? </u></a>
                 <!--  <p><a href="recoverPage.php"><u> Ti sei dimenticato la password? </u></a></p> -->
                 </form>
             

             
             </body>
     
 
</html>
