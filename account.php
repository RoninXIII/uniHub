<?php 
require_once(realpath(dirname(__FILE__)) . '/Utente.php');
require_once("server.php");



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
  <style>#report_modal_button:hover{
    cursor: pointer;
    color:blue;
    text-decoration: underline;
  }
  h2{
    
    border-radius: 2.3em;
  }
  div{
    word-wrap: break-word ;
  }
  .fas.fa-arrow-circle-down{
    background-color: whitesmoke;
    border-radius: 30px;
    color: #1c6a95;
    cursor: pointer;
    
  }
  .fas.fa-arrow-circle-down:hover{
    background-color: #11d411;
  }
  .tagDiv{
    border-block-color: black;

  border-style: solid;

  border-width: 1px;
  }
  </style>
</head>
<body class="text-center">
<?php require_once('header.php'); ?>



<div class="container">
	<div class="row bg-dark mb-4 my-4 text-white">
		<h2 >Modifica le tue impostazioni</h2>
	</div>
	
	<div class="row">
	    <!-- side nav-->
	    <aside class="col-sm-6 col-md-3 card  my-4">
	        <h3>UniHub</h3>
	        <hr/>
	        <ul>
	            <li>
	                
    	            <span class="fas fa-cogs"></span>
    	              Impostazioni generali
                <ul>
                 <li>
                   
                   <a href="#refresh_div">
                     <span class="fas fa-sync-alt"></span> Refreshing
                    </a>
                  </li>
                </ul>
              </li>
              
	            <li> 
	                
    	          <span class="fas fa-user-shield"></span>
                  Account settings
                <ul>
                <li>
                  <a href="#pswdChange_div">
                    <span class="fas fa-key"></span> Password 
                  </a>
                </li>
                <li>
                  <a href="#deleteAccount_div">
                    <span class="fas fa-user-minus"></span> Elimina &ensp;
                  </a>
                </li>
                 <li>
                  <a href="#modificaPreferenze_div">
                    <span class="fas fa-user-tag"></span> Tags &emsp;&ensp;
                  </a>
                </li>
                </ul>
              </li>
              <li>
                <a href="#report_div"><span class="fas fa-bug"></span> Report bug</a>
              </li>
	        </ul>
	    </aside>
	    
	    <section class="col-sm-6 col-md-8 offset-md-1" id="main-content">
	

      <form>

<div class="form-group" style="margin-top: -30;">
  <div id="pswdChange_div">
    <div id ="password_message"></div>
    <h2>Modifica  password</h2>

    <label for="new-password">Inserisci la nuova password</label></br>
    <input type="password" name="new-password" id="new-password" class="form-control" autofocus="on"  /></br>

    <label for="repeat-new-password">Ripeti la nuova password</label></br>
    <input type="password" name="repeat-new-password" id="repeat-new-password" class="form-control" autofocus="on" /></br>
    <button type="button"  id="buttonChangePassword" class="btn btn-outline-success" >Cambia password</button></br>
  </div>

</div>
<hr />

<div class="form-group">
  <div id="deleteAccount_div">
    <h2>Elimina l'account</h2>
    <div id="delete_message"><h4 style ="color:red;">ATTENZIONE! L'effetto sarà immediato</h4></div>
    <button type="button"  id="delete-account-submit"  class="btn btn-outline-danger" >Elimina account </button>
  </div>
</div>
<hr />
<div class="form-group">
  <div id="modificaPreferenze_div">
    <div id ="modificaPreferenze_message"></div>
    <label for="emailChange"><h2>Modifica preferenze</h2></br></label></br>
   <div> <select class="form-control" name="selectPreferenze" id="selectPreferenze"></select><br><span class="fas fa-arrow-circle-down fa-3x" id="addTag"></span><br><br>
   <div class="tagDiv" ><strong id="preferenzeUtente"><?php  echo $_SESSION['utente'] ->getPreferences(); ?></strong></div><br>
   
    <button  type="button" class="btn btn-outline-success"  id="buttonChangePreferenze"  >Salva!</button>&emsp;
    <button type="button" class="btn btn-outline-danger" id ="deletePreferenze">Pulisci!</button>
  </div>
</div>

<hr/>
<div class="form-group">
  <div id="refresh_div">
    <h2>Sistema automatico di refreshing</h2>
    <div id="refresh_message"><h4>Scegli se impostare o meno l'aggiornamento automatico delle notizie</h4></div>
    <button type="button"   class="btn btn-outline-primary" data-toggle="modal" data-target="#refresh_modal" >Modifica</button>
    
  </div>
