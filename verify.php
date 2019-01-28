<?php
require_once("server.php");
$email= $_GET['email'];
$hash = $_GET['hash'];
if($query = mysqli_query($connection, "CALL su_modify_utente('$email','$hash')")){
    mysqli_next_result($connection);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification Page</title>
 
</head>
<body>
<div class="jumbotron">
    <div class="container container-fluid" align="center">
    <p align="center"><img src="LogoUnicam.png" alt=""> </p>
    <h4>Sei stato verificato!</h4>
    <a href="LoginPage.php">Vai alla pagina di Login</a>
    </div>
    </div>
</body>
</html>

<?php
 }else {die('Errore nella query: '.mysqli_error($connection));}

mysqli_close($connection);

?>


                              