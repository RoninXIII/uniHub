<?php

require_once('server.php');

$query = mysqli_query($connection,"CALL ")

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Aule</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 
</head>
<body>
    
<div class="container-fluid" id="contenitore">
    <div class="search">
      <span class="fa fa-search"></span>
      <input type="text" id="myInput" placeholder="Cerca l'utente desiderato...">
    </div>
    <table id="listaUtenti" class="table table-striped" style="background-color: #f5f5f6cc;">
      <tr style = "background-color:#314057; color:white"> 
        <td>Username</td>
        <td>Email</td>
        <td>Livello autorizzativo attuale</td>
        <td>Modifica</td>
        <td>Elimina utente</td>

      </tr>

 <ul><li></li></ul>
    </table> 
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">

$(document).ready(function () {


});


</script>
</body>
</html>