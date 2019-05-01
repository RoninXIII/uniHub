<?php

require_once('server.php');

if(isset($_POST['Titolo']) && isset($_POST['Contenuto']) && isset($_POST['Utente'])){
    
    $titolo = $_POST['Titolo']; 
    $contenuto = $_POST['Contenuto'];
    $utente = $_POST['Utente'];
    $tags = implode(',',$_POST['Tags']);
    if($_POST['Categoria'] == "Appello") {$categoria = 1;}else {$categoria = 0;}
    
    
    if($query = mysqli_query($connection, "CALL su_insert_notizia('$titolo','$contenuto','$tags','$categoria','$utente')")){
        echo json_encode("Notizia postata correttamente!");
    }else echo json_encode("Errore: ".mysqli_error($connection));
}elseif (isset($_POST['Prenotazione'])) {
    
    $cod = $_POST['Prenotazione'];
    if($query = mysqli_query($connection, "CALL su_prenota($cod)")){

        echo json_encode("Aula prenotata!");
    }else echo json_encode("Errore: ".mysqli_error($connection));
}

mysqli_close($connection);
?>