</div>
<!-- Modal -->
<div id="refresh_modal" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">Refreshing</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
     
    </div>
    <div class="modal-body">
     <label for="intervallo">Ogni quanto vuoi caricare le notizie?</label>
     <select class="form-control" name="intervallo" id="intervallo"><option value="3">3 secondi</option><option value="5">5 secondi</option><option value="10">10 secondi</option></select>
    </div>
    <div class="modal-footer">
      <button type="button" id="refresh_button" ></button>
   
    </div>
  </div>

</div>
</div>
<hr/>
<div class="form-group">
  <div id="report_div">
 
    <div id="report_message"><h4>Hai rilevato un bug? <h5 id="report_modal_button" data-toggle="modal" data-target="#report_modal"><span class="fas fa-bug"></span> Segnalacelo!</h5></h4></div>

    
  </div>
</div>
<!-- Modal -->
<div id="report_modal" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">Segnalazione bug</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
     
    </div>
    <div class="modal-body">
    <input type="text" id="titolo" class="form-control" placeholder="Titolo" required><br>
     <textarea class="form-control" name="bug" id="bug" cols="48" rows="10" placeholder="Descrivi il problema (max 1500 char)" required></textarea>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-success" id="report_button" >Invia</button>
   
    </div>
  </div>

</div>
</div>

</form>
	    </section>
	
	</div>







<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">

$(document).ready(function(){

var username = "<?php echo $_SESSION['utente']->getUsername(); ?>";

var email = "<?php echo $_SESSION['utente']->getEmail(); ?>";

var refresh =[<?php echo $_SESSION['utente']-> getRefresh()[0]['Refresh']; ?>,"<?php echo $_SESSION['utente']-> getRefresh()[0]['Intervallo'];  ?>"];



$.ajax({
  type: "post",
  url: "data.php",
  data: {Account:"0"},
  dataType: "json",
  success: function (data) {
    
    $.each(data, function (index) { 

      $("#selectPreferenze").append('<option value="'+data[index].nome+'">'+data[index].nome+'</option>');

    });
  }
});

$(document).on("click","#addTag", function (e) { 
 
  var tag = $(document).find('select#selectPreferenze :selected').attr('value');
  var contenuto = $(".tagDiv>strong").html();
  if(contenuto == ""){
    $(".tagDiv>strong").append(tag+'');
  }else{
    $(".tagDiv>strong").append(','+tag+'');
  }

  
  
});

if(refresh[0] == 0){
  $("#refresh_button").addClass("btn btn-outline-success");
  $("#refresh_button").html("Attiva");

 
}else{
  $("#refresh_modal .modal-body").html('Intervallo impostato: '+refresh[0]['Intervallo']+' secondi');
  $("#refresh_button").addClass("btn btn-outline-danger");
  $("#refresh_button").html("Disattiva");
}

$("#refresh_modal").on('click','#refresh_button', function(e){

if(refresh[0] == 0){

refresh[0] =1;

}else {

  refresh[0] = 0;

}

var Intervallo = $(document).find('select#intervallo :selected').attr('value');

  $.ajax({
    type: "post",
    url: "update.php",
    data: {Username:username,Refresh:refresh[0], Intervallo:Intervallo},
    success: function (data) {
var dataParsed = JSON.parse(data);

      if(dataParsed == "OK!" && refresh[0] == 1){
   
  $("#refresh_modal .modal-body").html('Intervallo impostato: '+Intervallo+' secondi');
  $("#refresh_button").removeClass("btn btn-outline-success").addClass("btn btn-outline-danger");
  $("#refresh_button").html("Disattiva");
      }else if(dataParsed == "OK!" && refresh[0] == 0){

        
   $("#refresh_modal .modal-body").html('<label for="intervallo">Ogni quanto vuoi caricare le notizie?</label>'+
       '<select class="form-control" name="intervallo" id="intervallo"><option value="3">3 secondi</option><option value="5">5 secondi</option><option value="10">10 secondi</option></select>');
   $("#refresh_button").removeClass("btn btn-outline-danger").addClass("btn btn-outline-success");
  $("#refresh_button").html("Attiva");
      }else alert(dataParsed);
    }
  });
 
 

});




$("#report_modal ").on('click','#report_button', function(e){

var titolo = $("#report_modal #titolo").val();
var testo = $("#report_modal #bug").val();
$.ajax({
  type: "POST",
  url: "insert.php",
  data: {Titolo:titolo,Bug:testo,Utente:username},
  success: function (data) {
    var dataParsed = JSON.parse(data);

    alert(dataParsed);

  }
});

});


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

  var preferenze = $('#preferenzeUtente').html().split(',');
  

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



$("#modificaPreferenze_div").on('click','#deletePreferenze', function(e){
e.preventDefault();

$.ajax({
  type: "post",
  url: "delete.php",
  data: {DeletePreferenze:"0",Utente:username},
  
  success: function (data) {
    var dataParsed = JSON.parse(data);

    if(dataParsed == "Eliminazione effettuata!"){

      $(".tagDiv>strong").html('');
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