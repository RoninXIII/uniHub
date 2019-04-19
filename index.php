<?php
require_once(realpath(dirname(__FILE__)) . '/Utente.php');

require_once('server.php');

//var_dump($_SESSION['gestoreAccessi']);


if(!isset($_SESSION["username"])){
    header("Location: Login.php");
    exit(); 
}else if(!isset($_SESSION["utente"])){
    $param = $_SESSION['username'];
    if($query=mysqli_query($connection,"call su_select_utenti('$param','','')")){
        mysqli_next_result($connection);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['utente'] = new Utente($result['Username'],$result['Email'],$result['Preferenze']);
    }else{
        die("Errore: ".mysqli_error($connection));
    }
}

if($queryMaxCodNotizia = mysqli_query($connection, "SELECT su_maxNotizia() AS maxNotizia;")){
    $maxCodNotizia= mysqli_fetch_assoc($queryMaxCodNotizia);

}else die("Errore: ".mysqli_error($connection));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 
</head>
<body ng-app="uniHub">
    <div ng-controller="notizieCtrl">
<?php require_once('header.php'); ?>
    <div><h4><strong>Benvenuto nel tuo hub <?php echo $_SESSION['username'] ?></strong></h4></div>

  
    
    <div class="container">

 <div class="mail-box">
               
                  <aside class="lg-side">
                      <div class="inbox-head">
                          <h3>Notizie postate</h3>
                          <div class="container h-100">
                             <div class="d-flex justify-content-center h-100">
                                <div class="searchbar">
                                    <input class="search_input" ng-model= "searchText" type="text" name="" placeholder="Carca...">
                                        <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                                </div>
                             </div>
                            </div>
                      </div>
               
                          <table class="table table-inbox table-hover">
                          <tbody>
                            
                              <tr class="unread" ng-repeat="notizia in notizie | filter:searchText" data-toggle="modal" data-target="#modal{{notizia.Cod}}">
                                
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message  mittente" >Mittente: {{notizia.Mittente}}</td>
                                  <td class="view-message ">Oggetto: {{notizia.Oggetto}}</td>
                                  <td class="view-message ">Tags: {{notizia.Tags}}</td>
                                  <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>
                                  <td class="view-message  text-right">Data pubblicazione: {{notizia.Data_pubblicazione}}</td>
    
                              </tr>
                            

                            
                          </tbody>
                          </table>
                          <div class="modal fade" ng-repeat="notizia2 in notizie" id="modal{{notizia2.Cod}}" tabindex="-1" role="dialog" aria-labelledby="titoloModal{{notizia2.Cod}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titoloModal{{notizia2.Cod}}">{{notizia2.Oggetto}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {{notizia2.Contenuto}}
      </div>
      <div class="modal-footer">
     eventuali allegati
      </div>
    </div>
  </div>
</div>
                      </div>
                  </aside>
              </div>
</div>



    <div align = "center">

<!-- Button trigger modal -->
<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
<span class="fas fa-pen-alt" aria-hidden="true"></span>&ensp;POSTA NOTIZIA

</button>
</div>



<!-- Modal per postare la notizia -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Posta una nuova notizia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="collapseOne" class="panel-collapse collapse show" style="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="v panel-group" id="accordion">
                <form>
                                        <input type="text" id="titolo" class="form-control" placeholder="Titolo" required>
                                    </form></div>
                                    <div class="form-group">
                                        <textarea id="contenuto" class="form-control" placeholder="Contenuto (max 1500 caratteri)" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Categoria</label>
                                        <select class="form-control" id="category">
                                            <option>Normale</option>
                                            <option>Appello</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tags">
                                            Tags</label>
                                        <input type="text" class="form-control" id="tags" placeholder="Tags">
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
      </div> <!-- Fine modal per postare la notizia -->
     <?php ?> <div class="modal-footer">
        <button type="button" id="buttonPosta"  class="btn btn-primary">Posta&ensp;<span class="fas fa-thumbs-up" aria-hidden="true"></span></button>

       <?php ?>
      </div>
    </div>
  </div>
</div>


    
</div>

   
               

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
   var fetch = angular.module('uniHub', []);

fetch.controller('notizieCtrl', ['$scope', '$http', function ($scope, $http) {
$http({
method: 'get',
url: 'data.php'
}).then(function successCallback(response) {
// Store response data
$scope.notizie = response.data;
});
}]);
$(document).ready(function(){


    var utente = "<?php echo $_SESSION['utente']->getUsername(); ?>";
    var wrapper = $(".table-inbox");
    var codNotizia = "<?php  if($maxCodNotizia != null) echo $maxCodNotizia['maxNotizia']+1; else echo 1; ?>";

  
    $("#buttonPosta").on("click", function(e){ 
        e.preventDefault();
        
        var titolo = $('#titolo').val();
        var contenuto = $('#contenuto').val();
        var tags = $('#tags').val().trim().split(",");
        var accesskey = $(this);
        var dataAttuale = "<?php echo date('d-m-Y H:i:s', time()); ?>";

        $.ajax({
            url: "./insert.php",
            type: "post",
            data: {CodNotizia:codNotizia,Titolo:titolo,Contenuto:contenuto,Utente:utente,Tags:tags},
            success: function (data) {
                var dataParsed = JSON.parse(data);

                if(dataParsed == "Notizia postata correttamente!"){
                    alert(dataParsed);
                    $(wrapper).append('<tr class="unread" data-toggle="modal" data-target="#modal"><td class="inbox-small-cells"><i class="fa fa-star"></i></td>'+
                                      '<td class="view-message  mittente">Mittente: '+utente+'</td>'+
                                      '<td class="view-message ">Oggetto '+titolo+'</td>'+
                                      '<td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>'+
                                      '<td class="view-message  text-right">Data pubblicazione: '+dataAttuale+'</td></tr>');
                                     
                    $('#exampleModalCenter').modal('hide');
                    codNotizia++;
                }else alert(dataParsed);
            }

        });
    });



    var contenutoModal = $('.modal-content').clone();
    $(document).on('change','#category',function(){
      
if(this.value == "Appello"){
    $(".modal-dialog").html('<div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Posta un appello</h5>'+
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>'+
        '<div class="modal-body"><div id="collapseOne" class="panel-collapse collapse show" style=""><div class="panel-body"><div class="row">'+
        '<div class="col-md-12"><div class="v panel-group" id="accordion"><form><input type="text" id="titolo" class="form-control" placeholder="Titolo" required="">'+
        '</form></div><div class="form-group"><textarea id="contenuto" class="form-control" placeholder="Contenuto (max 1500 caratteri)" rows="5" required=""></textarea>'+
        '</div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label for="category">Categoria</label>'+
        '<select class="form-control" id="category"><option>Appello</option><option>Notizia</option></select>'+
        '<br/><label for="aula">Aula</label><select class="form-control" id="aula"><option>LA1</option><option>LA2</option></select></div></div>'+
        '<div class="col-md-6"><div class="form-group"><label for="tags">Tags</label><input type="text" class="form-control" id="tags" placeholder="Tags"></div></div></div></div></div></div>'+
        '<div class="modal-footer"><button type="button" id="buttonPosta" class="btn btn-primary">Posta <span class="fas fa-thumbs-up" aria-hidden="true"></span></button></div></div>');
}
else {
    $(".modal-dialog").html(contenutoModal);
 
}
  });



 
});
</script>
</body>
</html>