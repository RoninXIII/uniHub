<?php
require_once('server.php');

if($queryNotizie = mysqli_query($connection, "CALL su_select_notizie()")){
$notizie = array();
    while($row = mysqli_fetch_assoc($queryNotizie)){
$notizie[] = array("Cod" => $row['Cod'], "Oggetto" => $row['Nome'], "Contenuto" => $row['Descrizione'], "Tags" => $row['Tags'],
"Data_pubblicazione" => $row['DataPubblicazione'],"Appello" => $row['Appello'],"Aula" => $row['Aula'],"Ora" => $row['Ora'],
"Mittente" => $row['Utente']);
    }
  

    echo json_encode($notizie);
}

mysqli_close($connection);

?>