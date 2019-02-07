<?php
require_once("server.php");
$email= $_GET['email'];
$hash = $_GET['hash'];

//(username,email,password,livello,verCode,preferenze,operazione)
if($query = mysqli_query($connection, "CALL su_modify_utente('','$email','','','$hash','','')")){
    mysqli_next_result($connection);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification Page</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="jumbotron">
    <div class="container container-fluid" align="center">
    <p align="center"><img src="LogoUnicam.png" alt=""> </p>
    <h4>Sei stato verificato!</h4>
    <a href="Login.php">Vai alla pagina di Login</a>
    </div>
    </div>
</body>
</html>

<?php
 }else {die('Errore nella query: '.mysqli_error($connection));}

mysqli_close($connection);

?>


                              