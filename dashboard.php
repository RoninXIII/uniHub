<?php
require_once(realpath(dirname(__FILE__)) . '/Utente.php');
require_once('server.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <link rel="stylesheet" href="aule.css">
</head>
<body>
    
<?php require_once('header.php'); ?>

<table class="table dashboard" id ="table1">
  <thead class="thead-dark">
    <tr><h2 align="center">Lista utenti</h2></tr>
    <tr >
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Livello autorizzativo</th>
      <th scope="col">Modifica livello</th>
      <th scope="col">Elimina</th>
    </tr>
  </thead>
  <tbody>
   
  </tbody>
</table>

<table class="table dashboard" id="table2">
  <thead class="thead-dark">
  <tr><h2 align="center">Reports</h2></tr>
    <tr >
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Data</th>
      <th scope="col">Utente</th>
      <th scope="col">Elimina</th>
    </tr>
  </thead>
  <tbody>
   
  </tbody>
</table>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="dashboard.js"> var username = "<?php echo $_SESSION['utente']->getUsername(); ?>";</script>
</body>
</html>