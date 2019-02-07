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
<body>
<?php require_once('header.php'); ?>
    <div><h4><strong>Benvenuto nel tuo hub <?php echo $_SESSION['username'] ?></strong></h4></div>

                
    
     <ul id="lista-notizie" class="event-list">
     <?php
    if($queryNotizie = mysqli_query($connection, "CALL su_select_notizie()")){

    $countNotizie = $queryNotizie->num_rows;

    while($queryNotizieFetch = mysqli_fetch_assoc($queryNotizie)){

       $data= preg_split("/[\s-]+/", $queryNotizieFetch['DataPubblicazione']);
    
    ?>
					<li>
						<time datetime="<?php echo date('Y/m/d', time()); ?>">
							<span class="day"><?php echo $data[2]; ?></span>
							<span class="month"><?php echo $data[1]; ?></span>
							<span class="year"><?php echo $data[0]; ?></span>
						</time>
						<img alt="" src="unicam.jpg">
                        <a class="mostraNotizia" href="#" data-toggle="modal" data-target="#notizia<?php echo $queryNotizieFetch['Cod'] ?>" accesskey="<?php echo $queryNotizieFetch['Cod'] ?>">
						<div class="info">
                        <h4 class="title" style="color:red;"> <?php if($queryNotizieFetch['Utente'] == null) echo "Utente eliminato"; else echo $queryNotizieFetch['Utente']; ?></h4>
							<p class="desc"><?php echo $queryNotizieFetch['Nome'] ?></p>
						</div>
                        </a>
						<div class="social">
							<ul>
								<li style="width:33%;"><a href="#facebook"><span class="far fa-edit"></span></a></li>
	
							</ul>
						</div>
                    </li>
                    <!-- Modal per mostrare la notizia -->
                    <div class="modal fade" id="notizia<?php echo $queryNotizieFetch['Cod'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="titolo<?php echo $queryNotizieFetch['Cod'] ?>">OGGETTO: <?php echo $queryNotizieFetch['Nome'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                             <p> Descrizione: <i><?php echo $queryNotizieFetch['Descrizione'] ?> </i></p>
                                <hr>
                                Tags:
                                <?php echo $queryNotizieFetch['Tags'] ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                                </div>
                            </div>
                        </div>
                    </div>
    
                    
                    <?php } 
                } ?>		
				</ul>


                    
          <!--     </div>   
            </div> -->

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
      </div>
      <div class="modal-footer">
        <button type="button" id="buttonPosta"  class="btn btn-primary">Posta&ensp;<span class="fas fa-thumbs-up" aria-hidden="true"></span></button>
      </div>
    </div>
  </div>
</div>

       
               

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){

    var utente = "<?php echo $_SESSION['utente']->getUsername(); ?>";
    var wrapper = $("#lista-notizie");
    var codNotizia = "<?php  if($maxCodNotizia != null) echo $maxCodNotizia['maxNotizia']+1; else echo 1; ?>";
    $("#buttonPosta").on("click", function(e){ 
        e.preventDefault();
        
        var titolo = document.getElementById('titolo').value;
        var contenuto = document.getElementById('contenuto').value;
        var tags = document.getElementById('tags').value.trim().split(",");
  
        var dataAttuale = "<?php echo date('Y/m/d', time()); ?>"
       dataAttuale = dataAttuale.split('/');
        $.ajax({
            url: "./insert.php",
            type: "post",
            data: {CodNotizia:codNotizia,Titolo:titolo,Contenuto:contenuto,Utente:utente,Tags:tags},
            success: function (data) {
                var dataParsed = JSON.parse(data);

                if(dataParsed == "Notizia postata correttamente!"){
                    alert(dataParsed);
                    $(wrapper).append('<li><time datetime="'+dataAttuale+'">'+
						  '<span class="day">'+dataAttuale[2]+'</span><span class="month">'+dataAttuale[1]+'</span>'+
						  '<span class="year">'+dataAttuale[0]+'</span></time>'+
						  '<img alt="" src="unicam.jpg"><a class="mostraNotizia" href="#" data-toggle="modal" data-target="#notizia'+codNotizia+'" accesskey="'+codNotizia+'">'+
                          '<div class="info"><h4 class="title" style="color:red;">'+utente+'</h4>'+
						  '<p class="desc">'+titolo+'</p></div><div class="social">'+
						  '<ul><li style="width:33%;"><a href=""><span class="far fa-edit"></span></a></li></ul></div></li></ul>'+
                          '<!-- Modal per mostrare la notizia --><div class="modal fade" id="notizia'+codNotizia+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">'+
                          '<div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header">'+
                          '<h2 class="modal-title" id="titolo'+codNotizia+'" >'+titolo+'</h2><button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                          '<span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+contenuto+'</div>'+
                          '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
                          '</div></div></div></div>');
                    $('input[type="text"]').val('');
                    $('#exampleModalCenter').modal('hide');
                    codNotizia++;
                }else alert(dataParsed);
            }

        });
    });

 
});
</script>
</body>
</html>