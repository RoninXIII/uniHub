<?php
require_once(realpath(dirname(__FILE__)) . '/Utente.php');

require_once('server.php');



if(!isset($_SESSION["username"])){
    header("Location: Login.php");
    exit(); 
}else if(!isset($_SESSION["utente"])){
    $param = $_SESSION['username'];
    if($query=mysqli_query($connection,"call su_select_utenti('$param','','')")){
 
    $result = mysqli_fetch_assoc($query);
           //Refresh è un array che indica se il sistema automatico di refreshing è attivo o meno e qual è il valore dell'intervallo
        //di quest'ultimo
        $refresh = array();   
        $refresh[]  = array('Refresh' =>$result['Refresh'] , 'Intervallo' => $result['Intervallo'] );
    $_SESSION['utente'] = new Utente($result['Username'],$result['Email'],$result['Preferenze'],$result['LivelloAutorizzativo'],$refresh);
   
    }else{
        die("Errore: ".mysqli_error($connection));
    }
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />  
</head>
<body >
    <div >
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
                                    <input class="search_input" id="searchbar"  type="text" name="" placeholder="Cerca...">
                                        <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                                </div>
                             </div>
                            </div>
                      </div>
               
                          <table class="table table-inbox table-hover">
                    <tbody>
                        <tr class="titles">
                            <td>#</td>
                            <td>Proprietario</td>
                            <td>Titolo</td>
                            <td>Tags</td>
                            <td>Allegati</td>
                            <td>Data pubblicazione</td>
<?php if($_SESSION['utente'] ->getLivello() == 3 ){?> <td>&ensp;Elimina</td> <?php }?>
                        </tr>
                    </tbody>
                          </table>
                        
                      </div>
                  </aside>
              </div>
</div>


<?php if($_SESSION['utente'] ->getLivello() != 0 ){?>
    <div class="postArea" align = "center">

<!-- Button trigger modal -->
<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
<span class="fas fa-pen-alt" aria-hidden="true"></span>&ensp;POSTA NOTIZIA

</button>
</div>



<!-- Modal per postare la notizia -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"  role="document">
    <div class="modal-content" id="modalPostaNotizia">
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
                    <div class="container">
    
      </div> <!-- Fine modal per postare la notizia -->
      <div class="modal-footer">
        <button type="button" id="buttonPosta"  class="btn btn-primary">Posta&ensp;<span class="fas fa-thumbs-up" aria-hidden="true"></span></button>

  
      </div>
    </div>
  </div>
</div>


    
</div>
<?php } ?>


   
     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/it.js"></script>
<script>
      var utente = "<?php echo $_SESSION['utente']->getUsername(); ?>";
      var livello = "<?php echo $_SESSION['utente']->getLivello(); ?>";
      var preferenze = "<?php echo $_SESSION['utente']->getPreferences(); ?> ";
      
 
</script>
<script type="text/javascript" src="index.js"></script>
 
</body>
</html>