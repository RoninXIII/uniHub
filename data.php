<?php
require_once('server.php');

if(isset($_POST['Notizie'])){

if($queryNotizie = mysqli_query($connection, "CALL su_select_notizie()")){
$notizie = array();
    while($row = mysqli_fetch_assoc($queryNotizie)){
$notizie[] = array("Cod" => $row['Cod'], "Oggetto" => $row['Nome'], "Contenuto" => $row['Descrizione'], "Tags" => $row['Tags'],
"Data_pubblicazione" => date('d-m-Y H:i:s',strtotime($row['DataPubblicazione'])),"Appello" => $row['Appello'],"Aula" => $row['Aula'],"Ora" => $row['Ora'],
"Mittente" => $row['Utente']);
    }
  

    echo json_encode($notizie);
}else echo json_encode("Errore: ".mysqli_error($connection));
}elseif (isset($_POST['Aule'])) {

    if($queryAule = mysqli_query($connection,"CALL su_select_aule()")){
$aule = array();
while($row = mysqli_fetch_assoc($queryAule)){
    $aule[] = array("cod" =>$row['Cod'], "nome" =>$row['Nome'], "polo" =>$row['Polo'], "locazione" =>$row['Locazione'],"prenotata" => $row['Prenotata']);
}

echo json_encode($aule);
    }
}


mysqli_close($connection);

?>