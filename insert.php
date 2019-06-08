<?php

require_once('server.php');

if(isset($_POST['Titolo']) && isset($_POST['Contenuto']) && isset($_POST['Utente'])){
    
    $titolo = addslashes($_POST['Titolo']); 
    $contenuto = addslashes($_POST['Contenuto']);
    $utente = $_POST['Utente'];
    $tags = implode(',',$_POST['Tags']);
    $aula = $_POST['Aula'];
    
    $dataAppello = $_POST['Data'];
    $dateAppello = date("Y-m-d H:i:s",strtotime($dataAppello));
    if($_POST['Categoria'] == "Appello") {$categoria = 1;}else {$categoria = 0;}
    
    
    if($query = mysqli_query($connection, "CALL su_insert_notizia('$titolo','$contenuto','$tags','$categoria','$aula','$dataAppello','$utente')")){
        echo json_encode("Notizia postata correttamente!");
        
    }else echo json_encode("Errore: ".mysqli_error($connection));

}elseif (isset($_POST['Prenotazione'])) {
    
    $cod = $_POST['Prenotazione'];
    $utente = $_POST['Utente'];
    if($query = mysqli_query($connection, "CALL su_prenota($cod,'$utente')")){

        echo json_encode("Aula prenotata!");
    }else echo json_encode("Errore: ".mysqli_error($connection));

}elseif (isset($_POST['Titolo']) && isset($_POST['Bug'])) {
    
    $titolo = $_POST['Titolo'];
    $bug = $_POST['Bug'];
    $utente = $_POST['Utente'];
    if($query = mysqli_query($connection, "CALL su_report('$titolo','$bug','$utente')") ){

        echo json_encode("Report effettuato!");
    }else echo json_encode("Errore: ".mysqli_error($connection));
}

mysqli_close($connection);
?>