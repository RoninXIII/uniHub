<?php

require_once('server.php');

if(isset($_POST['Titolo']) && isset($_POST['Contenuto']) && isset($_POST['Utente'])){
    $codNotizia = $_POST['CodNotizia'];
    $titolo = $_POST['Titolo']; 
    $contenuto = $_POST['Contenuto'];
    $utente = $_POST['Utente'];
    $tags = implode(',',$_POST['Tags']);
    
    if($query = mysqli_query($connection, "CALL su_insert_notizia('$codNotizia','$titolo','$contenuto','$tags','$utente')")){
        echo json_encode("Notizia postata correttamente!");
    }else echo json_encode("Errore: ".mysqli_error($connection));
}

mysqli_close($connection);
?>