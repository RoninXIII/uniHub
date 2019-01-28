<?php
require_once(realpath(dirname(__FILE__)) . '/Utente.php');

require_once('server.php');

var_dump($_SESSION['gestoreAccessi']);

if(!isset($_SESSION["username"])){
    header("Location: Login.php");
    exit(); 
}
if(isset($_SESSION['username'])){
    $_SESSION['utente'] = new Utente();
    $_SESSION['utente'] ->setUsername($_SESSION['username']);
    var_dump($_SESSION['utente']);

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 
</head>
<body>
<?php require_once('header.php'); ?>
    <div><h4><strong>Benvenuto nel tuo hub <?php echo $_SESSION['username'] ?></strong></h4></div>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>