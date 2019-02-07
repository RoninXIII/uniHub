<?php 
require_once(realpath(dirname(__FILE__)) . '/Utente.php');
require_once("server.php");
//print_r($_SESSION['utente']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<?php require_once('header.php'); ?>



<!--Comparirà il nome dell'utente loggato.-->
<h2 align="center">Account di <?php echo $_SESSION['utente']->getUsername(); ?> </h2>

</br></br>

<form>

  <div class="form-group" style="margin-top: -30;">
    <div id="pswdChange_div">
      <div id ="password_message"></div>
      <h2>Modifica  password</h2>

      <label for="new-password">Inserisci la nuova password</label></br>
      <input type="password" name="new-password" id="new-password" class="form-control" autofocus="on"  /></br>

      <label for="repeat-new-password">Ripeti la nuova password</label></br>
      <input type="password" name="repeat-new-password" id="repeat-new-password" class="form-control" autofocus="on" /></br>
      <button type="button"  id="buttonChangePassword" class="btn btn-success" />Cambia password</button></br>
    </div>
  
  </div>
  <hr />

  <div class="form-group">
    <div id="deleteAccount_div">
      <h2>Elimina l'account</h2>
      <div id="delete_message"><h4 style ="color:red;">ATTENZIONE! L'effetto sarà immediato</h4></div>
      <button type="button"  id="delete-account-submit"  class="btn btn-danger" >Elimina account </button>
    </div>
  </div>
  <hr />
  <div class="form-group">
    <div id="modificaPreferenze_div">
      <div id ="modificaPreferenze_message"></div>
      <label for="emailChange"><h2>Modifica preferenze</h2></br><h6>(inserire le preferenze separate da una virgola)</h6></label></br>
      <input type="text"   name="preferenze[]" class="form-control" autofocus="on" autocomplete="on" value="<?php  echo $_SESSION['utente'] ->getPreferences(); ?>"/></br>
      <button  type="button" class="btn btn-success"  id="buttonChangePreferenze"  >Modifica</button>

    </div>
  </div>

</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">

$(document).ready(function(){

var username = "<?php echo $_SESSION['utente']->getUsername(); ?>";

var email = "<?php echo $_SESSION['utente']->getEmail() ?>";




$("#pswdChange_div").on('click','#buttonChangePassword', function(e){
  e.preventDefault();

  var newPassword = document.getElementById('new-password').value;

  var repeatNewPassword = document.getElementById('repeat-new-password').value;

  if(newPassword != repeatNewPassword){
    $('#password_message').html('<h4 style="color:red"><i>Le due password non combaciano!</i></h4>');
    return;
  }

var verify = '';
switch (verify) {

case newPassword:
$('#password_message').html('<h4 style="color:red"><i>Nuova password richiesta!</i></h4>');
return;

case repeatNewPassword:
$('#password_message').html('<h4 style="color:red"><i>Ripetizione nuova password richiesta!</i></h4>');
return;

  
}

$.ajax({
  url: "./cambioCredenzialiUtente.php",
  type: "post",
  data:{Username:username, EmailPassword: email, newPassword: newPassword},
  success: function(data){
  var dataParsed = JSON.parse(data);
  if(dataParsed == 'Password modificata!'){
    $('#password_message').html('<h4 style="color:green"><i>Password modificata con successo!</i><h4>');
  }else{
    $('#password_message').html('<h4 style="color:red"><i>Errore: '+dataParsed+'. Eventuali email dovranno essere ignorate!</i></h4>');
  }

  }

  
});


});



$("#modificaPreferenze_div").on('click','#buttonChangePreferenze', function(e){
  e.preventDefault();

//Prendiamo la stringa inserita  dall'utente, la si divide in sottostringhe (prendendo un delimitatore come parametro)
//e si crea un array composto dalle suddette sottostringhe.
  var preferenze = document.getElementsByName('preferenze[]')[0].value.trim().split(',');
  



$.ajax({
  url: "./cambioCredenzialiUtente.php",
  type: "post",
  data:{Username:username, Preferenze:preferenze},
  success: function(data){
  var dataParsed = JSON.parse(data);
  if(dataParsed == 'Preferenze modificate!'){
    
    $('#modificaPreferenze_message').html('<h4 style="color:green"><i>'+dataParsed+'</i><h4>');
  }else{
    $('#modificaPreferenze_message').html('<h4 style="color:red"><i>Errore: '+dataParsed+'. Eventuali email dovranno essere ignorate!</i></h4>');
  }

  }

  
});


});


$("#deleteAccount_div").on('click','#delete-account-submit', function(e){
e.preventDefault();

var c = confirm("Sei sicuro di voler eliminare il tuo account? La scelta sarà permanente!");

if(c == false || c == null){ console.log('Operazione annullata!'); return;} 

$.ajax({
  url: "./cambioCredenzialiUtente.php",
  type: "post",
  data:{Username:username, Email: email},
  success: function(data){
    var dataParsed = JSON.parse(data);
console.log(dataParsed);
    if(dataParsed == 'Utente eliminato correttamente!'){
      $('#delete_message').html('<h4 style="color:green;"><i>Account eliminato! Registrati <a href="Registration.php">qui</a> per accedere nuovamente al sito!</i></h4>');
    }else{
      $('#delete_message').html('<h4 style="color:red;"><i>Errore: '+dataParsed+'</i></h4>');
    }
  }


});
});
});

</script>  
</body>
</html>