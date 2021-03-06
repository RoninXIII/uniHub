<?php
require_once(realpath(dirname(__FILE__)) . '/Utente.php');
require_once('server.php');


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Aule</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> 
 <link rel="stylesheet" href="aule.css">
</head>
<body>
    
<?php require_once('header.php'); ?>


<table class="table searchTable" >
  <tr class="searchRow">
    <td>
         <label for="polo">Polo:</label>
      <select class="form-control" id="polo">
       
      </select>
    </td>
    <td>   
      <label for="dataAppello">Data prenotazione:</label>
      <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
        <input type="text" id="dataAppello" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
          <div class="input-group-text">
            <i class="fa fa-calendar"></i>
          </div>
        </div>
      </div>
    </td>
    <td>
      <label for="durata">Durata prenotazione:</label><br>
       <select class="form-control" id="durata"><option value="1">1 ora</option><option value="2">2 ore</option><option value="3">3 ore</option><option value="4">4 ore</option></select> 
      </td>
  </tr>
  
</table>
<hr>
<div align="center" class="buttonSearch">
<button type="button" id="search" class="btn btn-outline-success">Cerca!</button>
</div>
<br>

<table class="table prenotazioni">
  
</table>

<table class="table aule">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Polo</th>
      <th scope="col">Locazione</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>
<hr><div class="aggiungiAula" align="center">
    <br><input id="nomeAula" class="form-control" type="text" placeholder="Aula"> - <input id="poloAula" class="form-control" type="text" placeholder="Polo"> - <input id="locazioneAula" type="text" class="form-control" placeholder="Locazione">
    <br><br><button type="button" id="buttonAggiungiAula" class="btn btn-outline-success">
    <span class="fas fa-arrow-up"></span>&ensp;Aggiungi!&ensp;<span class="fas fa-arrow-up"></span></button></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/it.js"></script>
<script> var utente = "<?php echo $_SESSION['utente']->getUsername(); ?>";
         var livello = "<?php echo $_SESSION['utente']->getLivello(); ?>"; 
</script>
<script type="text/javascript" src="aule.js"></script>

</body>
</html>